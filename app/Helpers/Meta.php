<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
 
class Meta {
    private array $meta;
    private array $meta_property_keys = ['type', 'site_name', 'title', 'image', 'description', 'url', 'image:type', 'image:width', 'image:heigth'];
    private array $meta_name_keys = ['description'];
    private array $meta_robot_keys = ['robots', 'googlebot', 'googlebot-news'];
    private array $meta_keywords = [
        "pemilu 2024","surat suara", "pemilihan umum republik indonesia",
    ];

    private int $limit_keywords = 10;

    public function __construct(array $meta = []) {
        $this->meta = [
            'type' => 'article',
            'robots' => ['index', 'follow'],
            'googlebot' => ['index', 'follow'],
            'googlebot-news' => ['index', 'follow'],
            'site_name' => config('app.name'),
            'title' => config('app.name'),
            'image' => asset('assets/img/infopemilu-square-1.webp'),
            'description' => "Website Info Pemilu, daftar calon anggota legislatif terlengkap di seluruh Indonesia. Cari tahu pilihanmu disini!",
            'url' => url()->current(),
            'image:type' => 'image/webp',
            'image:width' => 366,
            'image:heigth' => 650,
        ];
    }

    public function generate() {
        return $this->generate_meta_names().$this->generate_meta_properties().$this->generate_meta_keywords().$this->generate_meta_robots().$this->generate_canonical().$this->generate_title();
    }

    public function generate_meta_properties() {
        $str = "";
        foreach ($this->meta_property_keys as $key) {
            if(isset($this->meta[$key]))
                $str .= "<meta property=\"og:{$key}\" content=\"{$this->meta[$key]}\"/>";
        }
        return $str;
    }

    public function generate_meta_names() {
        $str = "";
        foreach ($this->meta_name_keys as $key) {
            if(isset($this->meta[$key])){
                if(is_array($this->meta[$key])){
                    $content = implode(", ", $this->meta[$key]);
                }else{
                    $content = $this->meta[$key];
                }
                $str .= "<meta name=\"{$key}\" content=\"{$content}\" itemprop=\"{$key}\"/>";
            }
        }
        return $str;
    }

    public function generate_meta_robots() {
        $str = "";
        foreach ($this->meta_robot_keys as $key) {
            if(isset($this->meta[$key])){
                if(is_array($this->meta[$key])){
                    $content = implode(", ", $this->meta[$key]);
                }else{
                    $content = $this->meta[$key];
                }
                $str .= "<meta name=\"{$key}\" content=\"{$content}\"/>";
            }
        }
        return $str;
    }

    public function generate_title() {
        return "<title>{$this->meta['title']}</title>";
    }

    public function generate_meta_keywords() {
        $keywords_str = count($this->meta_keywords) > $this->limit_keywords ? implode(',', array_slice($this->meta_keywords, 0, $this->limit_keywords)) :  implode(',', $this->meta_keywords);
        return "<meta name=\"keywords\" content=\"{$keywords_str}\" itemprop=\"keywords\"/>";
    }

    public function generate_canonical(){
        return "<link rel=\"canonical\" href=\"".url()->current()."\" />";
    }

    public function addMetaKeywords(array $data = []) : void{
        $data = array_diff($data, $this->meta_keywords);
        $this->meta_keywords = array_merge($data, $this->meta_keywords);
    }

    public function setMeta(array $data = []): void {
        foreach ($data as $key => $value) {
            $this->meta[$key] = $value;
        }
    }

    public function setTitle(string $title = ""): void {
        $this->meta["title"] = config('app.name')." - ".$title;
    }
}