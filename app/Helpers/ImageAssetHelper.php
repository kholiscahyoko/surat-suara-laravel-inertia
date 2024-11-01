<?php
namespace App\Helpers;

class ImageAssetHelper {
    public function getUrl($url){
        try {
            $parsed_foto = parse_url($url);
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
}