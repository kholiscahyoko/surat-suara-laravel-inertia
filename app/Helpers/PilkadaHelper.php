<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Kabkota;
use App\Models\Provinsi;
use App\Models\PilkadaCalons;
use App\Helpers\CacheHelper;
use App\Helpers\ImageAssetHelper;
use App\Models\Partais;
use App\Models\PilkadaPaslons;

class PilkadaHelper {

    public object $cache;
    public object $image;
    public object $calon;
    public object $wilayah;
    private array $regions;
    public int $ttl;

    public function __construct() {
        $this->cache = new CacheHelper();
        $this->image = new ImageAssetHelper();
        $this->wilayah = (object)[];
        $this->ttl = 30;
        $this->regions = [
            'sumatera' => [1, 2],
            'jawa' => [3],
            'bali-nusa' => [5],
            'kalimantan' => [6],
            'sulawesi' => [7],
            'maluku-papua' => [8, 9]
        ];
    }

    public function getData($filePath){
        if (Storage::exists($filePath)) {
            // File exists, so retrieve its contents
            $fileContents = Storage::get($filePath);
            // Output or process the file contents as needed
            return (object) json_decode($fileContents);
        } else {
            // File does not exist
            return false;
        }
    }

    public function getAllWilayah(){
        $key = 'pilkada_all_wilayah';
        if(!($wilayahs = $this->getCache($key))){
            $provinsis = Provinsi::where('kode_wilayah', '!=', 34)->select('kode_wilayah', 'nama')->get()->toArray();
            $kabkotas = Kabkota::where('kode_wilayah', 'not like', "31%")->select('kode_wilayah', 'nama')->get()->toArray();
            $wilayahs = array_merge($provinsis, $kabkotas);

            foreach ($wilayahs as $key => $wilayah) {
                $wilayah = (object) $wilayah;
                $wilayah->title = $this->getWilayahTitle($wilayah);
                $wilayah->title_kada = $this->getTitleKada($wilayah);
                $type = "{$wilayah->title_kada} DAN WAKIL {$wilayah->title_kada}";
    
                $wilayah->url = $this->getSuratSuaraUrl($type, $wilayah);
                $wilayah->realcount_url = $this->getRealcountUrl($type, $wilayah);
                // $wilayah->image_url = "https://images.lezen.id/logo_pemda/{$wilayah->kode_wilayah}-".(strlen($wilayah->kode_wilayah) == 2 ? Str::slug($wilayah->nama) :Str::slug($wilayah->title)).".webp";
                $wilayah->image_url = asset('assets/img/shield.webp');

                $wilayahs[$key] = $wilayah;
            }

            $this->setCache($key, $wilayahs);
        }

        return $wilayahs;
    }

    public function getCalon($id){
        $key = 'pilkada_profil_calon_id:'.$id;
        if(!($calon = $this->getCache($key))){
            if($calon = PilkadaCalons::with('paslon', 'wakil_paslon')->find($id)){
                $data_profil = $this->getData("pilkada_db/calon/{$calon->kode_calon}.json");
                if($data_profil){
                    $calon->image_url = $this->image->getUrl($data_profil->data->image_url);
                    $calon->details = $data_profil->data->details;
                    $calon->pekerjaan = $data_profil->data->Pekerjaan;
                    $calon->riwayat_pendidikan = $data_profil->data->{"Riwayat Pendidikan"};
                    $calon->riwayat_kursus_diklat = $data_profil->data->{"Riwayat Kursus/Diklat"};
                    $calon->riwayat_organisasi = $data_profil->data->{"Riwayat Organisasi"};
                    $calon->riwayat_tanda_penghargaan = $data_profil->data->{"Riwayat Tanda Penghargaan"};
                    $calon->riwayat_publikasi = $data_profil->data->{"Riwayat Publikasi"};
                    $wilayah = $this->getWilayah($calon->paslon ?? $calon->wakil_paslon);
                    $this->wilayah = $wilayah;
                    $title_kada = $this->getTitleKada($wilayah);

                    $calon->type = $this->getJenis($title_kada, $calon->wakil_paslon);
                    $calon->url = $this->getCalonUrl($calon, $wilayah);

                    $paslon = $calon->paslon ?? $calon->wakil_paslon;
                    $paslon->type = "{$title_kada} DAN WAKIL {$title_kada}";

                    $calon->pasangan = $this->getPasangan($calon, $wilayah);
                    $calon->paslon_url = $this->getPaslonUrl($paslon, $wilayah);

                    $this->setCache($key, $calon);
                }
            }
        }

        return $calon;
    }

