<?php
namespace App\Helpers;

class ImageAssetHelper {

    public array $hosts;
    public object $cache;
    public string $prefix_cache;
    public int $ttl;

    public function __construct() {
        $this->hosts = [
            'b-silonkada-prod.oss-ap-southeast-5.aliyuncs.com' => '',
            'cdn-sikadeka-pilkada.kpu.go.id' => '',
            'infopemilu.kpu.go.id' => 'https://infopemilu.kpu.go.id/dct/berkas-silon/calon/149009/pas_foto/1683731833_3c8dda92-bffa-4ff6-968f-e1a52f630ace.jpeg'
        ];

        $this->cache = new CacheHelper();
        $this->prefix_cache = "foto:user_image_lezen";
        $this->ttl = 60*60;
    }

    public function getUrl($url){
        try {
            $parsed_foto = parse_url($url);
            if(!$this->useLezenImage($parsed_foto['host'])){
                return $url;
            }
            $dir_path = pathinfo($parsed_foto["path"], PATHINFO_DIRNAME);
            $filename = pathinfo($parsed_foto["path"], PATHINFO_FILENAME);
            $md5 = md5($dir_path);
            $segment1 = substr($md5, 0, 1);
            $segment2 = substr($md5, 1, 1);
            $segment3 = substr($md5, 2, 1);
            return "https://images.lezen.id/{$parsed_foto['host']}/{$segment1}/{$segment2}/{$segment3}/{$filename}.webp";
        } catch (\Exception $e) {
            return false;
        }
    }

    private function useLezenImage($host){
        if(isset($this->hosts[$host])){
            if(empty($this->hosts[$host]) || $this->cache->get("{$this->prefix_cache}:{$host}"))
                return true;
        }
        return false;
    }

    public function setCache($key, $content, $ttl = null){
        $ttl = $ttl ?? $this->ttl;
        $this->cache->setex($key, $ttl, $content);
    }
}