<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheHelper {
    private bool $useRedis;

    public function __construct(bool $useRedis = false) {
        $this->useRedis = $useRedis;
    }

    public function get(string $key, bool $useRedis = false) {
        if($this->useRedis || $useRedis){
            return Redis::get($key);
        }else{
            return Cache::get($key);
        }
    }

    public function setex(string $key, int $ttl, string $content, bool $useRedis = false) {
        if($this->useRedis || $useRedis){
            return Redis::setex($key, $ttl, $content);
        }else{
            return Cache::put($key, $content, $ttl);
        }
    }

    public function set(string $key, string $content, bool $useRedis = false) {
        if($this->useRedis || $useRedis){
            return Redis::setex($key, $content);
        }else{
            return Cache::get($key, $content);
        }
    }
}