    public function getPaslon($id, $all = false){
        $key = 'pilkada_paslon_id:'.$id;
        if(!($paslon = $this->getCache($key)) || (!$paslon->all && $all)){
            if($paslon = PilkadaPaslons::with('calon', 'wakil_calon')->find($id)){
                $data_paslon = $this->getData("pilkada_db/pasangan/{$paslon->kode_paslon}.json");
                if($data_paslon){
                    $paslon->partais = array_map([$this, 'getPartais'], $data_paslon->parties);
                    $paslon->image_url = $this->image->getUrl($data_paslon->image_url);
                }
                if($all){
                    $visi_misi = $this->getData("pilkada_db/visi_misi/{$paslon->kode_paslon}.json");
                    $paslon->visi_misi = $visi_misi;
                }
                $wilayah = $this->getWilayah($paslon);
                $this->wilayah = $wilayah;
                $title_kada = $this->getTitleKada($wilayah);

                $paslon->type = "{$title_kada} DAN WAKIL {$title_kada}";

                $calon = $this->getCalon($paslon->calon->id);
                $wakil_calon = $this->getCalon($paslon->wakil_calon->id);
                $paslon->calon->url = $calon->url;
                $paslon->calon->image_url = $calon->image_url;
                $paslon->calon->type = $this->getJenis($title_kada, false);
                $paslon->wakil_calon->url = $wakil_calon->url;
                $paslon->wakil_calon->image_url = $wakil_calon->image_url;
                $paslon->wakil_calon->type = $this->getJenis($title_kada, true);
                $paslon->url = $this->getPaslonUrl($paslon, $wilayah);
                $paslon->all = $all;

                $this->setCache($key, $paslon);
            }
        }

        return $paslon;
    }

    public function getAgendaKampanye($id){
        $key = 'pilkada_agenda_kampanye_paslon:'.$id;
        if(!($paslon = $this->getCache($key))){
            if($paslon = $this->getPaslon($id)){
                $data_kampanye = $this->getData("pilkada_db/kampanye/{$paslon->kode_paslon}.json");
                $paslon->agenda_kampanye = "";
                if($data_kampanye){
                    if(!empty($data_kampanye->{"LAPORAN KAMPANYE"})){
                        $agenda_kampanye = $data_kampanye->{"LAPORAN KAMPANYE"};
                        usort($agenda_kampanye, function($a, $b) {
                            return strtotime($b->Tanggal) - strtotime($a->Tanggal);
                        });
                        $paslon->agenda_kampanye = $agenda_kampanye;       

                    }
                }
                $this->setCache($key, $paslon);
            }
        }

        return $paslon;
    }

    public function getPaslonWilayah($kode_wilayah){
        $key = 'pilkada_paslon_wilayah:'.$kode_wilayah;
        if(!($paslons = $this->getCache($key))){
            $wilayah = $this->getWilayah((object)[ 'kode_wilayah' => $kode_wilayah]);

            if($wilayah === null){
                return false;
            }
            
            $this->wilayah = $wilayah;
            $title_kada = $this->getTitleKada($wilayah);
            $paslons_set = PilkadaPaslons::with('calon', 'wakil_calon')->where('kode_wilayah', $kode_wilayah)->get();
            if($paslons_set->count() >= 1){
                $paslons = (object)[];
                $paslons->data = [];
                foreach ($paslons_set as $paslon) {
                    $paslon = $this->getPaslon($paslon->id);
                    $paslons->data[] = $paslon;
                }

                if(count($paslons->data) === 1){
                    $paslons->data = $this->addKotakKosong($paslons->data);
                }

            }
            $paslons->type = "{$title_kada} DAN WAKIL {$title_kada}";

            $paslons->url = $this->getSuratSuaraUrl($paslons->type, $wilayah);
            $paslons->realcount_url = $this->getRealcountUrl($paslons->type, $wilayah);

            $this->setCache($key, $paslons);
        }

        return $paslons;
    }

