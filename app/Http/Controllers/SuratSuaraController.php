<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Calons;
use App\Models\Desa;
use App\Models\Partais;
use App\Models\Dapils;
use App\Models\Kabkota;
use App\Models\Kecamatan;
use App\Models\Kursidapils;
use App\Models\Provinsi;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SuratSuaraController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jenis_kelamin_summary = Calons::groupBy('jenis_kelamin')->select('jenis_kelamin', DB::raw('count(1) as jumlah'))->get();
        // $jenis_dewan_result = DB::table('calons')
        // ->join('dapils', 'calons.kode_dapil', '=', 'dapils.kode_dapil')
        // ->select('dapils.jenis_dewan', DB::raw('count(calons.id) as jumlah'))
        // ->groupBy('dapils.jenis_dewan')
        // ->get();

        // $jenis_dewan_summary = [];
        // foreach($jenis_dewan_result as $jenis_dewan){
        //     $jenis_dewan_summary[$jenis_dewan->jenis_dewan] = number_format($jenis_dewan->jumlah);
        // }

        // $data = [
        //     'summary' => [
        //         'jenis_kelamin' => $jenis_kelamin_summary,
        //         'jenis_dewan' => $jenis_dewan_summary,
        //     ]
        // ];

        // $calon_provinsi = DB::select("SELECT provinsis.kode_wilayah, COUNT(1) as jumlah_caleg FROM `provinsis` JOIN calons WHERE LEFT(calons.kode_dapil, 2) = provinsis.kode_wilayah GROUP BY provinsis.kode_wilayah, LEFT(calons.kode_dapil, 2)");

        // $data = json_encode(json_decode($calon_provinsi, TRUE));
        // $data_provinsi = json_encode($calon_provinsi);
        // echo $data_provinsi;die();

        $this->meta->setTitle(config('app.meta')['home']['title']);

        $data_json = '{"summary":{"jenis_kelamin":[{"jenis_kelamin":"LAKI - LAKI","jumlah":163174},{"jenis_kelamin":"PEREMPUAN","jumlah":95136}],"jenis_dewan":{"dpr":"9,917","dpd":"668","dprdp":"32,873","dprdk":"214,852"},"data_provinsi":[{"kode_wilayah":"11","jumlah_caleg":10438},{"kode_wilayah":"12","jumlah_caleg":14717},{"kode_wilayah":"13","jumlah_caleg":8103},{"kode_wilayah":"14","jumlah_caleg":7366},{"kode_wilayah":"15","jumlah_caleg":5405},{"kode_wilayah":"16","jumlah_caleg":9413},{"kode_wilayah":"17","jumlah_caleg":3836},{"kode_wilayah":"18","jumlah_caleg":7357},{"kode_wilayah":"19","jumlah_caleg":3119},{"kode_wilayah":"21","jumlah_caleg":3255},{"kode_wilayah":"31","jumlah_caleg":2216},{"kode_wilayah":"32","jumlah_caleg":21320},{"kode_wilayah":"33","jumlah_caleg":20198},{"kode_wilayah":"34","jumlah_caleg":3442},{"kode_wilayah":"35","jumlah_caleg":22796},{"kode_wilayah":"36","jumlah_caleg":6953},{"kode_wilayah":"51","jumlah_caleg":3775},{"kode_wilayah":"52","jumlah_caleg":6403},{"kode_wilayah":"53","jumlah_caleg":10367},{"kode_wilayah":"61","jumlah_caleg":7368},{"kode_wilayah":"62","jumlah_caleg":5250},{"kode_wilayah":"63","jumlah_caleg":5652},{"kode_wilayah":"64","jumlah_caleg":5325},{"kode_wilayah":"65","jumlah_caleg":2123},{"kode_wilayah":"71","jumlah_caleg":4789},{"kode_wilayah":"72","jumlah_caleg":6446},{"kode_wilayah":"73","jumlah_caleg":10755},{"kode_wilayah":"74","jumlah_caleg":6123},{"kode_wilayah":"75","jumlah_caleg":2538},{"kode_wilayah":"76","jumlah_caleg":2477},{"kode_wilayah":"81","jumlah_caleg":5339},{"kode_wilayah":"82","jumlah_caleg":4517},{"kode_wilayah":"91","jumlah_caleg":4348},{"kode_wilayah":"92","jumlah_caleg":2900},{"kode_wilayah":"93","jumlah_caleg":1949},{"kode_wilayah":"94","jumlah_caleg":4026},{"kode_wilayah":"95","jumlah_caleg":3560},{"kode_wilayah":"96","jumlah_caleg":2346}]}}';

        $data = json_decode($data_json, TRUE);

        $data["geo_provinsi"] = json_decode($this->getJsonKoordinat(), TRUE);

        return Inertia::render('Home',  $data);
    }

    public function calon(Request $request){
        $this->meta->setMeta(config('app.meta')['calon']);
        $this->meta->addMetaKeywords([
            "cari calon anggota legislatif",
            "cari caleg dpr",
            "cari caleg dpd",
            "cari caleg dprd provinsi",
            "cari caleg dprd kabupaten",
            "cari caleg dprd kota",
        ]);
        $page = $request->input('page');
        if(!is_numeric($page)){
            $page = 0;
        }
        if($calons = $this->cache->get('calon_search:'.Str::slug(strtolower($request->input('search'))).":".$page)){
            $calons = json_decode($calons);
        }else{
            $calons = Calons::
            query()->with(['dapil', 'partai'])
            ->when($request->input('search'), function($query, $search){
                $query->where('nama', 'like', "%{$search}%")
                ->orderByRaw("case when nama = '{$search}' or nama like '{$search},%' then 1 when nama like '{$search} %' then 2 when nama like '% {$search}' then 3 when nama like '{$search}%' then 4 else 5 end, id")
                ;
            })
            ->paginate(20)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->nama,
                'kode_dapil' => $user->kode_dapil,
                'nama_partai' => $user->partai && $user->partai->nama ? $user->partai->nama : "Non Partai",
                'jenis_dewan' => $user->dapil->jenis_dewan,
                'nama_dapil' => $user->dapil->nama_dapil,
            ]);
            $this->cache->set('calon_search:'.Str::slug(strtolower($request->input('search'))).":".$page, json_encode($calons));
        }

        return Inertia::render('Calon',[
            'users' => $calons,
            'filters' => $request->only(['search'])
        ]);
    }

    public function dapil(Request $request)
    {
        $page = $request->input('page');
        if(!is_numeric($page)){
            $page = 0;
        }
        if($dapils = $this->cache->get('dapil_search:'.Str::slug(strtolower($request->input('search'))).":".$page)){
            $dapils = json_decode($dapils);
        }else{
            $dapils = Dapils::query()
            ->when($request->input('search'), function($query, $search){
                $query->where('nama_dapil', 'like', "{$search}%")->orWhere('nama_dapil', 'like', "% {$search}%");
            })
            ->paginate(20)
            ->withQueryString()
            ->through(fn($data) => [
                'id' => $data->id,
                'nama' => $data->nama_dapil,
                'kode_dapil' => $data->kode_dapil,
                'jenis_dewan' => $data->jenis_dewan,
            ]);
            $this->cache->set('dapil_search:'.Str::slug(strtolower($request->input('search'))).":".$page, json_encode($dapils));
        }

        $this->meta->setMeta(config('app.meta')['dapil']);
        $this->meta->addMetaKeywords([
            "surat suara berdasarkan daerah pemilihan",
        ]);

        return Inertia::render('Dapil',[
            'dapils' => $dapils,
            'filters' => $request->only(['search'])
        ]);
    }

    public function wilayah(Request $request)
    {
        $page = $request->input('page');
        if(!is_numeric($page)){
            $page = 0;
        }
        $search = $request->input('search');

        if($wilayahs = $this->cache->get('wilayah_search:'.Str::slug(strtolower($search)).":".$page)){
            $wilayahs = json_decode($wilayahs);
        }else{
            $wilayahs = Desa::rightJoin('kecamatans', 'desas.id_kecamatan', '=', 'kecamatans.id')
            ->rightJoin('kabkotas', 'kecamatans.id_kabkota', '=', 'kabkotas.id')
            ->rightJoin('provinsis', 'kabkotas.id_provinsi', '=', 'provinsis.id')
            ->where('desas.nama', 'like', "{$search}%")->orWhere('desas.nama', 'like', "% {$search}%")
            ->orWhere('kecamatans.nama', 'like', "{$search}%")->orWhere('kecamatans.nama', 'like', "% {$search}%")
            ->orWhere('kabkotas.nama', 'like', "{$search}%")->orWhere('kabkotas.nama', 'like', "% {$search}%")
            ->orWhere('provinsis.nama', 'like', "{$search}%")->orWhere('provinsis.nama', 'like', "% {$search}%")
            ->select(['desas.id AS id_desa', 'desas.nama AS nama_desa', 'kecamatans.id AS id_kecamatan', 'kecamatans.nama AS nama_kecamatan', 'kabkotas.id AS id_kabkota', 'kabkotas.nama AS nama_kabkota', 'provinsis.id AS id_provinsi', 'provinsis.nama AS nama_provinsi', DB::raw("(CASE WHEN desas.kode_wilayah IS NOT NULL THEN desas.kode_wilayah WHEN kecamatans.kode_wilayah IS NOT NULL THEN kecamatans.kode_wilayah WHEN kabkotas.kode_wilayah IS NOT NULL THEN kabkotas.kode_wilayah ELSE provinsis.kode_wilayah END) AS kode_wilayah")])
            ->orderByRaw("case when desas.nama = '{$search}' then 1 when kecamatans.nama = '{$search}' then 2 when kabkotas.nama = '{$search}' then 3 when provinsis.nama = '{$search}' then 4
            when desas.nama like '{$search}%' then 5 when kecamatans.nama like '{$search}%' then 6 when kabkotas.nama like '{$search}%' then 7 when provinsis.nama like '{$search}%' then 8
            when desas.nama like '% {$search}' then 9 when kecamatans.nama like '% {$search}' then 10 when kabkotas.nama like '% {$search}' then 11 when provinsis.nama like '% {$search}' then 12
            when desas.nama like '%{$search}' then 13 when kecamatans.nama like '%{$search}' then 14 when kabkotas.nama like '%{$search}' then 15 when provinsis.nama like '%{$search}' then 16
            else 17 end")
            ->paginate(20)
            ->withQueryString()
            ;
            $this->cache->set('wilayah_search:'.Str::slug(strtolower($search)).":".$page, json_encode($wilayahs));
        }

        $this->meta->setMeta(config('app.meta')['wilayah']);
        $this->meta->addMetaKeywords([
            "surat suara berdasarkan wilayah",
        ]);

        return Inertia::render('Wilayah',[
            'wilayahs' => $wilayahs,
            'filters' => $request->only(['search'])
        ]);

    }

    public function get_list_wilayah_by_dapil(Request $request){
        if(!is_numeric($request->input('kode_dapil'))){
            return response()->json([
                'message' => "kode dapil is required"
            ], 404);
        }

        if(strlen($request->input('kode_dapil')) == 2){
            if($result = $this->cache->get('wilayah_by_kode_dapil:'.$request->input('kode_dapil'))){
                $result = json_decode($result);
            }else{
                $result = Provinsi::where('kode_wilayah', '=', $request->input('kode_dapil'))
                ->select(['nama'])
                ->first();
                $this->cache->set('wilayah_by_kode_dapil:'.$request->input('kode_dapil'), json_encode($result));
            }
            if(!$result){
                return response()->json([
                    'message' => "dapil tidak ditemukan"
                ], 404);
            }else{
                $wilayahs = [];
                $wilayahs["Provinsi"][] = $result->nama;
                return response()->json([
                    $wilayahs
                ], 200);
            }
        }
        if($result = $this->cache->get('wilayah_by_kode_dapil:'.$request->input('kode_dapil'))){
            $result = json_decode($result);
        }else{
            $result = Wilayah::where('kode_dapil', '=', $request->input('kode_dapil'))
            ->select(['tingkatan_wilayah', 'nama_wilayah'])
            ->get();
            if($result->isEmpty()){
                $result = null;
            }
            $this->cache->set('wilayah_by_kode_dapil:'.$request->input('kode_dapil'), json_encode($result));
        }

        if(empty($result)){
            return response()->json([
                'message' => "dapil tidak ditemukan"
            ], 404);
        }else{
            $wilayahs = [];
            foreach($result as $wilayah){
                $wilayahs[$wilayah->tingkatan_wilayah][] = ucwords(strtolower($wilayah->nama_wilayah));
            }
            return response()->json([
                $wilayahs
            ], 200);
        }
    }

    public function jenis(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "", string $calon_id = "")
    {
        switch ($jenis) {
            case 'dprdp':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-provinsi/{$nama_dapil}/{$kode_dapil}";
                if(strlen($nama_calon)>0 && is_numeric($calon_id)){
                    $url_redirect .= "/{$nama_calon}/{$calon_id}";
                }
                return redirect($url_redirect, 301);
                break;

            case 'dprdk':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-kabkota/{$nama_dapil}/{$kode_dapil}";
                if(strlen($nama_calon)>0 && is_numeric($calon_id)){
                    $url_redirect .= "/{$nama_calon}/{$calon_id}";
                }
                return redirect($url_redirect, 301);
                break;

            case 'dprd-provinsi':
                $jenis = "dprdp";
                break;

            case 'dprd-kabkota':
                $jenis = "dprdk";
                break;
            
            default:
                break;
        }
        if(!empty(config('app.meta')['surat-suara'][$jenis]['description'])){
            $meta_desc = config('app.meta')['surat-suara'][$jenis]['description'];
            $this->meta->setTitle(config('app.meta')['surat-suara'][$jenis]['title']);
        }

        if($jenis === "pilpres"){
            $metadata = ['description' => $meta_desc] ;
            $this->meta->setMeta($metadata);
            $this->meta->addMetaKeywords([
                "capres dan cawapres",
                "calon presiden dan calon wakil presiden",
                "anies rasyid baswedan dan muhaimin iskanda",
                "prabowo soebianto dan gibran rakabuming raka",
                "ganjar pranowo dan mahfud md",
            ]);
            return Inertia::render('SuratSuaraPilpres');
            exit();
        }elseif($jenis === "dpd"){
            if($dapil = $this->cache->get('dapil:'.$kode_dapil)){
                $dapil = json_decode($dapil);
            }else{
                $dapil = Dapils::query()
                ->where('kode_dapil', $kode_dapil)
                ->first();
                $this->cache->set('dapil:'.$kode_dapil, json_encode($dapil));
            }

            $calon_keyword = "calon dewan perwakilan daerah provinsi ".trim(strtolower($dapil->nama_dapil));

            $this->meta->setTitle("Surat Suara DPD {$dapil->nama_dapil}");

            $template = "SuratSuaraDpd";

            if($calons = $this->cache->get('calons_by_dapil:'.$kode_dapil)){
                $calons = json_decode($calons);
            }else{
                $calons = Calons::where('kode_dapil', $kode_dapil)
                ->orderBy('no_urut')
                ->get();
                $this->cache->set('calons_by_dapil:'.$kode_dapil, json_encode($calons));
            }

            $data = [
                'calons' => $calons,
                'dapil' => $dapil
            ];
        }else{
            if($partais = $this->cache->get('partais_by_dapil:'.$kode_dapil)){
                $partais = json_decode($partais);
            }else{
                $partais = Partais::with(['calons' => function($query) use ($kode_dapil){
                    $query->where('kode_dapil', $kode_dapil)->orderBy('calons.no_urut');
                }])
                ->orderBy('partais.no_urut')
                ->get()
                ->map(function($partai){
                    return count($partai->calons) > 0 ? [
                        'id' => $partai->id,
                        'no_urut' => $partai->no_urut,
                        'nama' => $partai->nama,
                        'calons' => $partai->calons->map(function($calon){
                            return [
                                'id' => $calon->id,
                                'nama' => $calon->nama,
                                'no_urut' => $calon->no_urut,
                            ];
                        }),
                    ] : false;
                })
                ->reject(function ($partai) {
                    return empty($partai);
                })
                ->toArray();
                $this->cache->set('partais_by_dapil:'.$kode_dapil, json_encode($partais));
            }
            if($dapil = $this->cache->get('dapil:'.$kode_dapil)){
                $dapil = json_decode($dapil);
            }else{
                $dapil = Dapils::query()
                ->where('kode_dapil', $kode_dapil)
                ->first();
                $this->cache->set('dapil:'.$kode_dapil, json_encode($dapil));
            }

            switch ($jenis) {
                case 'dpr':
                    $template = "SuratSuaraDpr";
                    $calon_keyword = "calon dewan perwakilan rakyat daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->setTitle("Surat Suara DPR RI Dapil {$dapil->nama_dapil}");
                    break;
                
                case 'dprdp':
                    $template = "SuratSuaraDprdp";
                    $calon_keyword = "calon dewan perwakilan rakyat daerah provinsi ".trim(strtolower($this->replaceLastWord($dapil->nama_dapil)))." dapil ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->setTitle("Surat Suara DPRD Provinsi Dapil {$dapil->nama_dapil}");
                    break;
                
                case 'dprdk':
                    $template = "SuratSuaraDprdk";
                    $calon_keyword = "calon dewan perwakilan rakyat daerah ".trim(strtolower($this->prependIfNot('kota', $this->replaceLastWord($dapil->nama_dapil), 'KABUPATEN ')))." dapil ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->setTitle("Surat Suara DPRD Kabupaten/Kota Dapil {$dapil->nama_dapil}");
                    break;
                
                default:
                    abort(404);
                    exit();
                    break;
            }
    
                $data = [
                'partais' => $partais,
                'dapil' => $dapil
            ];
        }

        $meta_desc = preg_replace('/\[nama_dapil\]/', $dapil->nama_dapil, $meta_desc);
        $meta_desc = preg_replace('/\[nama_wilayah\]/', $dapil->nama_dapil, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        if(!empty($calon_keyword)){
            $this->meta->addMetaKeywords([
                $calon_keyword,
            ]);
        }

        if(!empty($data['dapil']) && is_numeric($calon_id)){
            $this->meta->set_canonical("{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/{$request->segment(2)}/{$nama_dapil}/{$kode_dapil}");
            if($calon = $this->cache->get('profil_calon_suara:'.$calon_id)){
                $calon = json_decode($calon);
                $metadata['description'] = "{$calon->nama}, {$calon_keyword}. Lihat Surat Suara disini.";
                $this->meta->addMetaKeywords([
                    strtolower(str_replace(",", ".", $calon->nama))
                ]);
            }else{
                if($calon = Calons::find($calon_id)){
                    $this->cache->set('profil_calon_suara:'.$calon_id, json_encode($calon));
                    $metadata['description'] = "{$calon->nama}, {$calon_keyword}. Lihat Surat Suara disini.";
                    $this->meta->addMetaKeywords([
                        strtolower(str_replace(",", ".", $calon->nama))
                    ]);
                    $data['calon_id'] = $calon_id;
                }
            }
        }

        $this->meta->setMeta($metadata);

        return Inertia::render($template, $data);
    }

    public function real_count(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "", string $calon_id = "")
    {
        switch ($jenis) {
            case 'dprdp':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-provinsi/{$nama_dapil}/{$kode_dapil}";
                if(strlen($nama_calon)>0 && is_numeric($calon_id)){
                    $url_redirect .= "/{$nama_calon}/{$calon_id}";
                }
                return redirect($url_redirect, 301);
                break;

            case 'dprdk':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-kabkota/{$nama_dapil}/{$kode_dapil}";
                if(strlen($nama_calon)>0 && is_numeric($calon_id)){
                    $url_redirect .= "/{$nama_calon}/{$calon_id}";
                }
                return redirect($url_redirect, 301);
                break;

            case 'dprd-provinsi':
                $jenis = "dprdp";
                break;

            case 'dprd-kabkota':
                $jenis = "dprdk";
                break;
            
            default:
                break;
        }
        if(!empty(config('app.meta')['real-count'][$jenis]['description'])){
            $meta_desc = config('app.meta')['real-count'][$jenis]['description'];
            $this->meta->setTitle(config('app.meta')['real-count'][$jenis]['title']);
        }

        if($jenis === "pilpres"){
            $metadata = ['description' => $meta_desc] ;
            $this->meta->setMeta($metadata);
            $this->meta->addMetaKeywords([
                "capres dan cawapres",
                "calon presiden dan calon wakil presiden",
                "anies rasyid baswedan dan muhaimin iskanda",
                "prabowo soebianto dan gibran rakabuming raka",
                "ganjar pranowo dan mahfud md",
            ]);

            $master = null;
            if($master = $this->cache->get('hitung_suara:pilpres:calon')){
                $master = json_decode($master);
            }else{
                $response_master = $this->sirekap->getData('https://sirekap-obj-data.kpu.go.id/pemilu/ppwp.json');
                if($response_master->ok()){
                    $master = $response_master->object();
                    $this->cache->set('hitung_suara:pilpres:calon', json_encode($master));
                }
            }

            $wilayah = null;
            if($wilayah = $this->cache->get('hitung_suara:pilpres:wilayah')){
                $wilayah = json_decode($wilayah);
            }else{
                $response_wilayah = $this->sirekap->getData('https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/ppwp/0.json');
                if($response_wilayah->ok()){
                    $wilayah = $response_wilayah->object();
                    $this->cache->set('hitung_suara:pilpres:wilayah', json_encode($wilayah));
                }
            }

            $data = null;
            if($data = $this->cache->get('hitung_suara:pilpres:data')){
                $data = json_decode($data);
            }else{
                $response_data = $this->sirekap->getData('https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/ppwp.json');
                if($response_data->ok()){
                    $data = $response_data->object();
                    $this->cache->setex('hitung_suara:pilpres:data', 120, json_encode($data));
                }
            }
            $result = ['data' => $data, 'master' => $master, 'wilayah' => $wilayah ];
            
            return Inertia::render('RealCountPilpres', $result);
            exit();
        }elseif($jenis === "dpd"){
            if($dapil = $this->cache->get('dapil:'.$kode_dapil)){
                $dapil = json_decode($dapil);
                echo "DAPIL CACHED<br>";
            }else{
                $dapil = Dapils::query()
                ->where('kode_dapil', $kode_dapil)
                ->first();
                $this->cache->set('dapil:'.$kode_dapil, json_encode($dapil));
            }

            if(empty($dapil) || !isset($dapil->nama_dapil)){
                abort(404);
                exit();
            }

            $master = null;
            if($master = $this->cache->get("hitung_suara:dpd:calon:{$dapil->kode_dapil}")){
                $master = json_decode($master);
                echo "MASTER CACHED<br>";
            }else{
                $response_master = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/dpd/{$kode_dapil}.json");
                if($response_master->ok()){
                    $master = $response_master->object();
                    $this->cache->setex("hitung_suara:dpd:calon:{$dapil->kode_dapil}", 120, json_encode($master));
                }
            }

            $wilayah = null;
            if($wilayah = $this->cache->get("hitung_suara:dpd:wilayah:{$dapil->kode_dapil}")){
                $wilayah = json_decode($wilayah);
                echo "WILAYAH CACHED<br>";
            }else{
                $response_wilayah = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/ppwp/{$kode_dapil}.json");
                if($response_wilayah->ok()){
                    $wilayah = $response_wilayah->object();
                    $this->cache->setex("hitung_suara:dpd:wilayah:{$dapil->kode_dapil}", 120, json_encode($wilayah));
                }
            }

            $data = null;
            if($data = $this->cache->get("hitung_suara:dpd:dapil:{$dapil->kode_dapil}")){
                $data = json_decode($data);
                echo "DATA CACHED<br>";
            }else{
                $response_data = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/pdpd/{$kode_dapil}.json");
                if($response_data->ok()){
                    $data = $response_data->object();
                    $this->cache->setex("hitung_suara:dpd:dapil:{$dapil->kode_dapil}", 120, json_encode($data));
                }
            }

            $result = ['data' => $data, 'master' => $master, 'wilayah' => $wilayah, 'dapil' => $dapil ];
            $calon_keyword = "realcount hitung suara calon dewan perwakilan daerah provinsi ".strtolower($dapil->nama_dapil);
            $template = "RealCountDpd";
            $this->meta->setTitle("Real Count DPD {$dapil->nama_dapil}");
            $this->meta->addMetaKeywords(['senator daerah']);
        }else{
            $master_partai = null;
            if($master_partai = $this->cache->get('hitung_suara:master_partai')){
                $master_partai = json_decode($master_partai);
            }else{
                $response_master_partai = $this->sirekap->getData('https://sirekap-obj-data.kpu.go.id/pemilu/partai.json');
                if($response_master_partai->ok()){
                    $master_partai = $response_master_partai->object();
                    $this->cache->setex('hitung_suara:master_partai', 120, json_encode($master_partai));
                }
            }

            if($dapil = $this->cache->get('dapil:'.$kode_dapil)){
                $dapil = json_decode($dapil);
            }else{
                $dapil = Dapils::query()
                ->where('kode_dapil', $kode_dapil)
                ->first();
                $this->cache->set('dapil:'.$kode_dapil, json_encode($dapil));
            }

            if(empty($dapil) || !isset($dapil->nama_dapil)){
                abort(404);
                exit();
            }

            switch ($jenis) {
                case 'dpr':

                    $data_higher_level = null;

                    if($data_higher_level = $this->cache->get('hitung_suara:dpr:nasional')){
                        $data_higher_level = json_decode($data_higher_level);
                    }else{
                        $response_data_higher_level = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdpr/0.json");
                        if($response_data_higher_level->ok()){
                            $data_higher_level = $response_data_higher_level->object();
                            $this->cache->setex('hitung_suara:dpr:nasional', 120, json_encode($data_higher_level));
                        }
                    }

                    $data_lower_level = null;
                    if($data_lower_level = $this->cache->get('hitung_suara:dpr:dapil:'.$dapil->kode_dapil)){
                        $data_lower_level = json_decode($data_lower_level);
                    }else{
                        $response_data_lower_level = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdpr/{$dapil->kode_dapil}.json");
                        if($response_data_lower_level->ok()){
                            $data_lower_level = $response_data_lower_level->object();
                            $this->cache->setex('hitung_suara:dpr:dapil:'.$dapil->kode_dapil, 120, json_encode($data_lower_level));
                        }
                    }

                    $master_calon = null;
                    if($master_calon = $this->cache->get('hitung_suara:dpr:calon:'.$dapil->kode_dapil)){
                        $master_calon = json_decode($master_calon);
                    }else{
                        $response_master_calon = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/partai/{$dapil->kode_dapil}.json");
                        if($response_master_calon->ok()){
                            $master_calon = $response_master_calon->object();
                            $this->cache->setex('hitung_suara:dpr:calon:'.$dapil->kode_dapil, 120, json_encode($master_calon));
                        }
                    }

                    $result = [
                        'master_partai' => $master_partai,
                        'master_calon' => $master_calon,
                        'higher_data' => $data_higher_level,
                        'lower_data' => $data_lower_level,
                        'dapil' => $dapil
                    ];
    
                    $template = "RealCountDpr";
                    $this->meta->setTitle("Real Count DPR RI Dapil {$dapil->nama_dapil}");
                    $calon_keyword = "realcount hitung suara calon dewan perwakilan rakyat daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->addMetaKeywords(['ambang batas parlemen', 'parliamentary treshold', 'metode sainte lague']);
                    break;
                
                case 'dprdp':
                    $data = null;
                    if($data = $this->cache->get('hitung_suara:dprdp:dapil:'.$dapil->kode_dapil)){
                        $data = json_decode($data);
                    }else{
                        $kode_prov = substr($dapil->kode_dapil, 0, 2);
                        $response_data = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdprdp/{$kode_prov}/{$dapil->kode_dapil}.json");
                        if($response_data->ok()){
                            $data = $response_data->object();
                            $this->cache->setex('hitung_suara:dprdp:dapil:'.$dapil->kode_dapil, 120, json_encode($data));
                        }
                    }

                    $master_calon = null;
                    if($master_calon = $this->cache->get('hitung_suara:dprdp:calon:'.$dapil->kode_dapil)){
                        $master_calon = json_decode($master_calon);
                    }else{
                        $response_master_calon = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/partai/{$dapil->kode_dapil}.json");
                        if($response_master_calon->ok()){
                            $master_calon = $response_master_calon->object();
                            $this->cache->setex('hitung_suara:dprdp:calon:'.$dapil->kode_dapil, 120, json_encode($master_calon));
                        }
                    }

                    $result = [
                        'master_partai' => $master_partai,
                        'master_calon' => $master_calon,
                        'data' => $data,
                        'dapil' => $dapil
                    ];
    
                    $template = "RealCountDprdp";
                    $exp_dapil = explode(" ", $dapil->nama_dapil);
                    array_pop($exp_dapil);
                    $nama_wilayah = implode(" ", $exp_dapil);
                    $this->meta->setTitle("Real Count DPRD Provinsi {$nama_wilayah} Dapil {$dapil->nama_dapil}");
                    $calon_keyword = "realcount hitung suara calon dewan perwakilan rakyat provinsi {$nama_wilayah} daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->addMetaKeywords(['metode sainte lague']);
                    break;
                
                case 'dprdk':
                    $data = null;
                    if($data = $this->cache->get('hitung_suara:dprdk:dapil:'.$dapil->kode_dapil)){
                        $data = json_decode($data);
                    }else{
                        $kode_prov = substr($dapil->kode_dapil, 0, 2);
                        $kode_kabkota = substr($dapil->kode_dapil, 0, 4);
                        $response_data = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdprdk/{$kode_prov}/{$kode_kabkota}/{$dapil->kode_dapil}.json");
                        if($response_data->ok()){
                            $data = $response_data->object();
                            $this->cache->setex('hitung_suara:dprdk:dapil:'.$dapil->kode_dapil, 120, json_encode($data));
                        }
                    }

                    $master_calon = null;
                    if($master_calon = $this->cache->get('hitung_suara:dprdk:calon:'.$dapil->kode_dapil)){
                        $master_calon = json_decode($master_calon);
                    }else{
                        $response_master_calon = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/partai/{$dapil->kode_dapil}.json");
                        if($response_master_calon->ok()){
                            $master_calon = $response_master_calon->object();
                            $this->cache->setex('hitung_suara:dprdk:calon:'.$dapil->kode_dapil, 120, json_encode($master_calon));
                        }
                    }

                    $result = [
                        'master_partai' => $master_partai,
                        'master_calon' => $master_calon,
                        'data' => $data,
                        'dapil' => $dapil
                    ];

                    $template = "RealCountDprdk";
                    $exp_dapil = explode(" ", $dapil->nama_dapil);
                    array_pop($exp_dapil);
                    $nama_wilayah = implode(" ", $exp_dapil);
                    if(!preg_match("/^KOTA/i", $nama_wilayah)){
                        $nama_wilayah = "KABUPATEN ".$nama_wilayah;
                    }
                    $this->meta->setTitle("Real Count DPRD {$nama_wilayah} Dapil {$dapil->nama_dapil}");
                    $calon_keyword = "realcount hitung suara calon dewan perwakilan rakyat kabupaten kota {$nama_wilayah} daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->addMetaKeywords(['metode sainte lague']);
                    break;
                
                default:
                    abort(404);
                    exit();
                    break;
            }
        }

        $meta_desc = preg_replace('/\[nama_dapil\]/', $dapil->nama_dapil, $meta_desc);
        $meta_desc = preg_replace('/\[nama_wilayah\]/', $dapil->nama_dapil, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        if(!empty($calon_keyword)){
            $this->meta->addMetaKeywords([
                $calon_keyword,
            ]);
        }

        if(!empty($dapil) && is_numeric($calon_id)){
            $this->meta->set_canonical("{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/{$request->segment(2)}/{$nama_dapil}/{$kode_dapil}");
            if($calon = $this->cache->get('profil_calon_suara:'.$calon_id)){
                $calon = json_decode($calon);
                $metadata['description'] = "{$calon->nama}, {$calon_keyword}. Lihat Surat Suara disini.";
                $this->meta->addMetaKeywords([
                    strtolower(str_replace(",", ".", $calon->nama))
                ]);
            }else{
                if($calon = Calons::find($calon_id)){
                    $this->cache->set('profil_calon_suara:'.$calon_id, json_encode($calon));
                    $metadata['description'] = "{$calon->nama}, {$calon_keyword}. Lihat Surat Suara disini.";
                    $this->meta->addMetaKeywords([
                        strtolower(str_replace(",", ".", $calon->nama))
                    ]);
                }
            }
            if($calon){
                $result["calon"] = $calon;
                $this->meta->setTitle("Perolehan Suara {$calon->nama}");
            }
        }

        $this->meta->setMeta($metadata);

        return Inertia::render($template, $result);
    }

    public function calon_lolos(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "")
    {
        switch ($jenis) {
            case 'dprdp':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-provinsi/{$nama_dapil}/{$kode_dapil}";
                return redirect($url_redirect, 301);
                break;

            case 'dprdk':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-kabkota/{$nama_dapil}/{$kode_dapil}";
                return redirect($url_redirect, 301);
                break;

            case 'dprd-provinsi':
                $jenis = "dprdp";
                break;

            case 'dprd-kabkota':
                $jenis = "dprdk";
                break;
            
            default:
                break;
        }
        if(!empty(config('app.meta')['calon-lolos'][$jenis]['description'])){
            $meta_desc = config('app.meta')['calon-lolos'][$jenis]['description'];
            $this->meta->setTitle(config('app.meta')['calon-lolos'][$jenis]['title']);
        }

        if($jenis === "dpd"){
            if($result = $this->cache->get('hitung_suara:dpd:'.$kode_dapil)){
                $result = json_decode($result, true);
                $dapil = (object) $result["dapil"];
            }else{
                if($dapil = $this->cache->get('dapil:'.$kode_dapil)){
                    $dapil = json_decode($dapil);
                }else{
                    $dapil = Dapils::query()
                    ->where('kode_dapil', $kode_dapil)
                    ->first();
                    $this->cache->set('dapil:'.$kode_dapil, json_encode($dapil));
                }
    
                if(empty($dapil) || !isset($dapil->nama_dapil)){
                    abort(404);
                    exit();
                }
            }

            if($data_calon_lolos = $this->cache->get("hitung_suara:dpd:calon_lolos:{$dapil->kode_dapil}")){
                $data_calon_lolos = json_decode($data_calon_lolos, true);
            }else{
                $master = null;
                if($master = $this->cache->get("hitung_suara:dpd:calon:{$dapil->kode_dapil}")){
                    $master = json_decode($master);
                }else{
                    $response_master = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/dpd/{$kode_dapil}.json");
                    if($response_master->ok()){
                        $master = $response_master->object();
                        $this->cache->setex("hitung_suara:dpd:calon:{$dapil->kode_dapil}", 120, json_encode($master));
                    }
                }
    
                $master = (array) $master;
    
                $data = null;
                if($data = $this->cache->get("hitung_suara:dpd:dapil:{$dapil->kode_dapil}")){
                    $data = json_decode($data);
                }else{
                    $response_data = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/pdpd/{$kode_dapil}.json");
                    if($response_data->ok()){
                        $data = $response_data->object();
                        $this->cache->setex("hitung_suara:dpd:dapil:{$dapil->kode_dapil}", 120, json_encode($data));
                    }
                }
    
                $data_suara = (array)$data->chart;
    
                foreach ( $data_suara as $key => $value )   {
                    if ( !is_numeric ($key) )    {
                        unset ( $data_suara [ $key ] );
                        break;
                    }
                }
    
                arsort($data_suara);

                $jumlah_total = array_sum($data_suara);
    
                $data_suara = array_slice($data_suara, 0, 4, true);
    
                $data_calon_lolos = [];
    
                foreach ($data_suara as $key_calon => $jumlah_suara) {
                    if($calon = $this->cache->get("cari_profil:{$kode_dapil}::{$master[$key_calon]->nomor_urut}")){
                        $calon = json_decode($calon);
                    }else{
                        $calon = Calons::with('dapil')->where('calons.kode_dapil', $kode_dapil)->where('calons.no_urut', $master[$key_calon]->nomor_urut)->first();
                        if($calon){
                            $this->cache->set("cari_profil:{$kode_dapil}::{$master[$key_calon]->nomor_urut}", json_encode($calon));
                        }
                    }

                    if(empty($calon)){
                        $foto = null;
                        $url_profil = '#';
                    }else{
                        $foto = $calon->foto;
                        $url_profil = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/profil-calon/dpd/".Str::slug(strtolower($calon->dapil->nama_dapil))."/{$kode_dapil}/".Str::slug(strtolower($calon->nama))."/{$calon->id}";
                    }

                    $data_calon_lolos['list'][] = [
                        'nama' => $master[$key_calon]->nama,
                        'nomor_urut' => $master[$key_calon]->nomor_urut,
                        'foto' => $foto,
                        'url_profil' => $url_profil,
                        'jumlah_suara' => $jumlah_suara,
                        'persen' => ($jumlah_suara/$jumlah_total)*100
                    ];
                }
    
                if(!empty($data_calon_lolos['list'])){
                    $data_calon_lolos["ts"] = $data->ts;
                    $data_calon_lolos["progres"] = $data->progres;
                    $this->cache->setex("hitung_suara:dpd:calon_lolos:{$dapil->kode_dapil}", 120, json_encode($data_calon_lolos));
                }
            }

            $result = [
                'data' => $data_calon_lolos,
                'dapil' => $dapil,
            ];

            $calon_keyword = "calon dpd dewan perwakilan daerah terpilih ke senayan dapil provinsi ".strtolower($dapil->nama_dapil);
            $template = "CalonLolosDpd";
            $this->meta->setTitle("Daftar Calon DPD Terpilih Provinsi {$dapil->nama_dapil} Sementara");
            $this->meta->addMetaKeywords(['senator daerah']);
        }else{
            $master_partai = null;
            if($master_partai = $this->cache->get('hitung_suara:master_partai')){
                $master_partai = json_decode($master_partai);
            }else{
                $response_master_partai = $this->sirekap->getData('https://sirekap-obj-data.kpu.go.id/pemilu/partai.json');
                if($response_master_partai->ok()){
                    $master_partai = $response_master_partai->object();
                    $this->cache->setex('hitung_suara:master_partai', 120, json_encode($master_partai));
                }
            }

            if($dapil = $this->cache->get('dapil:'.$kode_dapil)){
                $dapil = json_decode($dapil);
            }else{
                $dapil = Dapils::query()
                ->where('kode_dapil', $kode_dapil)
                ->first();
                $this->cache->set('dapil:'.$kode_dapil, json_encode($dapil));
            }

            if($kursi_dapil = $this->cache->get('kursi_dapil:'.$kode_dapil)){
                $kursi_dapil = json_decode($kursi_dapil);
            }else{
                $kursi_dapil = Kursidapils::query()
                ->where('kode_dapil', $kode_dapil)
                ->first();
                $this->cache->set('kursi_dapil:'.$kode_dapil, json_encode($kursi_dapil));
            }

            if(empty($dapil) || !isset($dapil->nama_dapil) || empty($kursi_dapil) || !isset($kursi_dapil->jumlah_kursi)){
                abort(404);
                exit();
            }

            switch ($jenis) {
                case 'dpr':
                    $data_higher_level = null;

                    if($data_higher_level = $this->cache->get('hitung_suara:dpr:nasional')){
                        $data_higher_level = json_decode($data_higher_level);
                    }else{
                        $response_data_higher_level = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdpr/0.json");
                        if($response_data_higher_level->ok()){
                            $data_higher_level = $response_data_higher_level->object();
                            $this->cache->setex('hitung_suara:dpr:nasional', 120, json_encode($data_higher_level));
                        }
                    }

                    $partai_threshold = [];

                    $total_suara = array_sum((array) $data_higher_level->chart);

                    foreach ($data_higher_level->chart as $no_partai => $suara_partai) {
                        if(($suara_partai/$total_suara)*100 >= 4)
                            $partai_threshold[] = $no_partai;
                    }

                    $data_lower_level = null;
                    if($data_lower_level = $this->cache->get('hitung_suara:dpr:dapil:'.$dapil->kode_dapil)){
                        $data_lower_level = json_decode($data_lower_level);
                    }else{
                        $response_data_lower_level = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdpr/{$dapil->kode_dapil}.json");
                        if($response_data_lower_level->ok()){
                            $data_lower_level = $response_data_lower_level->object();
                            $this->cache->setex('hitung_suara:dpr:dapil:'.$dapil->kode_dapil, 120, json_encode($data_lower_level));
                        }
                    }

                    $master_calon = null;
                    if($master_calon = $this->cache->get('hitung_suara:dpr:calon:'.$dapil->kode_dapil)){
                        $master_calon = json_decode($master_calon);
                    }else{
                        $response_master_calon = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/partai/{$dapil->kode_dapil}.json");
                        if($response_master_calon->ok()){
                            $master_calon = $response_master_calon->object();
                            $this->cache->setex('hitung_suara:dpr:calon:'.$dapil->kode_dapil, 120, json_encode($master_calon));
                        }
                    }

                    $data_calon_lolos = null;
                    if($data_calon_lolos = $this->cache->get("hitung_suara:dpr:calon_lolos:{$dapil->kode_dapil}")){
                        $data_calon_lolos = json_decode($data_calon_lolos);
                    }else{
                        $jumlah_kursi = $kursi_dapil->jumlah_kursi;

                        $alokasi = $this->sainteLague((array) $data_lower_level->chart, $jumlah_kursi, $partai_threshold);

                        $data_calon_lolos = [];
    
                        foreach ($alokasi as $no_partai => $kursi_partai) {
                            if($kursi_partai> 0){
                                $suara_calon_partai = (array) $data_lower_level->table->$no_partai;
                                if(isset($suara_calon_partai['jml_suara_total'])){
                                    $suara_total = $suara_calon_partai['jml_suara_total'];
                                    unset($suara_calon_partai['jml_suara_total']);
                                }
                                if(isset($suara_calon_partai['jml_suara_partai'])) unset($suara_calon_partai['jml_suara_partai']);
    
                                arsort($suara_calon_partai);
    
                                $data_suara = array_slice($suara_calon_partai, 0, $kursi_partai, true);
    
                                foreach ($data_suara as $key_calon => $jumlah_suara) {
                                    if($calon = $this->cache->get("cari_profil:{$kode_dapil}:{$no_partai}:{$master_calon->$no_partai->$key_calon->nomor_urut}")){
                                        $calon = json_decode($calon);
                                    }else{
                                        $calons = Calons::with('partai', 'dapil')->where('calons.kode_dapil', $kode_dapil)->where('calons.no_urut', $master_calon->$no_partai->$key_calon->nomor_urut)->get();
                                        $calon = null;
                                        foreach ($calons as $calon) {
                                            if($calon->partai->no_urut === (int) $no_partai)
                                                break;
                                        }
                                    }
    
                                    if(empty($calon)){
                                        $foto = null;
                                        $url_profil = '#';
                                    }else{
                                        $foto = $calon->foto;
                                        $url_profil = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/profil-calon/dpr/".Str::slug(strtolower($calon->dapil->nama_dapil))."/{$kode_dapil}/".Str::slug(strtolower($calon->nama))."/{$calon->id}";
                                        $this->cache->set("cari_profil:{$kode_dapil}:{$no_partai}:{$master_calon->$no_partai->$key_calon->nomor_urut}", json_encode($calon));
                                    }
                
                                    $data_calon_lolos['list'][$no_partai]['list'][] = [
                                        'nama' => $master_calon->$no_partai->$key_calon->nama,
                                        'nomor_urut' => $master_calon->$no_partai->$key_calon->nomor_urut,
                                        'foto' => $foto,
                                        'url_profil' => $url_profil,
                                        'jumlah_suara' => $jumlah_suara,
                                    ];
                                }
    
                                $data_calon_lolos['list'][$no_partai]['jml_suara_total'] = $suara_total;
                            }
                        }
    
                        if(!empty($data_calon_lolos["list"])){
                            $data_calon_lolos["ts"] = $data_lower_level->ts;
                            $data_calon_lolos["progres"] = $data_lower_level->progres;
                            $this->cache->setex("hitung_suara:dpr:calon_lolos:{$dapil->kode_dapil}", 120, json_encode($data_calon_lolos));
                        }
                    }

                    $result = [
                        'nasional' => $data_higher_level,
                        'data' => $data_calon_lolos,
                        'master_partai' => $master_partai,
                        'dapil' => $dapil,
                        'kursi_dapil' => $kursi_dapil,
                    ];

                    $template = "CalonLolosDpr";
                    $exp_dapil = explode(" ", $dapil->nama_dapil);
                    array_pop($exp_dapil);
                    $nama_wilayah = implode(" ", $exp_dapil);
                    $this->meta->setTitle("Calon Terpilih DPR RI Dapil {$dapil->nama_dapil} Sementara Ini");
                    $calon_keyword = "calon terpilih lolos ke senayan anggota dewan perwakilan rakyat republik indonesia DPR RI daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->addMetaKeywords(['metode sainte lague', 'parliamentary treshold', 'ambang batas parlemen']);
                    break;
                
                case 'dprdp':
                    $data = null;
                    if($data = $this->cache->get('hitung_suara:dprdp:dapil:'.$dapil->kode_dapil)){
                        $data = json_decode($data);
                    }else{
                        $kode_prov = substr($dapil->kode_dapil, 0, 2);
                        $response_data = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdprdp/{$kode_prov}/{$dapil->kode_dapil}.json");
                        if($response_data->ok()){
                            $data = $response_data->object();
                            $this->cache->setex('hitung_suara:dprdp:dapil:'.$dapil->kode_dapil, 120, json_encode($data));
                        }
                    }

                    $master_calon = null;
                    if($master_calon = $this->cache->get('hitung_suara:dprdp:calon:'.$dapil->kode_dapil)){
                        $master_calon = json_decode($master_calon);
                    }else{
                        $response_master_calon = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/partai/{$dapil->kode_dapil}.json");
                        if($response_master_calon->ok()){
                            $master_calon = $response_master_calon->object();
                            $this->cache->setex('hitung_suara:dprdp:calon:'.$dapil->kode_dapil, 120, json_encode($master_calon));
                        }
                    }

                    $data_calon_lolos = null;
                    if($data_calon_lolos = $this->cache->get("hitung_suara:dprdp:calon_lolos:{$dapil->kode_dapil}")){
                        $data_calon_lolos = json_decode($data_calon_lolos);
                    }else{
                        $jumlah_kursi = $kursi_dapil->jumlah_kursi;

                        $alokasi = $this->sainteLague((array) $data->chart, $jumlah_kursi);
    
                        $data_calon_lolos = [];
    
                        foreach ($alokasi as $no_partai => $kursi_partai) {
                            if($kursi_partai> 0){
                                $suara_calon_partai = (array) $data->table->$no_partai;
                                if(isset($suara_calon_partai['jml_suara_total'])){
                                    $suara_total = $suara_calon_partai['jml_suara_total'];
                                    unset($suara_calon_partai['jml_suara_total']);
                                }
                                if(isset($suara_calon_partai['jml_suara_partai'])) unset($suara_calon_partai['jml_suara_partai']);
    
                                arsort($suara_calon_partai);
    
                                $data_suara = array_slice($suara_calon_partai, 0, $kursi_partai, true);
    
                                foreach ($data_suara as $key_calon => $jumlah_suara) {
                                    if($calon = $this->cache->get("cari_profil:{$kode_dapil}:{$no_partai}:{$master_calon->$no_partai->$key_calon->nomor_urut}")){
                                        $calon = json_decode($calon);
                                    }else{
                                        $calons = Calons::with('partai', 'dapil')->where('calons.kode_dapil', $kode_dapil)->where('calons.no_urut', $master_calon->$no_partai->$key_calon->nomor_urut)->get();
                                        $calon = null;
                                        foreach ($calons as $calon) {
                                            if($calon->partai->no_urut === (int) $no_partai)
                                                break;
                                        }
                                    }
    
                                    if(empty($calon)){
                                        $foto = null;
                                        $url_profil = '#';
                                    }else{
                                        $foto = $calon->foto;
                                        $url_profil = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/profil-calon/dprd-provinsi/".Str::slug(strtolower($calon->dapil->nama_dapil))."/{$kode_dapil}/".Str::slug(strtolower($calon->nama))."/{$calon->id}";
                                        $this->cache->set("cari_profil:{$kode_dapil}:{$no_partai}:{$master_calon->$no_partai->$key_calon->nomor_urut}", json_encode($calon));
                                    }
                
                                    $data_calon_lolos['list'][$no_partai]['list'][] = [
                                        'nama' => $master_calon->$no_partai->$key_calon->nama,
                                        'nomor_urut' => $master_calon->$no_partai->$key_calon->nomor_urut,
                                        'foto' => $foto,
                                        'url_profil' => $url_profil,
                                        'jumlah_suara' => $jumlah_suara,
                                    ];
                                }
    
                                $data_calon_lolos['list'][$no_partai]['jml_suara_total'] = $suara_total;
                            }
                        }
    
                        if(!empty($data_calon_lolos["list"])){
                            $data_calon_lolos["ts"] = $data->ts;
                            $data_calon_lolos["progres"] = $data->progres;
                            $this->cache->setex("hitung_suara:dprdp:calon_lolos:{$dapil->kode_dapil}", 120, json_encode($data_calon_lolos));
                        }
                    }

                    $result = [
                        'data' => $data_calon_lolos,
                        'master_partai' => $master_partai,
                        'dapil' => $dapil,
                        'kursi_dapil' => $kursi_dapil,
                    ];

                    $template = "CalonLolosDprdp";
                    $exp_dapil = explode(" ", $dapil->nama_dapil);
                    array_pop($exp_dapil);
                    $nama_wilayah = implode(" ", $exp_dapil);
                    $this->meta->setTitle("Calon Terpilih DPRD Provinsi {$nama_wilayah} Dapil {$dapil->nama_dapil} Sementara Ini");
                    $calon_keyword = "calon terpilih lolos parlemen anggota dewan perwakilan rakyat provinsi {$nama_wilayah} daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->addMetaKeywords(['metode sainte lague']);
                    break;
                
                case 'dprdk':
                    $data = null;
                    if($data = $this->cache->get('hitung_suara:dprdk:dapil:'.$dapil->kode_dapil)){
                        $data = json_decode($data);
                    }else{
                        $kode_prov = substr($dapil->kode_dapil, 0, 2);
                        $kode_kabkota = substr($dapil->kode_dapil, 0, 4);
                        $response_data = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdprdk/{$kode_prov}/{$kode_kabkota}/{$dapil->kode_dapil}.json");
                        if($response_data->ok()){
                            $data = $response_data->object();
                            $this->cache->setex('hitung_suara:dprdk:dapil:'.$dapil->kode_dapil, 120, json_encode($data));
                        }
                    }

                    $master_calon = null;
                    if($master_calon = $this->cache->get('hitung_suara:dprdk:calon:'.$dapil->kode_dapil)){
                        $master_calon = json_decode($master_calon);
                    }else{
                        $response_master_calon = $this->sirekap->getData("https://sirekap-obj-data.kpu.go.id/pemilu/caleg/partai/{$dapil->kode_dapil}.json");
                        if($response_master_calon->ok()){
                            $master_calon = $response_master_calon->object();
                            $this->cache->setex('hitung_suara:dprdk:calon:'.$dapil->kode_dapil, 120, json_encode($master_calon));
                        }
                    }

                    $data_calon_lolos = null;
                    if($data_calon_lolos = $this->cache->get("hitung_suara:dprdk:calon_lolos:{$dapil->kode_dapil}")){
                        $data_calon_lolos = json_decode($data_calon_lolos);
                    }else{
                        $jumlah_kursi = $kursi_dapil->jumlah_kursi;

                        $alokasi = $this->sainteLague((array) $data->chart, $jumlah_kursi);
    
                        $data_calon_lolos = [];
    
                        foreach ($alokasi as $no_partai => $kursi_partai) {
                            if($kursi_partai> 0){
                                $suara_calon_partai = (array) $data->table->$no_partai;
                                if(isset($suara_calon_partai['jml_suara_total'])){
                                    $suara_total = $suara_calon_partai['jml_suara_total'];
                                    unset($suara_calon_partai['jml_suara_total']);
                                }
                                if(isset($suara_calon_partai['jml_suara_partai'])) unset($suara_calon_partai['jml_suara_partai']);
    
                                arsort($suara_calon_partai);
    
                                $data_suara = array_slice($suara_calon_partai, 0, $kursi_partai, true);
    
                                foreach ($data_suara as $key_calon => $jumlah_suara) {
                                    if($calon = $this->cache->get("cari_profil:{$kode_dapil}:{$no_partai}:{$master_calon->$no_partai->$key_calon->nomor_urut}")){
                                        $calon = json_decode($calon);
                                    }else{
                                        $calons = Calons::with('partai', 'dapil')->where('calons.kode_dapil', $kode_dapil)->where('calons.no_urut', $master_calon->$no_partai->$key_calon->nomor_urut)->get();
                                        $calon = null;
                                        foreach ($calons as $calon) {
                                            if($calon->partai->no_urut === (int) $no_partai)
                                                break;
                                        }
                                    }
    
                                    if(empty($calon)){
                                        $foto = null;
                                        $url_profil = '#';
                                    }else{
                                        $foto = $calon->foto;
                                        $url_profil = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/profil-calon/dprd-kabkota/".Str::slug(strtolower($calon->dapil->nama_dapil))."/{$kode_dapil}/".Str::slug(strtolower($calon->nama))."/{$calon->id}";
                                        $this->cache->set("cari_profil:{$kode_dapil}:{$no_partai}:{$master_calon->$no_partai->$key_calon->nomor_urut}", json_encode($calon));
                                    }
                
                                    $data_calon_lolos['list'][$no_partai]['list'][] = [
                                        'nama' => $master_calon->$no_partai->$key_calon->nama,
                                        'nomor_urut' => $master_calon->$no_partai->$key_calon->nomor_urut,
                                        'foto' => $foto,
                                        'url_profil' => $url_profil,
                                        'jumlah_suara' => $jumlah_suara,
                                    ];
                                }
    
                                $data_calon_lolos['list'][$no_partai]['jml_suara_total'] = $suara_total;
                            }
                        }
    
                        if(!empty($data_calon_lolos["list"])){
                            $data_calon_lolos["ts"] = $data->ts;
                            $data_calon_lolos["progres"] = $data->progres;
                            $this->cache->setex("hitung_suara:dprdk:calon_lolos:{$dapil->kode_dapil}", 120, json_encode($data_calon_lolos));
                        }
                    }

                    $result = [
                        'data' => $data_calon_lolos,
                        'master_partai' => $master_partai,
                        'dapil' => $dapil,
                        'kursi_dapil' => $kursi_dapil,
                    ];

                    $template = "CalonLolosDprdk";
                    $exp_dapil = explode(" ", $dapil->nama_dapil);
                    array_pop($exp_dapil);
                    $nama_wilayah = implode(" ", $exp_dapil);
                    if(!preg_match("/^KOTA/i", $nama_wilayah)){
                        $nama_wilayah = "KABUPATEN ".$nama_wilayah;
                    }
                    $this->meta->setTitle("Calon Terpilih DPRD Provinsi {$nama_wilayah} Dapil {$dapil->nama_dapil} Sementara Ini");
                    $calon_keyword = "calon terpilih lolos parlemen anggota dewan perwakilan rakyat kabupaten kota {$nama_wilayah} daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    $this->meta->addMetaKeywords(['metode sainte lague']);
                    break;
                
                default:
                    abort(404);
                    exit();
                    break;
            }
        }

        $meta_desc = preg_replace('/\[nama_dapil\]/', $dapil->nama_dapil, $meta_desc);
        $meta_desc = preg_replace('/\[nama_wilayah\]/', $dapil->nama_dapil, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        if(!empty($calon_keyword)){
            $this->meta->addMetaKeywords([
                $calon_keyword,
            ]);
        }

        $this->meta->setMeta($metadata);

        return Inertia::render($template, $result);
    }

    public function profil(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "", string $calon_id = "")
    {
        switch ($jenis) {
            case 'dprdp':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-provinsi/{$nama_dapil}/{$kode_dapil}/{$nama_calon}/{$calon_id}";
                return redirect($url_redirect, 301);
                break;

            case 'dprdk':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-kabkota/{$nama_dapil}/{$kode_dapil}/{$nama_calon}/{$calon_id}";
                return redirect($url_redirect, 301);
                break;

            case 'dprd-provinsi':
                $jenis = "dprdp";
                break;

                case 'dprd-kabkota':
                    $jenis = "dprdk";
                break;
            
            default:
                break;
        }

        if(is_numeric($calon_id)){
            if($calon = $this->cache->get('profil_calon_id:'.$calon_id)){
                $calon = json_decode($calon);
                $this->meta->addMetaKeywords([
                    strtolower(str_replace(",", ".", $calon->nama))
                ]);
            }else{
                if($calon = Calons::with('partai', 'dapil')->find($calon_id)){
                    $this->cache->set('profil_calon_id:'.$calon_id, json_encode($calon));
                    $this->meta->addMetaKeywords([
                        strtolower(str_replace(",", ".", $calon->nama))
                    ]);
                }else{
                    abort(404);
                    exit();
                }
            }
        }else{
            abort(404);
            exit();
        }

        if(!empty(config('app.meta')['surat-suara'][$jenis]['description'])){
            $meta_desc = config('app.meta')['surat-suara'][$jenis]['description'];
        }
        $this->meta->setTitle("Profil {$calon->nama}");

        if($jenis === "dpd"){
            $calon_keyword = "calon dewan perwakilan daerah provinsi ".trim(strtolower($calon->dapil->nama_dapil));
            $template = "ProfilDpd";
            $header_title_dewan = "DEWAN PERWAKILAN DAERAH<br>REPUBLIK INDONESIA";
            if(!empty($calon->foto)){
                $foto = pathinfo($calon->foto, PATHINFO_FILENAME);
                $foto = Str::slug(strtolower($foto));
                $foto_url = config('app.url'). "/assets/img/dpd_foto/compressed/{$foto}.webp";
            }
        }else{
            $calon_keyword = "calon anggota legislatif";

            $template = "ProfilDewan";

            switch ($jenis) {
                case 'dpr':
                    $calon_keyword = "calon dewan perwakilan rakyat daerah pemilihan ".trim(strtolower($calon->dapil->nama_dapil));
                    $header_title_dewan = "DEWAN PERWAKILAN RAKYAT<br>REPUBLIK INDONESIA";
                    break;
                
                case 'dprdp':
                    $calon_keyword = "calon dewan perwakilan rakyat daerah provinsi ".trim(strtolower($this->replaceLastWord($calon->dapil->nama_dapil)))." dapil ".trim(strtolower($calon->dapil->nama_dapil));
                    $header_title_dewan = "DEWAN PERWAKILAN RAKYAT DAERAH<br>PROVINSI ".preg_replace('/\W\w+\s*(\W*)$/', '$1', $calon->dapil->nama_dapil);
                    break;
                
                case 'dprdk':
                    $calon_keyword = "calon dewan perwakilan rakyat daerah ".trim(strtolower($this->prependIfNot('kota', $this->replaceLastWord($calon->dapil->nama_dapil), 'KABUPATEN ')))." dapil ".trim(strtolower($calon->dapil->nama_dapil));
                    $header_title_dewan = "DEWAN PERWAKILAN RAKYAT DAERAH<br>".(strpos($calon->dapil->nama_dapil, "KOTA") !== 0 ? "KABUPATEN ": "").preg_replace('/\W\w+\s*(\W*)$/', '$1', $calon->dapil->nama_dapil);
                    break;
                
                default:
                    abort(404);
                    exit();
                    break;
            }
            if(!empty($calon->foto)){
                $foto_url = $calon->foto;
            }
        }
        if(!empty($foto_url)){
            $metaimage = [
                'image' => $foto_url,
                'image:type' => 'image/'.pathinfo($foto_url, PATHINFO_EXTENSION),
                'image:width' => 800,
                'image:height' => 800
            ];
            $this->meta->setMeta($metaimage);
        }
        $data = [
            'calon' => $calon,
            'header_title' => $header_title_dewan
        ];

        $meta_desc = preg_replace('/\[nama_dapil\]/', $calon->dapil->nama_dapil, $meta_desc);
        $meta_desc = preg_replace('/\[nama_wilayah\]/', $calon->dapil->nama_dapil, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        $this->meta->addMetaKeywords([
            $calon_keyword,
        ]);

        $metadata['description'] = "{$calon->nama}, {$calon_keyword}. Lihat Profil Calon Anggota Legislatif Disini.";

        $this->meta->setMeta($metadata);

        return Inertia::render($template, $data);
    }

    public function cari_profil(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "")
    {
        $no_partai = $request->input('no_partai');
        $no_calon = $request->input('no_calon');
        switch ($jenis) {
            case 'dprdp':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-provinsi/{$nama_dapil}/{$kode_dapil}/{$nama_calon}?no_partai={$no_partai}&no_calon={$no_calon}";
                return redirect($url_redirect, 301);
                break;

            case 'dprdk':
                $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/{$request->segment(1)}/dprd-kabkota/{$nama_dapil}/{$kode_dapil}/{$nama_calon}?no_partai={$no_partai}&no_calon={$no_calon}";
                return redirect($url_redirect, 301);
                break;

            case 'dprd-provinsi':
                $jenis = "dprdp";
                break;

                case 'dprd-kabkota':
                    $jenis = "dprdk";
                break;
            
            default:
                break;
        }

        if(is_numeric($kode_dapil) && is_numeric($no_calon) && (strlen($kode_dapil) == 2 || is_numeric($no_partai))){
            if($calon = $this->cache->get("cari_profil:{$kode_dapil}:{$no_partai}:{$no_calon}")){
                $calon = json_decode($calon);
                $this->meta->addMetaKeywords([
                    strtolower(str_replace(",", ".", $calon->nama))
                ]);
            }else{
                if($jenis === "dpd"){
                    $calon = Calons::with('dapil')->where('calons.kode_dapil', $kode_dapil)->where('calons.no_urut', $no_calon)->first();
                }else{
                    $calons = Calons::with('partai', 'dapil')->where('calons.kode_dapil', $kode_dapil)->where('calons.no_urut', $no_calon)->get();
                    $calon = null;
                    foreach ($calons as $calon) {
                        if($calon->partai->no_urut === (int) $no_partai)
                            break;
                    }
                }
                if($calon){
                    $this->cache->set('cari_profil:{$kode_dapil}:{$no_partai}:{$no_calon}', json_encode($calon));
                }else{
                    abort(404);
                    exit();
                }
            }
        }else{
            abort(404);
            exit();
        }

        switch ($calon->dapil->jenis_dewan) {
            case 'dprdp':
                $jenis = "dprd-provinsi";
                break;

            case 'dprdk':
                $jenis = "dprd-kabkota";
                break;

            default:
                break;
        }

        $url_redirect = "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/profil-calon/{$jenis}/".Str::slug(strtolower($calon->dapil->nama_dapil))."/{$kode_dapil}/".Str::slug(strtolower($calon->nama))."/{$calon->id}";
        return redirect($url_redirect, 301);
    }

    public function wilayah_dapil(Request $request, string $tingkatan_wilayah, string $nama_wilayah, string $kode_wilayah, bool $sampul = true)
    {
        $id_dapil_dprdk = null;
        $id_dapil_dprdp = null;
        $id_dapil_dpr = null;
        $id_dapil_dpd = null;

        $label_wilayah = null;

        switch ($tingkatan_wilayah) {
            case 'desa':
                if($wilayah = $this->cache->get('wilayah:'.$kode_wilayah)){
                    $wilayah = json_decode($wilayah);
                }else{
                    $wilayah = Desa::with(['kecamatan', 'kecamatan.kabkota' , 'kecamatan.kabkota.provinsi'])
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();
                    $this->cache->set('wilayah:'.$kode_wilayah, json_encode($wilayah));
                }
    
                $label_wilayah = "Desa/Kelurahan {$wilayah->nama}, Kec. {$wilayah->kecamatan->nama}, {$wilayah->kecamatan->kabkota->nama}, {$wilayah->kecamatan->kabkota->provinsi->nama}";

                if($wilayah){
                    $id_dapil_dprdk = $wilayah->id_dapil_dprdk ?? $wilayah->kecamatan->id_dapil_dprdk;
                    $id_dapil_dprdp = $wilayah->kecamatan->id_dapil_dprdp ?? $wilayah->kecamatan->kabkota->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->kecamatan->kabkota->id_dapil_dpr ?? $wilayah->kecamatan->kabkota->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->kecamatan->kabkota->provinsi->id_dapil_dpd;
                }
                break;
            case 'kecamatan':
                if($wilayah = $this->cache->get('wilayah:'.$kode_wilayah)){
                    $wilayah = json_decode($wilayah);
                }else{
                    $wilayah = Kecamatan::with('kabkota', 'kabkota.provinsi')
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();
                    $this->cache->set('wilayah:'.$kode_wilayah, json_encode($wilayah));
                }

                $label_wilayah = "Kec. {$wilayah->nama}, {$wilayah->kabkota->nama}, {$wilayah->kabkota->provinsi->nama}";
                if($wilayah){
                    $id_dapil_dprdk = $wilayah->id_dapil_dprdk;
                    $id_dapil_dprdp = $wilayah->id_dapil_dprdp ?? $wilayah->kabkota->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->kabkota->id_dapil_dpr ?? $wilayah->kabkota->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->kabkota->provinsi->id_dapil_dpd;
                }

                break;

            case 'kabkota':
                if($wilayah = $this->cache->get('wilayah:'.$kode_wilayah)){
                    $wilayah = json_decode($wilayah);
                }else{
                    $wilayah = Kabkota::with('provinsi')
                    ->where('kode_wilayah', $kode_wilayah)
                    ->first();
                    $this->cache->set('wilayah:'.$kode_wilayah, json_encode($wilayah));
                }

                $label_wilayah = "{$wilayah->nama}, {$wilayah->provinsi->nama}";
                if($wilayah){
                    $id_dapil_dprdp = $wilayah->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->id_dapil_dpr ?? $wilayah->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->provinsi->id_dapil_dpd;
                }

                break;

            case 'provinsi':
                if($wilayah = $this->cache->get('wilayah:'.$kode_wilayah)){
                    $wilayah = json_decode($wilayah);
                }else{
                    $wilayah = Provinsi::where('kode_wilayah', $kode_wilayah)
                    ->first();
                    $this->cache->set('wilayah:'.$kode_wilayah, json_encode($wilayah));
                }

                $label_wilayah = "{$wilayah->provinsi->nama}";
                if($wilayah){
                    $id_dapil_dpr = $wilayah->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->id_dapil_dpd;
                }

                break;
            
            default:
                abort(404);
                break;
        }

        if($sampul){
            $dprdk = $id_dapil_dprdk ? (Cache::has('dapil_id:'.$id_dapil_dprdk) ? json_decode($this->cache->get('dapil_id:'.$id_dapil_dprdk)) : function() use ($id_dapil_dprdk) { $dapils = Dapils::find($id_dapil_dprdk); $this->cache->set('dapil_id:'.$id_dapil_dprdk, json_encode($dapils)); return $dapils; }): null;
            $dprdp = $id_dapil_dprdp ? (Cache::has('dapil_id:'.$id_dapil_dprdp) ? json_decode($this->cache->get('dapil_id:'.$id_dapil_dprdp)) : function() use ($id_dapil_dprdp) { $dapils = Dapils::find($id_dapil_dprdp); $this->cache->set('dapil_id:'.$id_dapil_dprdp, json_encode($dapils)); return $dapils; }): null;
            $dpr = $id_dapil_dpr ? (Cache::has('dapil_id:'.$id_dapil_dpr) ? json_decode($this->cache->get('dapil_id:'.$id_dapil_dpr)) : function() use ($id_dapil_dpr) { $dapils = Dapils::find($id_dapil_dpr); $this->cache->set('dapil_id:'.$id_dapil_dpr, json_encode($dapils)); return $dapils; }): null;
            $dpd = $id_dapil_dpd ? (Cache::has('dapil_id:'.$id_dapil_dpd) ? json_decode($this->cache->get('dapil_id:'.$id_dapil_dpd)) : function() use ($id_dapil_dpd) { $dapils = Dapils::find($id_dapil_dpd); $this->cache->set('dapil_id:'.$id_dapil_dpd, json_encode($dapils)); return $dapils; }): null;
        }else{
            $dprdk = $id_dapil_dprdk ? $this->get_surat_suara_by_id_dapil($id_dapil_dprdk) : null;
            $dprdp = $id_dapil_dprdp ? $this->get_surat_suara_by_id_dapil($id_dapil_dprdp) : null;
            $dpr = $id_dapil_dpr ? $this->get_surat_suara_by_id_dapil($id_dapil_dpr) : null;
            $dpd = $id_dapil_dpd ? $this->get_surat_suara_by_id_dapil($id_dapil_dpd, true) : null;
        }

        $label_wilayah = ucwords(strtolower($label_wilayah));

        if($request->segment(1) === "hitung-suara"){
            $metadata = ['description' => "Hitung Suara Real Count Pemilu di Wilayah {$label_wilayah}"] ;

            $this->meta->setMeta($metadata);
            $this->meta->setTitle("Hitung Suara Wilayah {$wilayah->nama}");
    
            $this->meta->addMetaKeywords([
                "hitung suara realcount pemilu di ".trim(strtolower(str_replace(',', '', $label_wilayah))),
            ]);
    
            return Inertia::render('RealCountWilayah',  [
                'dprdk' => $dprdk,
                'dprdp' => $dprdp,
                'dpr' => $dpr,
                'dpd' => $dpd,
                'label_wilayah' => $label_wilayah
            ]);
        }else{
            $metadata = ['description' => "Surat Suara Pemilu di Wilayah {$label_wilayah}"] ;

            $this->meta->setMeta($metadata);
            $this->meta->setTitle("Surat Suara Wilayah {$wilayah->nama}");
    
            $this->meta->addMetaKeywords([
                "surat suara pemilu di ".trim(strtolower(str_replace(',', '', $label_wilayah))),
            ]);
    
            return Inertia::render('SuratSuaraSampul',  [
                'dprdk' => $dprdk,
                'dprdp' => $dprdp,
                'dpr' => $dpr,
                'dpd' => $dpd,
                'label_wilayah' => $label_wilayah
            ]);
        }
    }

    private function get_surat_suara_by_id_dapil(Int $id_dapil, bool $dpd = false){
        if($dpd){
            $result = Calons::join('dapils', 'calons.kode_dapil', '=', 'dapils.kode_dapil')
            ->where('dapils.id', $id_dapil)
            ->select('nama', 'calons.no_urut', 'foto')
            ->get()
            ->toArray();
        }else{
            $result = Partais::with(['calons' => function($query) use ($id_dapil){
                $query->join('dapils', 'calons.kode_dapil', '=', 'dapils.kode_dapil')
                ->where('dapils.id', $id_dapil)->orderBy('calons.no_urut')
                ;
            }])
            ->orderBy('partais.no_urut')
            ->select('id', 'no_urut', 'nama')
            ->get()
            ->map(function($partai){
                return count($partai->calons) > 0 ? [
                    'id' => $partai->id,
                    'no_urut' => $partai->no_urut,
                    'nama' => $partai->nama,
                    'calons' => $partai->calons->map(function($calon){
                        return [
                            'nama' => $calon->nama,
                            'no_urut' => $calon->no_urut,
                        ];
                    }),
                ] : false;
            })
            ->reject(function ($partai) {
                return empty($partai);
            })
            ->toArray();
        }

        if($dapil = $this->cache->get('dapil_id:'.$id_dapil)){
            $dapil = json_decode($dapil);
        }else{
            $dapil = Dapils::find($id_dapil);
            $this->cache->set('dapil_id:'.$id_dapil, json_encode($dapil));
        }


        return [
            'surat_suara' => $result,
            'dapil' => $dapil
        ];
    }

    private function replaceLastWord($inputString) {
        // Regular expression to match a word with 4 or fewer letters at the end of the string
        $regex = "/\b\d+\b$/";
    
        // Find the last word in the string
        preg_match($regex, $inputString, $lastWordMatch);
    
        if ($lastWordMatch) {
            $lastWord = $lastWordMatch[0];
    
            if (!is_nan($lastWord)) {
            $modifiedString = preg_replace($regex, '', $inputString);
            return trim($modifiedString);
            }
        }
    
      return $inputString;
    }
    
    private function prependIfNot($wordToCheck, $originalString, $prefix){
        $words = explode(" ", trim($originalString));
        if (count($words) > 0 && strtolower($words[0]) !== strtolower($wordToCheck)) {
          return "{$prefix}{$originalString}";
        }
        return $originalString;
    }

    private function getJsonKoordinat(){
        return '{
            "11": { "nama": "Aceh", "koordinat": [4.695135, 96.7493993] },
            "12": { "nama": "Sumatera Utara", "koordinat": [2.1153547, 99.5450974] },
            "13": { "nama": "Sumatera Barat", "koordinat": [-0.7399397, 100.8000051] },
            "14": { "nama": "Riau", "koordinat": [0.2933469, 101.7068294] },
            "15": { "nama": "Jambi", "koordinat": [-1.4851831, 102.4380581] },
            "16": { "nama": "Sumatera Selatan", "koordinat": [-3.3194374, 103.914399] },
            "17": { "nama": "Bengkulu", "koordinat": [-3.5778471, 102.3463875] },
            "18": { "nama": "Lampung", "koordinat": [-4.5585849, 105.4068079] },
            "19": { "nama": "Kepulauan Bangka Belitung", "koordinat": [-2.7410513, 106.4405872] },
            "21": { "nama": "Kepulauan Riau", "koordinat": [1.0745026, 103.9942166] },
            "31": { "nama": "DKI Jakarta", "koordinat": [-6.211544, 106.845172] },
            "32": { "nama": "Jawa Barat", "koordinat": [-7.090911, 107.668887] },
            "33": { "nama": "Jawa Tengah", "koordinat": [-7.150975, 110.1402594] },
            "34": { "nama": "DI Yogyakarta", "koordinat": [-7.8753849, 110.4262088] },
            "35": { "nama": "Jawa Timur", "koordinat": [-7.5360639, 112.2384017] },
            "36": { "nama": "Banten", "koordinat": [-6.4058172, 106.0640179] },
            "51": { "nama": "Bali", "koordinat": [-8.4095178, 115.188916] },
            "52": { "nama": "Nusa Tenggara Barat", "koordinat": [-8.6529334, 117.3616476] },
            "53": { "nama": "Nusa Tenggara Timur", "koordinat": [-8.6573819, 121.0793705] },
            "61": { "nama": "Kalimantan Barat", "koordinat": [-0.2787808, 111.4752851] },
            "62": { "nama": "Kalimantan Tengah", "koordinat": [-1.6814878, 113.3823545] },
            "63": { "nama": "Kalimantan Selatan", "koordinat": [-3.0926415, 115.2837585] },
            "64": { "nama": "Kalimantan Timur", "koordinat": [0.5269395, 116.3604420] },
            "65": { "nama": "Kalimantan Utara", "koordinat": [2.9657501, 116.0290327] },
            "71": { "nama": "Sulawesi Utara", "koordinat": [0.6246932, 123.9750018] },
            "72": { "nama": "Sulawesi Tengah", "koordinat": [-1.4300254, 121.4456179] },
            "73": { "nama": "Sulawesi Selatan", "koordinat": [-3.6687994, 119.9740534] },
            "74": { "nama": "Sulawesi Tenggara", "koordinat": [-4.14491, 122.174605] },
            "75": { "nama": "Gorontalo", "koordinat": [0.6999372, 122.4467238] },
            "76": { "nama": "Sulawesi Barat", "koordinat": [-2.8441371, 119.2320784] },
            "81": { "nama": "Maluku", "koordinat": [-3.2384616, 130.1452734] },
            "82": { "nama": "Maluku Utara", "koordinat": [1.5709993, 127.8087693] },
            "91": { "nama": "Papua", "koordinat": [-2.1522631, 138.5943707] },
            "92": { "nama": "Papua Barat", "koordinat": [-2.1466491, 133.3001700] },
            "93": { "nama": "Papua Selatan", "koordinat": [-6.9058665, 139.1928020] },
            "94": { "nama": "Papua Tengah", "koordinat": [-3.8049044, 136.4372756] },
            "95": { "nama": "Papua Pegunungan", "koordinat": [-4.1439114, 139.4066293] },
            "96": { "nama": "Papua Barat Daya", "koordinat": [-0.8424344, 131.3005577] }
          }
          ';
    }

    private function detectProxy()
    {
        // You can implement your own logic to detect the proxy
        // For example, check if there is a specific header indicating the proxy
        // If no proxy, return an empty string
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? '/proxy' : '';
    }

    private function sainteLague($votes, $seatsAvailable, $partai_threshold = []){
        if(isset($votes['persen'])) unset($votes['persen']);

        if(!empty($partai_threshold)){
            $new_votes = [];
            foreach ($partai_threshold as $no_partai) {
                $new_votes[$no_partai] = $votes[$no_partai];
            }
            $votes = $new_votes;
        }

        $allocatedSeats = array_fill_keys(array_keys($votes), 0);
    
        for ($i = 0; $i < $seatsAvailable; $i++) {
            $maxQuotient = -1;
            $maxIndex = -1;


            $j = 0;
            foreach ($votes as $key => $vote) {
                $quotient = $votes[$key] / (2 * $allocatedSeats[$key] + 1);
                if ($quotient > $maxQuotient) {
                    $maxQuotient = $quotient;
                    $maxIndex = $key;
                }
                $j++;
            }
    
            $allocatedSeats[$maxIndex]++;
        }
        return $allocatedSeats;        
    }

    private function simulateEmptyResult(){
        // Simulate null result
        $data = [];

        // Create a paginator instance with manual null result
        $perPage = 10; // Number of items per page
        $total = 0; // Total number of items
        $page = request()->get('page', 1); // Get the current page number from the request
        $paginator = new LengthAwarePaginator($data, $total, $perPage, $page);

        // Modify pagination links to include page number manually
        $paginator->setPath(request()->url()); // Set the base path for the paginator links
        
        $paginator->withQueryString();

        // Modify pagination links to include existing query string parameters
        return $paginator->withQueryString();
    }
}
