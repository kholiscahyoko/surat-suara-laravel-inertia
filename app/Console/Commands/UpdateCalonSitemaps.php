<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    // protected $base_sitemap_pattern = 'public/sitemap_foto_profil_calon[kode_prov].xml';
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
            $file_child_sitemap = "public/".basename($sitemap->loc);
            list($filename, $ext) = explode(".", $file_child_sitemap);
            $segments = explode("_", $filename);
            $kode_prov = last($segments);
            $calons = Calons::whereRaw("LEFT(kode_dapil, 2) = ?", [$kode_prov])->select('foto', 'id', 'kode_dapil')->get();

            $calon_list_db = [];
            if($calons->isEmpty()){
                unset($sitemap);
                $total_deleted++;
                continue;
            }
            foreach ($calons as $calon) {
                $foto = $calon->foto;
                if(preg_match("/^\.\./", $foto)){
                    $foto = pathinfo($calon->foto, PATHINFO_FILENAME);
                    $foto = Str::slug(strtolower($foto));
                    $foto = config('app.url'). "/assets/img/dpd_foto/compressed/{$foto}.webp";
                }
                $calon_list_db[$calon->id] = [
                    'foto' => $foto,
                    'kode_dapil' => $calon->kode_dapil
                ];
            }
            $content_child = simplexml_load_file($file_child_sitemap);
            $changed_child = false;
            $child_deleted = 0;
            $child_updated = 0;
            $child_count = 0;
            foreach ($content_child->url as $url) {
                $id_calon = basename($url->loc);
                $child_count++;
                $total_count++;
                if(!isset($calon_list_db[$id_calon])){
                    unset($url);
                    $child_deleted++;
                    $total_deleted++;
                    continue;
                }
                if(isset($calon_list_db[$id_calon]["foto"])){
                    $imageImage = $url->children('http://www.google.com/schemas/sitemap-image/1.1')->image;
                    if(!empty($imageImage->loc) && $imageImage->loc != $calon_list_db[$id_calon]["foto"]){
                        $imageImage->loc = $calon_list_db[$id_calon]["foto"];
                        $child_updated++;
                        $total_updated++;
                        $url->lastmod = $date;
                    }else if(empty($imageImage->loc) && !empty($calon_list_db[$id_calon]["foto"])){
                        $result = $url->addChild('image:image', null, 'http://www.google.com/schemas/sitemap-image/1.1')->addChild('image:loc', $calon_list_db[$id_calon]["foto"], 'http://www.google.com/schemas/sitemap-image/1.1');
                        $child_updated++;
                        $total_updated++;
                        $url->lastmod = $date;
                    }
                }
            }
            echo "CHILD DELETED : {$child_deleted}\n";
            echo "CHILD UPDATED : {$child_updated}\n";
            echo "CHILD COUNT : {$child_count}\n";
            if($child_deleted > 0 || $child_updated > 0){
                $sitemap->lastmod = $date;
                $changed_base_parent = true;
                if($content_child->asXML($file_child_sitemap)){
                    echo "{$file_child_sitemap} {($child_deleted + $child_updated)} CHANGED NODE(S)\n";
                }else{
                    echo "{$file_child_sitemap} ERROR SAVE CHANGED\n";
                }
            }else{
                echo "{$file_child_sitemap} NO CHANGED\n";
            }
        }
        echo "TOTAL DELETED : {$total_deleted}\n";
        echo "TOTAL UPDATED : {$total_updated}\n";
        echo "TOTAL COUNT : {$total_count}\n";
        if($changed_base_parent){
            if($content_base_parent->asXML($file_parent_base_sitemap)){
                echo "{$file_parent_base_sitemap} CHANGED\n";
            }else{
                echo "{$file_parent_base_sitemap} ERROR SAVE CHANGED\n";
            }
        }else{
            echo "{$file_parent_base_sitemap} NO CHANGED\n";
        }

    }
}
