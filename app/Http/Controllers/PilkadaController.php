<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

use Inertia\Inertia;

class PilkadaController extends Controller
{

    public function __construct() {
        parent::__construct(); // Call the parent class constructor
        $this->setGeneralEnhancement(); // Call the necessary function
        Config::set('app.name', 'Info Pilkada');
        Inertia::share('appName', config('app.name'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->meta->setTitle(config('app.meta')['pilkada']['home']['title']);

        return Inertia::render('HomePilkada');
    }

    public function wilayah(Request $request)
    {
        $page = $request->input('page');
        if(!is_numeric($page)){
            $page = 0;
        }
        $search = $request->input('search');

        $wilayahs = $this->pilkada->getAllWilayah();


        // Define per page and current page parameters
        $perPage = 5;

        $this->meta->setMeta(config('app.meta')['pilkada']['wilayah']);
        $this->meta->addMetaKeywords([
            "surat suara pilkada berdasarkan wilayah",
        ]);

        // Define filters data
        $filters = [
            'search' => $request->query('search', ''), // Optional: use query to pre-fill search
            'perPage' => $perPage,
        ];

        return Inertia::render('PilkadaWilayah',[
            'wilayahs' => $wilayahs,
            'filters' => $filters
        ]);

    }

    public function surat_suara(Request $request, string $jenis, string $nama_dapil = "", string $kode_wilayah = "")
    {
        if(!is_numeric($kode_wilayah) || !($paslons = $this->pilkada->getPaslonWilayah($kode_wilayah))){
            abort(404);
            exit();
        }

        if(url()->current() != $paslons->url ){
            return redirect($paslons->url, 301);
        }

        if(empty(get_object_vars($wilayah = $this->pilkada->wilayah))){
            $wilayah = $this->pilkada->getWilayah((object)['kode_wilayah' => $kode_wilayah]);
        }
        
        if(!empty(config('app.meta')['pilkada']['surat-suara'][strtolower(explode(" ", $paslons->type)[0])]['description'])){
            $meta_desc = config('app.meta')['pilkada']['surat-suara'][strtolower(explode(" ", $paslons->type)[0])]['description'];
        }else{
            $meta_desc = "";            
        }
        $this->meta->setTitle("Surat Suara Calon {$paslons->type} {$wilayah->title} Pilkada 2024");

        foreach ($paslons->data as $paslon) {
            $this->meta->addMetaKeywords([
                strtolower(str_replace(",", ".", $paslon->nama))
            ]);
        }

        $meta_desc = preg_replace('/\[wilayah\]/', $wilayah->title, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        $keywords = [
            "Pilkada {$wilayah->title} 2024",
            "Calon {$paslons->type}",
        ];

        $this->meta->addMetaKeywords($keywords);

        $this->meta->setMeta($metadata);

        $this->genhancement->add([
            '@type' => "BreadcrumbList",
            'itemListElement' => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Home",
                    "item" => "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/pilkada/"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => "Surat Suara",
                    "item" => "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/pilkada/wilayah"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 3,
                    "name" => "{$wilayah->title}",
                    "item" => $paslons->url
                ],
            ]
        ]);

        return Inertia::render("SuratSuaraPilkada", [
            'paslons' => $paslons,
            'wilayah' => $wilayah
        ]);
    }

    public function profil(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_calon = "", string $calon_id = "")
    {
        if(!is_numeric($calon_id) || !($calon = $this->pilkada->getCalon($calon_id))){
            abort(404);
            exit();
        }

        if(url()->current() != $calon->url ){
            return redirect($calon->url, 301);
        }

        if(empty(get_object_vars($wilayah = $this->pilkada->wilayah))){
            $wilayah = $this->pilkada->getWilayah($calon->paslon ?? $calon->wakil_paslon);
        }

        if(!empty(config('app.meta')['pilkada']['profil-calon']['description'])){
            $meta_desc = config('app.meta')['pilkada']['profil-calon']['description'];
        }
        $this->meta->setTitle("Profil {$calon->nama}");

        $this->meta->addMetaKeywords([
            strtolower(str_replace(",", ".", $calon->nama))
        ]);
        if($calon->nama != $calon->alias){
            $this->meta->addMetaKeywords([
                strtolower(str_replace(",", ".", $calon->alias))
            ]);
        }

        $meta_desc = preg_replace('/\[nama_calon\]/', $calon->nama, $meta_desc);
        $meta_desc = preg_replace('/\[title\]/', ucwords($calon->type), $meta_desc);
        $meta_desc = preg_replace('/\[wilayah\]/', $wilayah->title, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        $keywords = [
            $calon->nama,
            "Pilkada {$wilayah->title} 2024",
            "Calon {$calon->type}",
        ];

        $this->meta->addMetaKeywords($keywords);

        $this->meta->setMeta($metadata);

        $metaimage = [
            'image' => $calon->image_url,
            'image:type' => 'image/'.pathinfo($calon->image_url, PATHINFO_EXTENSION),
            'image:width' => 400,
            'image:height' => 400
        ];
        $this->meta->setMeta($metaimage);

        $this->genhancement->add([
            '@type' => "BreadcrumbList",
            'itemListElement' => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Home",
                    "item" => "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/pilkada/"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => "Profil",
                    "item" => "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/pilkada/calon"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 3,
                    "name" => "{$calon->nama}",
                    "item" => $calon->url
                ],
            ]
        ]);

        $this->genhancement->add([
            '@type' => "ProfilePage",
            'mainEntity' => [
                '@type' => "Person",
                'name' => $calon->nama,
                'image' => $calon->image_url,
                'nationality' => "Indonesia",
            ]
        ]);

        return Inertia::render("ProfilCakada", [
            'calon' => $calon,
            'wilayah' => $wilayah
        ]);
    }

