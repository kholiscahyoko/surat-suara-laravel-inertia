<?php
namespace App\Helpers;
 
class GoogleEnhancement {
    private array $enhancements;
    // private array $meta_property_keys = ['type', 'site_name', 'title', 'image', 'description', 'url', 'image:type', 'image:width', 'image:height'];
    // private array $meta_name_keys = ['description'];
    // private array $meta_robot_keys = ['robots', 'googlebot', 'googlebot-news'];
    // private array $meta_keywords = [
    //     "pemilu 2024","surat suara", "pemilihan umum republik indonesia",
    // ];

    // private int $limit_keywords = 10;
    // private string $url_canonical = "";

    public function __construct(array $enhancements = []) {
        $this->enhancements = [];
    }

    public function generate() {
        $str = '';
        foreach ($this->enhancements as $enhancement) {
            $str.= $this->generate_piece($enhancement);
        }
        return $str;
    }

    public function generate_piece($enhancement) {
        $enhancement = json_encode($enhancement, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return "<script type=\"application/ld+json\">{$enhancement}</script>";
    }

    public function add($enhancement){
        $data['@context'] = "https://schema.org";
        $data = array_merge($data,$enhancement);
        $this->enhancements[] = $data;
    }
}