    public function getRealcount($kode_wilayah){
        $key = 'pilkada_realcount:'.$kode_wilayah;
        if(!($paslons = $this->getCache($key))){
            $wilayah = $this->getWilayah((object)[ 'kode_wilayah' => $kode_wilayah]);

            if($wilayah === null){
                return false;
            }
            
            $this->wilayah = $wilayah;
            $title_kada = $this->getTitleKada($wilayah);

            $paslons = $this->getPaslonWilayah($kode_wilayah);

            $paslons = $this->mappingMaster($wilayah, $paslons);
            $paslons = $this->mappingRealcount($wilayah, $paslons);

            $paslons->type = "{$title_kada} DAN WAKIL {$title_kada}";

            $paslons->surat_suara_url = $paslons->url;
            $paslons->url = $this->getRealcountUrl($paslons->type, $wilayah);

            $this->setCache($key, $paslons);
        }

        return $paslons;
    }

    public function getJenis($title, $is_wakil){
        if($is_wakil){
            return "WAKIL {$title}";
        }
        return $title;
    }

    private function addKotakKosong($paslons){
        $new_paslons = [];
        $paslon = $paslons[0];
        $kotak_kosong = (object)[];
        $kotak_kosong->nama = "";
        if($paslon->no_urut === 1){
            $kotak_kosong->no_urut = 2;
            $new_paslons = [
                $paslon,
                $kotak_kosong,
            ];
        }else{
            $kotak_kosong->no_urut = 1;
            $new_paslons = [
                $kotak_kosong,
                $paslon,
            ];
        }
        return $new_paslons;
    }

    public function getCalonUrl($calon, $wilayah){
        return url("pilkada/profil-calon/".Str::slug($calon->type)."/".Str::slug($wilayah->nama)."/{$wilayah->kode_wilayah}/".Str::slug($calon->alias)."/{$calon->id}");
    }

    public function getPaslonUrl($paslon, $wilayah){
        return url("pilkada/pasangan-calon/".Str::slug($paslon->type)."/".Str::slug($wilayah->nama)."/{$wilayah->kode_wilayah}/".Str::slug($paslon->nama)."/{$paslon->id}");
    }

    public function getSuratSuaraUrl($title, $wilayah){
        return url("pilkada/surat-suara/".Str::slug($title)."/".Str::slug($wilayah->nama)."/{$wilayah->kode_wilayah}");
    }

    public function getRealcountUrl($title, $wilayah){
        return url("pilkada/realcount/".Str::slug($title)."/".Str::slug($wilayah->nama)."/{$wilayah->kode_wilayah}");
    }

    public function getTitleKada($wilayah){
        return strlen($wilayah->kode_wilayah) == 2 ? "GUBERNUR" : (preg_match("/^KOTA\s/i", $wilayah->nama) ? "WALIKOTA" : "BUPATI");
    }

    public function getWilayah($data, $ignore_attr = false){
        // if($ignore_attr || empty(get_object_vars($wilayah = $this->wilayah))){
            $cacheKey = 'pilkada_wilayah:'.$data->kode_wilayah;
            if(!($wilayah = $this->getCache($cacheKey))){
                $wilayah = strlen($data->kode_wilayah) == 2 ? Provinsi::where('kode_wilayah', $data->kode_wilayah)->select('nama', 'kode_wilayah')->first() : Kabkota::where('kode_wilayah', $data->kode_wilayah)->select('nama', 'kode_wilayah')->first();
                if($wilayah){
                    $wilayah->title = $this->getWilayahTitle($wilayah);
                    $wilayah->title_kada = $this->getTitleKada($wilayah);
                    $type = "{$wilayah->title_kada} DAN WAKIL {$wilayah->title_kada}";
        
                    $wilayah->url = $this->getSuratSuaraUrl($type, $wilayah);
                    $wilayah->realcount_url = $this->getRealcountUrl($type, $wilayah);
                    // $wilayah->image_url = "https://images.lezen.id/logo_pemda/{$wilayah->kode_wilayah}-".(strlen($data->kode_wilayah) == 2 ? Str::slug($wilayah->nama) :Str::slug($wilayah->title)).".webp";
                    $wilayah->image_url = asset('assets/img/shield.webp');
        
                    $this->setCache($cacheKey, $wilayah);
                }
            }
        // }

        return $wilayah;
    }

