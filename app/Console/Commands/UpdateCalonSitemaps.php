<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Calons;

class UpdateCalonSitemaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemaps:calon:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UPDATE SITEMAP CALON';

    //configs

    protected $configs_files = [
        'public/sitemap_page.xml' => 'changefreq:weekly',
        'public/sitemap_calon_terpilih.xml' => 'changefreq:never',
        'public/sitemap_hitung_suara.xml' => 'changefreq:never',
    ];

    protected $base_sitemap_pattern = 'public/sitemap_profil_calon[kode_prov].xml';
    protected $foto_sitemap_pattern = 'public/sitemap_foto_profil_calon[kode_prov].xml';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */

    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date("Y-m-d");

        $file_parent_base_sitemap = preg_replace("/\[kode_prov\]/", "", $this->base_sitemap_pattern);
        $content_base_parent = simplexml_load_file($file_parent_base_sitemap);
        $changed_base_parent = false;
        $total_deleted = 0;
        $total_updated = 0;
        $total_count = 0;
        foreach ($content_base_parent->sitemap as $sitemap) {
            echo "LOC: {$sitemap->loc}\n";
            echo "LASTMOD: {$sitemap->lastmod}\n";
            $file_child_sitemap = basename($sitemap->loc);
            echo "FILENAME: public/{$file_child_sitemap}\n";
            list($filename, $ext) = explode(".", $file_child_sitemap);
            $segments = explode("_", $filename);
            $kode_prov = last($segments);
            $calons = Calons::whereRaw("LEFT(kode_dapil, 2) = ?", [$kode_prov])->select('foto', 'id', 'kode_dapil')->get();

            $calon_list_db = [];
            if($calons->isEmpty()){
                continue;
            }
            foreach ($calons as $calon) {
                $calon_list_db[$calon->id] = [
                    'foto' => $calon->foto,
                    'kode_dapil' => $calon->kode_dapil
                ];
            }
            $content_child = simplexml_load_file("public/".$file_child_sitemap);
            $changed_child = false;
            $child_deleted = 0;
            $child_updated = 0;
            $child_count = 0;
            foreach ($content_child->url as $key => $url) {
                $id_calon = basename($url->loc);
                $child_count++;
                $total_count++;
                if(!isset($calon_list_db[$id_calon])){
                    unset($content_child->url[$key]);
                    $child_deleted++;
                    $total_deleted++;
                }
            }
            echo "CHILD DELETED : {$child_deleted}\n";
            echo "CHILD COUNT : {$child_count}\n";

        }
        echo "TOTAL DELETED : {$total_deleted}\n";
        echo "TOTAL COUNT : {$total_count}\n";
        die();

        // foreach($this->configs_files as $file => $config){
        //     list($config_key, $config_val) = explode(":",$config);
        //     $changed = false;
        //     $changed_count = 0;
        //     $content = simplexml_load_file($file);
        //     foreach ($content->url as $url) {
        //         if(isset($url->$config_key) && (string)$url->$config_key === $config_val && isset($url->lastmod) && (string)$url->lastmod !== $date){
        //             $url->lastmod = $date;
        //             $changed_count++;
        //             if(!$changed){
        //                 $changed = true;
        //             }
        //         }
        //     }
        //     if($changed){
        //         if($content->asXML($file)){
        //             echo "{$file} {$changed_count} CHANGED NODE(S)\n";
        //         }else{
        //             echo "{$file} ERROR SAVE CHANGED\n";
        //         }
        //     }else{
        //         echo "{$file} NO CHANGED\n";
        //     }
        // }
    }
}
