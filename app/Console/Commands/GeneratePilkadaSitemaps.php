<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Helpers\PilkadaHelper;

class GeneratePilkadaSitemaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemaps:pilkada:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GENERATE SITEMAP PILKADA';

    private object $pilkada;

    //configs


    public function __construct()
    {
        parent::__construct();
        $this->pilkada = new PilkadaHelper();
    }
    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->pilkada_surat_suara();
        $this->pilkada_pasangan_calon();
        $this->pilkada_profil_calon();
    }

    private function pilkada_surat_suara()
    {
        $wilayahs = $this->pilkada->getAllWilayah();
        $urls = [];
        foreach ($wilayahs as $wilayah) {
            $urls[] = [
                'loc' => $wilayah->url,
                'lastmod' => "2024-11-01",
                'changefreq' => "never",
                'priority' => "0.5",
            ];
        }

        $xmlContent = view('sitemap/sitemap', compact('urls'))->render();

        $filename = 'sitemap/pilkada_surat_suara.xml';

        // Save the XML to the public storage
        Storage::disk('public')->put($filename, $xmlContent);

        $this->info("Sitemap {$filename} generated successfully.");
    }

    public function pilkada_pasangan_calon()
    {
        $this->info("PROCESSING PASANGAN CALON");
        $wilayahs = $this->pilkada->getAllWilayah();
        $urls = [];
        foreach ($wilayahs as $wilayah) {
            $this->info("WILAYAH : {$wilayah->nama} ({$wilayah->kode_wilayah})");
            $paslons = $this->pilkada->getPaslonWilayah($wilayah->kode_wilayah);
            foreach ($paslons->data as $paslon) {
                if(isset($paslon->url)){
                    $urls[] = [
                        'loc' => $paslon->url,
                        'lastmod' => "2024-11-01",
                        'changefreq' => "never",
                        'priority' => "0.5",
                        'image_loc' => $paslon->image_url,
                    ];
                }
            }
        }
        $filename = "sitemap/pilkada_pasangan_calon.xml";

        $xmlContent = view("sitemap/sitemap", compact('urls'))->render();

        // Save the XML to the public storage
        Storage::disk('public')->put($filename, $xmlContent);

        $this->info("Sitemap {$filename} generated successfully.");
    }

    public function pilkada_profil_calon()
    {
        $this->info("PROCESSING PROFIL CALON");
        $wilayahs = $this->pilkada->getAllWilayah();
        $urls = [];
        foreach ($wilayahs as $wilayah) {
            $this->info("WILAYAH : {$wilayah->nama} ({$wilayah->kode_wilayah})");
            $paslons = $this->pilkada->getPaslonWilayah($wilayah->kode_wilayah);
            foreach ($paslons->data as $paslon) {
                if(isset($paslon->url)){
                    $urls[] = [
                        'loc' => $paslon->calon->url,
                        'lastmod' => "2024-11-01",
                        'changefreq' => "never",
                        'priority' => "0.5",
                        'image_loc' => $paslon->calon->image_url,
                    ];
                    $urls[] = [
                        'loc' => $paslon->wakil_calon->url,
                        'lastmod' => "2024-11-01",
                        'changefreq' => "never",
                        'priority' => "0.5",
                        'image_loc' => $paslon->wakil_calon->image_url,
                    ];
                }
            }
        }
        $filename = "sitemap/pilkada_profil_calon.xml";

        $xmlContent = view("sitemap/sitemap", compact('urls'))->render();

        // Save the XML to the public storage
        Storage::disk('public')->put($filename, $xmlContent);

        $this->info("Sitemap {$filename} generated successfully.");
    }
}
