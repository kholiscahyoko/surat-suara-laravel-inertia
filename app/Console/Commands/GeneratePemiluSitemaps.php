<?php

namespace App\Console\Commands;

use App\Models\Calons;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\ImageAssetHelper;
// use App\Helpers\PilkadaHelper;
use App\Models\Provinsi;
use App\Models\Desa;
use App\Models\Dapils;

class GeneratePemiluSitemaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemaps:pemilu:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GENERATE SITEMAP PEMILU';

    private object $pilkada;
    private object $image;
    private array $rewrite_dewan;

    //configs


    public function __construct()
    {
        parent::__construct();
        $this->image = new ImageAssetHelper();
        $this->rewrite_dewan = [
            'dprdp' => 'dprd-provinsi',
            'dprdk' => 'dprd-kabkota'
        ];
    }
    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->pemilu_wilayah();
        $this->pemilu_dapil("surat_suara");
        $this->pemilu_dapil("hitung_suara");
        $this->pemilu_dapil("calon_terpilih");
        $this->pemilu_calon();
        // $this->pilkada_surat_suara();
        // $this->pilkada_pasangan_calon();
        // $this->pilkada_profil_calon();
    }

    private function pemilu_calon(){
        $this->info("===PROCESSING PEMILU CALON===");
        $provinsis = Provinsi::all();
        $url_indexes = [];
        foreach ($provinsis as $provinsi) {
            $this->info("PROVINSI : {$provinsi->nama} ({$provinsi->kode_wilayah})");
            $url_indexes[] = [
                'loc' => url("/sitemap/pemilu/profil-calon/{$provinsi->kode_wilayah}"),
                'lastmod' => "2024-11-01",
            ];

            $calons = Calons::with('dapil')->where('kode_dapil', 'LIKE', "{$provinsi->kode_wilayah}%")->select('nama', 'kode_dapil', 'foto', 'id')->get();
            $urls = [];
            $this->info("COUNT : {$calons->count()}");
            foreach ($calons as $calon) {
                $url = $this->generateUrl([
                    'profil-calon',
                    $this->rewrite_dewan[$calon->dapil->jenis_dewan] ?? $calon->dapil->jenis_dewan,
                    $calon->dapil->nama_dapil,
                    $calon->dapil->kode_dapil,
                    $calon->nama,
                    $calon->id
                ]);
                $urls[] = [
                    'loc' => $url,
                    'lastmod' => "2024-11-01",
                    'changefreq' => "never",
                    'priority' => "0.5",
                    'image_loc' => $this->generateUrlFoto($calon->foto)
                ];
            }
            $this->info("PROVINSI : {$provinsi->nama} ({$provinsi->kode_wilayah})");
            $xmlContent = view('sitemap/sitemap', compact('urls'))->render();
            $filename = "sitemap/pemilu_profil_calon_{$provinsi->kode_wilayah}.xml";
            // Save the XML to the public storage
            Storage::disk('public')->put($filename, $xmlContent);

            $this->info("Sitemap {$filename} generated successfully.");
        }

        $urls = $url_indexes;

        $xmlContent = view('sitemap/index', compact('urls'))->render();

        $filename = 'sitemap/pemilu_profil_calon_index.xml';

        // Save the XML to the public storage
        Storage::disk('public')->put($filename, $xmlContent);

        $this->info("Sitemap {$filename} generated successfully.");
    }

    private function pemilu_dapil($type="surat_suara"){
        $this->info("===PROCESSING PEMILU DAPIL {$type}===");
        $dapils = Dapils::all();
        $urls = [];
        foreach ($dapils as $dapil) {
            $url = $this->generateUrl([
                Str::slug($type),
                $this->rewrite_dewan[$dapil->jenis_dewan] ?? $dapil->jenis_dewan,
                $dapil->nama_dapil,
                $dapil->kode_dapil
            ]);
            $urls[] = [
                'loc' => $url,
                'lastmod' => "2024-11-01",
                'changefreq' => "never",
                'priority' => "0.5",
                'image_loc' => url('/assets/img/infopemilu-square-1.webp')
            ];
        }

        $xmlContent = view('sitemap/sitemap', compact('urls'))->render();

        $filename = "sitemap/pemilu_dapil_{$type}.xml";

        // Save the XML to the public storage
        Storage::disk('public')->put($filename, $xmlContent);

        $this->info("Sitemap {$filename} generated successfully.");
    }

    private function pemilu_wilayah(){
        $this->info("===PROCESSING PEMILU WILAYAH===");
        $wilayahs = Desa::rightJoin('kecamatans', 'desas.id_kecamatan', '=', 'kecamatans.id')
        ->rightJoin('kabkotas', 'kecamatans.id_kabkota', '=', 'kabkotas.id')
        ->rightJoin('provinsis', 'kabkotas.id_provinsi', '=', 'provinsis.id')
        ->select(['desas.id AS id_desa', 'desas.nama AS nama_desa', 'kecamatans.id AS id_kecamatan', 'kecamatans.nama AS nama_kecamatan', 'kabkotas.id AS id_kabkota', 'kabkotas.nama AS nama_kabkota', 'provinsis.id AS id_provinsi', 'provinsis.nama AS nama_provinsi', DB::raw("(CASE WHEN desas.kode_wilayah IS NOT NULL THEN desas.kode_wilayah WHEN kecamatans.kode_wilayah IS NOT NULL THEN kecamatans.kode_wilayah WHEN kabkotas.kode_wilayah IS NOT NULL THEN kabkotas.kode_wilayah ELSE provinsis.kode_wilayah END) AS kode_wilayah")])
        ->get();

        foreach ($wilayahs as $wilayah) {
            if($wilayah->id_desa){
                $tingkat = "desa";
                $nama_wilayah = $wilayah->nama_desa;
            }elseif ($wilayah->id_kecamatan) {
                $tingkat = "kecamatan";
                $nama_wilayah = $wilayah->nama_kecamatan;
            }elseif ($wilayah->id_kabkota) {
                $tingkat = "kabkota";
                $nama_wilayah = $wilayah->nama_kabkota;
            }else{
                $tingkat = "provinsi";
                $nama_wilayah = $wilayah->nama_provinsi;
            }
            $url = $this->generateUrl([
                "surat-suara",
                $tingkat,
                Str::slug($nama_wilayah),
                $wilayah->kode_wilayah
            ]);
            $urls[] = [
                'loc' => $url,
                'lastmod' => "2024-11-01",
                'changefreq' => "never",
                'priority' => "0.5",
                'image_loc' => url('/assets/img/infopemilu-square-1.webp')
            ];

        }

        $xmlContent = view('sitemap/sitemap', compact('urls'))->render();

        $filename = "sitemap/pemilu_wilayah.xml";

        // Save the XML to the public storage
        Storage::disk('public')->put($filename, $xmlContent);

        $this->info("Sitemap {$filename} generated successfully.");
    }

    private function generateUrl($array){
        foreach ($array as $key => $value) {
            $array[$key] = Str::slug($value);
        }

        $url = implode('/', $array);
        return url($url);
    }

    private function generateUrlFoto($url){
        $parsed_url = parse_url($url);

        if(!isset($parsed_url['host'])){
            $foto = pathinfo($url, PATHINFO_FILENAME);
            $foto = Str::slug($foto);
            return url("/assets/img/dpd_foto/compressed/{$foto}.webp");
        }elseif (isset($this->image->hosts[$parsed_url['host']])) {
            return $this->image->getUrl($url);
        }

        return $url;
    }
}