    public function getWilayahTerkait($data){
        $cacheKey = 'pilkada_wilayah_terkait:'.$data->kode_wilayah;
        if(!($terkait = $this->getCache($cacheKey))){
            if (strlen($data->kode_wilayah) == 2) {
                foreach ($this->regions as $ids) {
                    if (in_array(substr($data->kode_wilayah, 0, 1), $ids)) {
                        if (count($ids) === 2) {
                            $wilayahs = Provinsi::where('kode_wilayah', 'like', $ids[0]."%")
                            ->orWhere('kode_wilayah', 'like', $ids[1]."%")
                            ->where('kode_wilayah', '!=', $data->kode_wilayah)
                            ->where('kode_wilayah', '!=', "34")
                            ->select('kode_wilayah')->inRandomOrder()->get();
                        }else{
                            $wilayahs = Provinsi::where('kode_wilayah', 'like', $ids[0]."%")
                            ->where('kode_wilayah', '!=', $data->kode_wilayah)
                            ->where('kode_wilayah', '!=', "34")
                            ->select('kode_wilayah')->inRandomOrder()->get();
                        }
                        break;
                    }
                }
            }else{
                $wilayahs = Kabkota::where('kode_wilayah', 'like', substr($data->kode_wilayah, 0, 2)."%")
                ->where('kode_wilayah', '!=', $data->kode_wilayah)
                ->select('kode_wilayah')->inRandomOrder()->get();
            }
            $terkait = [];
            foreach ($wilayahs as $row) {
                $terkait[] = $this->getWilayah($row);
                if (count($terkait)>=3) {
                    break;
                }
            }
            if($terkait){
                (object) $terkait;
                $this->setCache($cacheKey, $terkait);
            }
        }

        return $terkait;
    }

    public function getPartais($no_urut){
        $cacheKey = 'pilkada_partai:'.$no_urut;
        if(!($partai = $this->getCache($cacheKey))){
            $partai = Partais::where("no_urut", $no_urut)->select(['id', 'no_urut', 'nama'])->first();
            if($partai){
                $this->setCache($cacheKey, $partai);
            }
        }

        return $partai;
    }

    public function getPasangan($calon, $wilayah){
        $paslon = $calon->paslon ?? $calon->wakil_paslon;
        $kode_pasangan = $calon->kode_calon == $paslon->kode_calon ? $paslon->kode_wakil : $paslon->kode_calon;
        $pasangan = PilkadaCalons::where("kode_calon", $kode_pasangan)->first();
        $title_kada = $this->getTitleKada($wilayah);
        $pasangan->type = $this->getJenis($title_kada, $kode_pasangan == $paslon->kode_wakil);

        $pasangan->url = $this->getCalonUrl($pasangan, $wilayah);

        return $pasangan;
    }

    public function getWilayahTitle($data){
        return strlen($data->kode_wilayah) == 2 ? "PROVINSI {$data->nama}" : (preg_match("/^Kota\s/i", $data->nama) ? $data->nama : "KABUPATEN {$data->nama}");
    }

    private function setCache($key, $content, $ttl = null){
        $ttl = $ttl ?? $this->ttl;
        $this->cache->setex($key, $ttl, gettype($content) !== 'string' ? json_encode($content): $content);
    }

