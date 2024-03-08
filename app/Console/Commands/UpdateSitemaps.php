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
        'public/sitemap_page.xml' => 'changefreq:daily',
        'public/sitemap_calon_terpilih.xml' => 'changefreq:daily',
        'public/sitemap_hitung_suara.xml' => 'changefreq:daily',
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
                $content->asXML($file);
                echo "{$file} {$changed_count} CHANGED NODE(S)\n";
            }else{
                echo "{$file} NO CHANGED\n";
            }
        }
    }

    private function saveToFile($url, $data){
        // Remove protocol and host
        $directory = parse_url($url, PHP_URL_PATH);

        $filename = basename($directory);
        $directory = dirname($directory);

        // Create the directory if it doesn't exist
        Storage::makeDirectory($directory);

        // Define the file path
        $filePath = $directory . '/' . $filename;

        // Store the data in the JSON file
        return Storage::put($filePath, json_encode($data));
    }
}
