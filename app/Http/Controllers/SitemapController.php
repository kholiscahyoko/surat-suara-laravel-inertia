<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

use App\Helpers\PilkadaHelper;
use App\Helpers\ImageAssetHelper;
use App\Helpers\CacheHelper;


class SitemapController
{

    use AuthorizesRequests, ValidatesRequests;

    private object $cache;
    private object $pilkada;
    private object $image;
    private int $ttl;
    
    public function __construct() {
        $this->pilkada = new PilkadaHelper();
        $this->image = new ImageAssetHelper();
        $this->cache = new CacheHelper();
        $this->ttl = 60 * 60 * 24;
    }

    public function pilkada_surat_suara(Request $request)
    {
        $key = "sitemap:pilkada:surat_suara";
        if($request->input('flush')){
            $cache = $this->cache->del($key);
        }
        $cache = $this->cache->get($key);
        if($request->input('nocache') || !($cache = $this->cache->get($key))){
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
            if(!$request->input('nocache')){
                $this->cache->setex($key, $this->ttl, json_encode($urls));
            }
        }else{
            $urls = json_decode($cache, true);
        }

        $xmlContent = view('sitemap/sitemap', compact('urls'))->render();

        return response($xmlContent, 200)
                ->header('Content-Type', 'application/xml');        
    }

    public function pilkada_pasangan_calon(Request $request, $kode_wilayah = "index")
    {
        if($kode_wilayah !== "index" && !is_numeric($kode_wilayah) && strlen($kode_wilayah)>4){
            abort(404);
            exit();
        }
        $key = "sitemap:pilkada:pasangan_calon:{$kode_wilayah}";
        if($request->input('flush')){
            $cache = $this->cache->del($key);
        }
        $cache = $this->cache->get($key);
        if($request->input('nocache') || !($cache = $this->cache->get($key))){
            if($kode_wilayah === "index"){
                $wilayahs = $this->pilkada->getAllWilayah();
                $urls = [];
                foreach ($wilayahs as $wilayah) {
                    $urls[] = [
                        'loc' => "{$request->getScheme()}://{$request->getHttpHost()}/sitemap/pilkada/pasangan-calon/{$wilayah->kode_wilayah}",
                        'lastmod' => "2024-11-01"
                    ];
                }
            }else{
                $paslons = $this->pilkada->getPaslonWilayah($kode_wilayah);
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
            if(!$request->input('nocache')){
                $this->cache->setex($key, $this->ttl, json_encode($urls));
            }
        }else{
            $urls = json_decode($cache, true);
        }

        $template = $kode_wilayah === "index" ? "index" : "sitemap";

        $xmlContent = view("sitemap/{$template}", compact('urls'))->render();

        return response($xmlContent, 200)
                ->header('Content-Type', 'application/xml');        
    }

    private function detectProxy()
    {
        // You can implement your own logic to detect the proxy
        // For example, check if there is a specific header indicating the proxy
        // If no proxy, return an empty string
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? '/proxy' : '';
    }
}