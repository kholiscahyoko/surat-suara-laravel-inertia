<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Calons;
use App\Models\Desa;
use App\Models\Partais;
use App\Models\Dapils;
use App\Models\Kabkota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
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

        $data_json = '{"summary":{"jenis_kelamin":[{"jenis_kelamin":"LAKI - LAKI","jumlah":163174},{"jenis_kelamin":"PEREMPUAN","jumlah":95136}],"jenis_dewan":{"dpr":"9,917","dpd":"668","dprdp":"32,873","dprdk":"214,852"},"data_provinsi":[{"kode_wilayah":"11","jumlah_caleg":10438},{"kode_wilayah":"12","jumlah_caleg":14717},{"kode_wilayah":"13","jumlah_caleg":8103},{"kode_wilayah":"14","jumlah_caleg":7366},{"kode_wilayah":"15","jumlah_caleg":5405},{"kode_wilayah":"16","jumlah_caleg":9413},{"kode_wilayah":"17","jumlah_caleg":3836},{"kode_wilayah":"18","jumlah_caleg":7357},{"kode_wilayah":"19","jumlah_caleg":3119},{"kode_wilayah":"21","jumlah_caleg":3255},{"kode_wilayah":"31","jumlah_caleg":2216},{"kode_wilayah":"32","jumlah_caleg":21320},{"kode_wilayah":"33","jumlah_caleg":20198},{"kode_wilayah":"34","jumlah_caleg":3442},{"kode_wilayah":"35","jumlah_caleg":22796},{"kode_wilayah":"36","jumlah_caleg":6953},{"kode_wilayah":"51","jumlah_caleg":3775},{"kode_wilayah":"52","jumlah_caleg":6403},{"kode_wilayah":"53","jumlah_caleg":10367},{"kode_wilayah":"61","jumlah_caleg":7368},{"kode_wilayah":"62","jumlah_caleg":5250},{"kode_wilayah":"63","jumlah_caleg":5652},{"kode_wilayah":"64","jumlah_caleg":5325},{"kode_wilayah":"65","jumlah_caleg":2123},{"kode_wilayah":"71","jumlah_caleg":4789},{"kode_wilayah":"72","jumlah_caleg":6446},{"kode_wilayah":"73","jumlah_caleg":10755},{"kode_wilayah":"74","jumlah_caleg":6123},{"kode_wilayah":"75","jumlah_caleg":2538},{"kode_wilayah":"76","jumlah_caleg":2477},{"kode_wilayah":"81","jumlah_caleg":5339},{"kode_wilayah":"82","jumlah_caleg":4517},{"kode_wilayah":"91","jumlah_caleg":4348},{"kode_wilayah":"92","jumlah_caleg":2900},{"kode_wilayah":"93","jumlah_caleg":1949},{"kode_wilayah":"94","jumlah_caleg":4026},{"kode_wilayah":"95","jumlah_caleg":3560},{"kode_wilayah":"96","jumlah_caleg":2346}]}}';

        $data = json_decode($data_json, TRUE);

        // $data["summary"]["data_provinsi"] = $calon_provinsi;

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
        return Inertia::render('Calon',[
            'users' => Calons::
            query()->with('dapil')
            ->when($request->input('search'), function($query, $search){
                $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(20)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->nama,
                'kode_dapil' => $user->kode_dapil,
                'jenis_dewan' => $user->dapil->jenis_dewan,
                'nama_dapil' => $user->dapil->nama_dapil,
            ]),
            'filters' => $request->only(['search'])
        ]);
    }

    public function dapil(Request $request)
    {
        $dapils = Dapils::query()
            ->when($request->input('search'), function($query, $search){
                $query->where('nama_dapil', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($data) => [
                'id' => $data->id,
                'nama' => $data->nama_dapil,
                'kode_dapil' => $data->kode_dapil,
                'jenis_dewan' => $data->jenis_dewan,
            ]);

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
        $wilayahs = Desa::rightJoin('kecamatans', 'desas.id_kecamatan', '=', 'kecamatans.id')
        ->rightJoin('kabkotas', 'kecamatans.id_kabkota', '=', 'kabkotas.id')
        ->rightJoin('provinsis', 'kabkotas.id_provinsi', '=', 'provinsis.id')
        ->where('desas.nama', 'like', "%{$request->input('search')}%")
        ->orWhere('kecamatans.nama', 'like', "%{$request->input('search')}%")
        ->orWhere('kabkotas.nama', 'like', "%{$request->input('search')}%")
        ->orWhere('provinsis.nama', 'like', "%{$request->input('search')}%")
        ->select(['desas.id AS id_desa', 'desas.nama AS nama_desa', 'kecamatans.id AS id_kecamatan', 'kecamatans.nama AS nama_kecamatan', 'kabkotas.id AS id_kabkota', 'kabkotas.nama AS nama_kabkota', 'provinsis.id AS id_provinsi', 'provinsis.nama AS nama_provinsi', DB::raw("(CASE WHEN desas.kode_wilayah IS NOT NULL THEN desas.kode_wilayah WHEN kecamatans.kode_wilayah IS NOT NULL THEN kecamatans.kode_wilayah WHEN kabkotas.kode_wilayah IS NOT NULL THEN kabkotas.kode_wilayah ELSE provinsis.kode_wilayah END) AS kode_wilayah")])
        ->paginate(20)
        ->withQueryString()
        ;

        $this->meta->setMeta(config('app.meta')['wilayah']);
        $this->meta->addMetaKeywords([
            "surat suara berdasarkan wilayah",
        ]);

        return Inertia::render('Wilayah',[
            'wilayahs' => $wilayahs,
            'filters' => $request->only(['search'])
        ]);

    }

    public function jenis(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "", string $calon_id = "")
    {
        switch ($jenis) {
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
            $dapil = Dapils::query()
            ->where('kode_dapil', $kode_dapil)
            ->first();

            $calon_keyword = "calon dewan perwakilan daerah provinsi ".trim(strtolower($dapil->nama_dapil));

            $template = "SuratSuaraDpd";

            $data = [
                'calons' => Calons::where('kode_dapil', $kode_dapil)
                ->orderBy('no_urut')
                ->get(),
                'dapil' => $dapil
            ];
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
            $dapil = Dapils::query()
            ->where('kode_dapil', $kode_dapil)
            ->first();

            switch ($jenis) {
                case 'dpr':
                    $template = "SuratSuaraDpr";
                    $calon_keyword = "calon dewan perwakilan rakyat daerah pemilihan ".trim(strtolower($dapil->nama_dapil));
                    break;
                
                case 'dprdp':
                    $template = "SuratSuaraDprdp";
                    $calon_keyword = "calon dewan perwakilan rakyat daerah provinsi ".trim(strtolower($this->replaceLastWord($dapil->nama_dapil)))." dapil ".trim(strtolower($dapil->nama_dapil));
                    break;
                
                case 'dprdk':
                    $template = "SuratSuaraDprdk";
                    $calon_keyword = "calon dewan perwakilan rakyat daerah ".trim(strtolower($this->prependIfNot('kota', $this->replaceLastWord($dapil->nama_dapil), 'KABUPATEN ')))." dapil ".trim(strtolower($dapil->nama_dapil));
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
            if($calon = Calons::find($calon_id)){
                $metadata['description'] = "{$calon->nama}, {$calon_keyword}. Lihat Surat Suara disini.";
                $this->meta->addMetaKeywords([
                    strtolower(str_replace(",", ".", $calon->nama))
                ]);
                $data['calon_id'] = $calon_id;
            }
        }

        $this->meta->setMeta($metadata);

        return Inertia::render($template, $data);
    }

    public function profil(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "", string $calon_id = "")
    {
        if(is_numeric($calon_id)){
            if($calon = Calons::with('partai', 'dapil')->find($calon_id)){
                $this->meta->addMetaKeywords([
                    strtolower(str_replace(",", ".", $calon->nama))
                ]);
            }else{
                abort(404);
                exit();
            }
        }else{
            abort(404);
            exit();
        }

        switch ($jenis) {
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
        }
        $this->meta->setTitle("Profil {$calon->nama}");

        if($jenis === "dpd"){
            $calon_keyword = "calon dewan perwakilan daerah provinsi ".trim(strtolower($calon->dapil->nama_dapil));
            $template = "ProfilDpd";
            $header_title_dewan = "DEWAN PERWAKILAN DAERAH<br>REPUBLIK INDONESIA";
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

    public function wilayah_dapil(string $tingkatan_wilayah, string $nama_wilayah, string $kode_wilayah, bool $sampul = true)
    {
        $id_dapil_dprdk = null;
        $id_dapil_dprdp = null;
        $id_dapil_dpr = null;
        $id_dapil_dpd = null;

        $label_wilayah = null;

        switch ($tingkatan_wilayah) {
            case 'desa':
                $wilayah = Desa::with(['kecamatan', 'kecamatan.kabkota' , 'kecamatan.kabkota.provinsi'])
                ->where('kode_wilayah', $kode_wilayah)
                ->first();
                $label_wilayah = "Desa/Kelurahan {$wilayah->nama}, Kec. {$wilayah->kecamatan->nama}, {$wilayah->kecamatan->kabkota->nama}, {$wilayah->kecamatan->kabkota->provinsi->nama}";

                if($wilayah){
                    $id_dapil_dprdk = $wilayah->id_dapil_dprdk ?? $wilayah->kecamatan->id_dapil_dprdk;
                    $id_dapil_dprdp = $wilayah->kecamatan->id_dapil_dprdp ?? $wilayah->kecamatan->kabkota->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->kecamatan->kabkota->id_dapil_dpr ?? $wilayah->kecamatan->kabkota->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->kecamatan->kabkota->provinsi->id_dapil_dpd;
                }
                break;
            case 'kecamatan':
                $wilayah = Kecamatan::with('kabkota', 'kabkota.provinsi')
                ->where('kode_wilayah', $kode_wilayah)
                ->first();

                $label_wilayah = "Kec. {$wilayah->nama}, {$wilayah->kabkota->nama}, {$wilayah->kabkota->provinsi->nama}";
                if($wilayah){
                    $id_dapil_dprdk = $wilayah->id_dapil_dprdk;
                    $id_dapil_dprdp = $wilayah->id_dapil_dprdp ?? $wilayah->kabkota->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->kabkota->id_dapil_dpr ?? $wilayah->kabkota->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->kabkota->provinsi->id_dapil_dpd;
                }

                break;

            case 'kabkota':
                $wilayah = Kabkota::with('provinsi')
                ->where('kode_wilayah', $kode_wilayah)
                ->first();

                $label_wilayah = "{$wilayah->nama}, {$wilayah->provinsi->nama}";
                if($wilayah){
                    $id_dapil_dprdp = $wilayah->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->id_dapil_dpr ?? $wilayah->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->provinsi->id_dapil_dpd;
                }

                break;

            case 'provinsi':
                $wilayah = Provinsi::where('kode_wilayah', $kode_wilayah)
                ->first();

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
            $dprdk = $id_dapil_dprdk ? Dapils::find($id_dapil_dprdk) : null;
            $dprdp = $id_dapil_dprdp ? Dapils::find($id_dapil_dprdp) : null;
            $dpr = $id_dapil_dpr ? Dapils::find($id_dapil_dpr) : null;
            $dpd = $id_dapil_dpd ? Dapils::find($id_dapil_dpd) : null;
        }else{
            $dprdk = $id_dapil_dprdk ? $this->get_surat_suara_by_id_dapil($id_dapil_dprdk) : null;
            $dprdp = $id_dapil_dprdp ? $this->get_surat_suara_by_id_dapil($id_dapil_dprdp) : null;
            $dpr = $id_dapil_dpr ? $this->get_surat_suara_by_id_dapil($id_dapil_dpr) : null;
            $dpd = $id_dapil_dpd ? $this->get_surat_suara_by_id_dapil($id_dapil_dpd, true) : null;
        }

        $label_wilayah = ucwords(strtolower($label_wilayah));

        $metadata = ['description' => "Surat Suara Pemilu di Wilayah {$label_wilayah}"] ;

        $this->meta->setMeta($metadata);
        $this->meta->setTitle("Surat Suara Wilayah");

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

        $dapil = Dapils::find($id_dapil);

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
}
