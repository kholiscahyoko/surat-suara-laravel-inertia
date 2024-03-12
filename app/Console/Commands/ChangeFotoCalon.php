<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\CacheHelper;
use App\Models\Calons;

class ChangeFotoCalon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calon:change-foto {id} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change foto calon from database and cache';

    protected $cache;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id_calon = $this->argument('id');
        $url_foto = $this->argument('url');

        $this->handeIdCalon($id_calon, $url_foto);
    }

    private function handeIdCalon($id_calon, $url_foto){
        $calon = Calons::find($id_calon);

        if(empty($calon)){
            echo "DATA IS NOT FOUND\n";
            exit;
        }

        echo "CALON DATA: \n";

        echo json_encode($calon);
        echo "\n";

        echo "{$calon->foto}\n";

        $this->cache = new CacheHelper();

        // PROFIL_CALON_ID:$id_calon
        $key = "profil_calon_id:{$id_calon}";

        echo "PROCESSING DELETE KEY => {$key}\n";

        // FROM STANDARD CACHE
        echo "STANDARD CACHE\n";
        $this->handleDelete($key);
        echo "\n";

        // FROM REDIS
        echo "REDIS\n";
        // $this->handleDelete($key, true);
        echo "===========================\n\n";


        // profil_calon:jenis_dewan:md5(foto)

        if(strlen($calon->kode_dapil) === 2){
            $hash = md5("../".$calon->foto);
        }else{
            $hash = md5($calon->foto);
        }

        $new_hash = md5($url_foto);

        $key = "profil_calon:{$calon->dapil->jenis_dewan}:{$hash}.json";
        $new_key = "profil_calon:{$calon->dapil->jenis_dewan}:{$new_hash}.json";

        echo "PROCESSING DELETE KEY => {$key}\n";

        // FROM STANDARD CACHE
        echo "STANDARD CACHE\n";
        if($content = $this->handleDelete($key)){
            $this->handleStore($new_key, $content);
        }
        echo "\n";

        // FROM REDIS
        echo "REDIS\n";
        // $this->handleDelete($key, true);
        // if($content = $this->handleDelete($key, true)){
        //     $this->handleStore($new_key, $content, true);
        // }
        echo "===========================\n\n";

        // FROM DATABASE
        echo "DATABASE\n";
        // if($calon->update(['foto' => $url_foto])){
        //     echo "DATA ID CALON : {$id_calon} HAS BEEN SUCCESSFULLY UPDATED ON DATABASE\n";
        // }else{
        //     echo "DATA ID CALON : {$id_calon} HAS BEEN FAILED TO BE UPDATED ON DATABASE\n";
        // }
        echo "===========================\n\n";
    }

    private function handleDelete($key, $useRedis=false){
        if($content = $this->cache->get($key, $useRedis)){
            echo "{$key} is EXIST\n";
            echo "ATTEMPT TO DEL\n";
            if($this->cache->del($key)){
                echo "{$key} is SUCCESSFULLY DELETED\n";
            }
            return $content;
        }else{
            echo "{$key} is NOT EXIST\n";
            return false;
        }
    }

    private function handleStore($key, $content, $useRedis=false){
        echo "ATTEMPT TO CREATE KEY {$key}\n";
        if($this->cache->set($key, $content, $useRedis)){
            echo "{$key} is SUCCESSFULLY CREATED\n";
        }
    }
}
