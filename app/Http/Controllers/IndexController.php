<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\LengthAwarePaginator;

use Inertia\Inertia;

class IndexController extends Controller
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

        $this->meta->setTitle(config('app.meta')['home']['title']);

        $data_json = '{"summary":{"jenis_kelamin":[{"jenis_kelamin":"LAKI - LAKI","jumlah":163174},{"jenis_kelamin":"PEREMPUAN","jumlah":95136}],"jenis_dewan":{"dpr":"9,917","dpd":"668","dprdp":"32,873","dprdk":"214,852"},"data_provinsi":[{"kode_wilayah":"11","jumlah_caleg":10438},{"kode_wilayah":"12","jumlah_caleg":14717},{"kode_wilayah":"13","jumlah_caleg":8103},{"kode_wilayah":"14","jumlah_caleg":7366},{"kode_wilayah":"15","jumlah_caleg":5405},{"kode_wilayah":"16","jumlah_caleg":9413},{"kode_wilayah":"17","jumlah_caleg":3836},{"kode_wilayah":"18","jumlah_caleg":7357},{"kode_wilayah":"19","jumlah_caleg":3119},{"kode_wilayah":"21","jumlah_caleg":3255},{"kode_wilayah":"31","jumlah_caleg":2216},{"kode_wilayah":"32","jumlah_caleg":21320},{"kode_wilayah":"33","jumlah_caleg":20198},{"kode_wilayah":"34","jumlah_caleg":3442},{"kode_wilayah":"35","jumlah_caleg":22796},{"kode_wilayah":"36","jumlah_caleg":6953},{"kode_wilayah":"51","jumlah_caleg":3775},{"kode_wilayah":"52","jumlah_caleg":6403},{"kode_wilayah":"53","jumlah_caleg":10367},{"kode_wilayah":"61","jumlah_caleg":7368},{"kode_wilayah":"62","jumlah_caleg":5250},{"kode_wilayah":"63","jumlah_caleg":5652},{"kode_wilayah":"64","jumlah_caleg":5325},{"kode_wilayah":"65","jumlah_caleg":2123},{"kode_wilayah":"71","jumlah_caleg":4789},{"kode_wilayah":"72","jumlah_caleg":6446},{"kode_wilayah":"73","jumlah_caleg":10755},{"kode_wilayah":"74","jumlah_caleg":6123},{"kode_wilayah":"75","jumlah_caleg":2538},{"kode_wilayah":"76","jumlah_caleg":2477},{"kode_wilayah":"81","jumlah_caleg":5339},{"kode_wilayah":"82","jumlah_caleg":4517},{"kode_wilayah":"91","jumlah_caleg":4348},{"kode_wilayah":"92","jumlah_caleg":2900},{"kode_wilayah":"93","jumlah_caleg":1949},{"kode_wilayah":"94","jumlah_caleg":4026},{"kode_wilayah":"95","jumlah_caleg":3560},{"kode_wilayah":"96","jumlah_caleg":2346}]}}';

        $data = json_decode($data_json, TRUE);

        $data["geo_provinsi"] = json_decode($this->getJsonKoordinat(), TRUE);

        return Inertia::render('Home',  $data);
    }

    public function cari(){
        $this->meta->setMeta(config('app.meta')['cari']);
        $this->meta->addMetaKeywords([
            "cari calon anggota legislatif",
            "cari caleg dpr",
            "cari caleg dpd",
            "cari caleg dprd provinsi",
            "cari caleg dprd kabupaten",
            "cari caleg dprd kota",
            "cari surat suara",
            "cari hasil pemilu",
        ]);
    
        return Inertia::render('Cari'); 
    }

    public function tentang_kami(){
        return Inertia::render('TentangKami'); 
    }

    public function privasi(){
        return Inertia::render('KebijakanPrivasi'); 
    }

    public function hubungi_kami(){
       return Inertia::render('HubungiKami'); 
    }

    private function getJsonKoordinat(){
        return '{
            "11": { "nama": "Aceh", "koordinat": [4.695135, 96.7493993] },
            "12": { "nama": "Sumatera Utara", "koordinat": [2.1153547, 99.5450974] },
            "13": { "nama": "Sumatera Barat", "koordinat": [-0.7399397, 100.8000051] },
            "14": { "nama": "Riau", "koordinat": [0.2933469, 101.7068294] },
            "15": { "nama": "Jambi", "koordinat": [-1.4851831, 102.4380581] },
            "16": { "nama": "Sumatera Selatan", "koordinat": [-3.3194374, 103.914399] },
            "17": { "nama": "Bengkulu", "koordinat": [-3.5778471, 102.3463875] },
            "18": { "nama": "Lampung", "koordinat": [-4.5585849, 105.4068079] },
            "19": { "nama": "Kepulauan Bangka Belitung", "koordinat": [-2.7410513, 106.4405872] },
            "21": { "nama": "Kepulauan Riau", "koordinat": [1.0745026, 103.9942166] },
            "31": { "nama": "DKI Jakarta", "koordinat": [-6.211544, 106.845172] },
            "32": { "nama": "Jawa Barat", "koordinat": [-7.090911, 107.668887] },
            "33": { "nama": "Jawa Tengah", "koordinat": [-7.150975, 110.1402594] },
            "34": { "nama": "DI Yogyakarta", "koordinat": [-7.8753849, 110.4262088] },
            "35": { "nama": "Jawa Timur", "koordinat": [-7.5360639, 112.2384017] },
            "36": { "nama": "Banten", "koordinat": [-6.4058172, 106.0640179] },
            "51": { "nama": "Bali", "koordinat": [-8.4095178, 115.188916] },
            "52": { "nama": "Nusa Tenggara Barat", "koordinat": [-8.6529334, 117.3616476] },
            "53": { "nama": "Nusa Tenggara Timur", "koordinat": [-8.6573819, 121.0793705] },
            "61": { "nama": "Kalimantan Barat", "koordinat": [-0.2787808, 111.4752851] },
            "62": { "nama": "Kalimantan Tengah", "koordinat": [-1.6814878, 113.3823545] },
            "63": { "nama": "Kalimantan Selatan", "koordinat": [-3.0926415, 115.2837585] },
            "64": { "nama": "Kalimantan Timur", "koordinat": [0.5269395, 116.3604420] },
            "65": { "nama": "Kalimantan Utara", "koordinat": [2.9657501, 116.0290327] },
            "71": { "nama": "Sulawesi Utara", "koordinat": [0.6246932, 123.9750018] },
            "72": { "nama": "Sulawesi Tengah", "koordinat": [-1.4300254, 121.4456179] },
            "73": { "nama": "Sulawesi Selatan", "koordinat": [-3.6687994, 119.9740534] },
            "74": { "nama": "Sulawesi Tenggara", "koordinat": [-4.14491, 122.174605] },
            "75": { "nama": "Gorontalo", "koordinat": [0.6999372, 122.4467238] },
            "76": { "nama": "Sulawesi Barat", "koordinat": [-2.8441371, 119.2320784] },
            "81": { "nama": "Maluku", "koordinat": [-3.2384616, 130.1452734] },
            "82": { "nama": "Maluku Utara", "koordinat": [1.5709993, 127.8087693] },
            "91": { "nama": "Papua", "koordinat": [-2.1522631, 138.5943707] },
            "92": { "nama": "Papua Barat", "koordinat": [-2.1466491, 133.3001700] },
            "93": { "nama": "Papua Selatan", "koordinat": [-6.9058665, 139.1928020] },
            "94": { "nama": "Papua Tengah", "koordinat": [-3.8049044, 136.4372756] },
            "95": { "nama": "Papua Pegunungan", "koordinat": [-4.1439114, 139.4066293] },
            "96": { "nama": "Papua Barat Daya", "koordinat": [-0.8424344, 131.3005577] }
          }
          ';
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