    public function paslon(Request $request, string $jenis, string $nama_dapil = "", string $kode_dapil = "", string $nama_paslon = "", string $paslon_id = "")
    {
        if(!is_numeric($paslon_id) || !($paslon = $this->pilkada->getPaslon($paslon_id, true))){
            abort(404);
            exit();
        }

        if(url()->current() != $paslon->url ){
            return redirect($paslon->url, 301);
        }

        if(empty(get_object_vars($wilayah = $this->pilkada->wilayah))){
            $wilayah = $this->pilkada->getWilayah($paslon);
        }

        if(!empty(config('app.meta')['pilkada']['pasangan-calon']['description'])){
            $meta_desc = config('app.meta')['pilkada']['pasangan-calon']['description'];
        }
        $this->meta->setTitle("{$paslon->nama}");

        $this->meta->addMetaKeywords([
            strtolower(str_replace(",", ".", $paslon->nama))
        ]);

        $meta_desc = preg_replace('/\[nama_paslon\]/', $paslon->nama, $meta_desc);
        $meta_desc = preg_replace('/\[title\]/', ucwords($paslon->type), $meta_desc);
        $meta_desc = preg_replace('/\[wilayah\]/', $wilayah->title, $meta_desc);
        $metadata = ['description' => $meta_desc ];

        $keywords = [
            $paslon->nama,
            "Pilkada {$wilayah->title} 2024",
            "Calon {$paslon->type}",
        ];

        $this->meta->addMetaKeywords($keywords);

        $this->meta->setMeta($metadata);

        if(empty($paslon->image_url)){
            $paslon->image_url = "https://www.lezen.id/assets/img/infopemilu-square-1.webp";
        }

        $metaimage = [
            'image' => $paslon->image_url,
            'image:type' => 'image/'.pathinfo($paslon->image_url, PATHINFO_EXTENSION),
            'image:width' => 800,
            'image:height' => 800
        ];
        $this->meta->setMeta($metaimage);

        $this->genhancement->add([
            '@type' => "BreadcrumbList",
            'itemListElement' => [
                [
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Home",
                    "item" => "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/pilkada/"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 2,
                    "name" => "Profil",
                    "item" => "{$request->getScheme()}://{$request->getHttpHost()}{$this->detectProxy()}/pilkada/pasangan-calon"
                ],
                [
                    "@type" => "ListItem",
                    "position" => 3,
                    "name" => "{$paslon->nama}",
                    "item" => $paslon->url
                ],
            ]
        ]);

        $this->genhancement->add([
            '@type' => "ProfilePage",
            'mainEntity' => [
                '@type' => "Person",
                'name' => $paslon->nama,
                'image' => $paslon->image_url,
                'nationality' => "Indonesia",
            ]
        ]);

        return Inertia::render("PasanganCakada", [
            'paslon' => $paslon,
            'wilayah' => $wilayah
        ]);
    }
    
    private function detectProxy()
    {
        // You can implement your own logic to detect the proxy
        // For example, check if there is a specific header indicating the proxy
        // If no proxy, return an empty string
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? '/proxy' : '';
    }

    private function setGeneralEnhancement(){
        $this->genhancement->add([
            '@type' => "WebSite",
            'url' => URL::to('/'),
            'potentialAction' => [
                "@type"=>"SearchAction",
                "target" => [
                    "@type"=>"EntryPoint",
                    "urlTemplate"=> URL::to('/cari')."#gsc.q={search_term_string}"
                ],
                "query-input"=> "required name=search_term_string"
            ]
        ]);
    }
}
