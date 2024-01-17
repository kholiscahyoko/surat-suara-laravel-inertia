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
use Brick\Math\BigInteger;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SuratSuaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
        
        return Inertia::render('Wilayah',[
            'wilayahs' => $wilayahs,
            'filters' => $request->only(['search'])
        ]);

    }

    public function dewan(string $kode_dapil)
    {
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
        return [
            'partais' => $partais,
            'dapil' => Dapils::query()
            ->where('kode_dapil', $kode_dapil)
            ->first()
        ];
    }

    public function wilayah_dapil(string $tingkatan_wilayah, string $kode_wilayah, bool $sampul = false)
    {
        $id_dapil_dprdk = null;
        $id_dapil_dprdp = null;
        $id_dapil_dpr = null;
        $id_dapil_dpd = null;

        switch ($tingkatan_wilayah) {
            case 'desa':
                $wilayah = Desa::with(['kecamatan', 'kecamatan.kabkota' , 'kecamatan.kabkota.provinsi'])
                ->where('kode_wilayah', $kode_wilayah)
                ->first();

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

                if($wilayah){
                    $id_dapil_dprdp = $wilayah->id_dapil_dprdp;
                    $id_dapil_dpr = $wilayah->id_dapil_dpr ?? $wilayah->provinsi->id_dapil_dpr;
                    $id_dapil_dpd = $wilayah->provinsi->id_dapil_dpd;
                }

                break;

            case 'provinsi':
                $wilayah = Provinsi::where('kode_wilayah', $kode_wilayah)
                ->first();

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

        return [
            'dprdk' => $dprdk,
            'dprdp' => $dprdp,
            'dpr' => $dpr,
            'dpd' => $dpd
        ];

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

        return [
            'surat_suara' => $result,
            'dapil' => Dapils::find($id_dapil)
        ];
    }
}