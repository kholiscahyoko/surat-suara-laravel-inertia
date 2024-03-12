<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateSitemaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemaps:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UPDATE SITEMAP REALCOUNT';

    //configs

    protected $configs_files = [
        'public/sitemap_page.xml' => 'changefreq:weekly',
        'public/sitemap_calon_terpilih.xml' => 'changefreq:never',
        'public/sitemap_hitung_suara.xml' => 'changefreq:never',
    ];

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
        $date = date("Y-m-d\TH:i:sP");
        foreach($this->configs_files as $file => $config){
            list($config_key, $config_val) = explode(":",$config);
            $changed = false;
            $changed_count = 0;
            $content = simplexml_load_file($file);
            foreach ($content->url as $url) {
                if(isset($url->$config_key) && (string)$url->$config_key === $config_val && isset($url->lastmod) && (string)$url->lastmod !== $date){
                    $url->lastmod = $date;
                    $changed_count++;
                    if(!$changed){
                        $changed = true;
                    }
                }
            }
            if($changed){
                if($content->asXML($file)){
                    echo "{$file} {$changed_count} CHANGED NODE(S)\n";
                }else{
                    echo "{$file} ERROR SAVE CHANGED\n";
                }
            }else{
                echo "{$file} NO CHANGED\n";
            }
        }
    }
}