    private function getCache($key){
        try {
            $cache = $this->cache->get($key);
            if($cache){
                $cache = json_decode($cache);
                // $cache->source = "cache";
                // $cache->key = $key;
            }
            return $cache;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getDataSirekap($url){
        // try {
            // // Make the HTTP GET request
            // $response = Http::withHeaders([
            //     'Referer' => 'https://pilkada2024.kpu.go.id'
            // ])->get($url);
        
            // // Check if the request was successful (status code 2xx)
            // if ($response->ok()) {
            //     $this->ok = true;
            //     return $response;
            // } else {
                // Request failed (non-2xx status code), return the result from file
                // $this->object = $this->getFromFile($url);
                // if($this->object){
                //     $this->ok = true;
                // }else{
                //     $this->ok = false;
                // }
            //     return $this;
            // }
        // } catch (\Throwable $e) {
            // An exception occurred during the request, return the result from file
            return $this->getFromFile($url);
        // }
        // Use or return $responseData as needed
    }

    private function getFromFile($url){
        // Remove protocol and host
        $directory = parse_url($url, PHP_URL_PATH);

        $filename = basename($directory);
        $directory = dirname($directory);

        // Create the directory if it doesn't exist
        Storage::makeDirectory($directory);

        // Define the file path
        $filePath = $directory . '/' . $filename;

        // Check if the file exists
        if (Storage::exists($filePath)) {
            // File exists, so retrieve its contents
            $fileContents = Storage::get($filePath);
            // Output or process the file contents as needed
            return (object) json_decode($fileContents);
        } else {
            // File does not exist
            return false;
        }
    }

    private function getMaster($wilayah){
        $type = strlen($wilayah->kode_wilayah) == 2 ? "pkwkp" : "pkwkk";
        $cacheKey = 'pilkada_master:all:'.$type;
        if(!($master = $this->getCache($cacheKey))){
            $url = "https://sirekappilkada-obj-data.kpu.go.id/pilkada/paslon/{$type}.json";
            $master = $this->getDataSirekap($url);
            $this->setCache($cacheKey, $master);
        }
        return $master;
    }

    private function getRealcountSirekap($wilayah){
        $url = strlen($wilayah->kode_wilayah) == 2 ? "https://sirekappilkada-obj-data.kpu.go.id/pilkada/hhcw/pkwkp/{$wilayah->kode_wilayah}.json" : "https://sirekappilkada-obj-data.kpu.go.id/pilkada/hhcw/pkwkk/".substr($wilayah->kode_wilayah, 0, 2)."/{$wilayah->kode_wilayah}.json";
        return $this->getDataSirekap($url);
    }

    private function mappingMaster($wilayah, $paslons){
        $master = $this->getMaster($wilayah);
        // $cacheKey = 'pilkada_master:mapping:'.$wilayah->kode_wilayah;
        // if(!($mapping = $this->getCache($cacheKey))){

            if(empty($master->{$wilayah->kode_wilayah})){
                return false;
            }
            // dd($master->{$wilayah->kode_wilayah});
            $arr_master = json_decode(json_encode($master->{$wilayah->kode_wilayah}), true);

            foreach ($paslons->data as $paslon) {
                foreach ($arr_master as $sirekap_id => $master_paslon) {
                    if($paslon->no_urut === $master_paslon['nomor_urut']){
                        $paslon->warna = $master_paslon['warna'];
                        $paslon->sirekap_id = $sirekap_id;
                        break;
                    }
                    
                }
            }

            $mapping = $paslons;
        //     $this->setCache($cacheKey, $mapping);
        // }
        return $mapping;
    }

    private function mappingRealcount($wilayah, $paslons){
        $realcount = $this->getRealcountSirekap($wilayah);

        if(empty($realcount)){
            return false;
        }
        $paslons->total_suara = 0;
        foreach ($paslons->data as $paslon) {
            $paslon->suara = $realcount->tungsura->chart->{$paslon->sirekap_id};
            $paslons->total_suara += $paslon->suara;
        }

        $paslons->progres = $realcount->tungsura->chart->progres;
        $paslons->ts = $realcount->ts;

        $mapping = $paslons;
        return $mapping;
    }
}