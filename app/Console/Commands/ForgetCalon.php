<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\CacheHelper;
use App\Models\Calons;

class ForgetCalon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calon:forget {ids}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove data calon from database and cache';

    protected $cache;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ids = $this->argument('ids');

        $ids = explode(",", $ids);

        foreach ($ids as $id_calon) {
            $this->handeIdCalon($id_calon);
        }
    }

    private function handeIdCalon($id_calon){
        $calon = Calons::find($id_calon);

        if(empty($calon)){
            echo "DATA IS NOT FOUND\n";
            exit;
        }

        echo "CALON DATA: \n";

        echo json_encode($calon);
        echo "\n";

        $this->cache = new CacheHelper();

        // PROFIL_CALON_ID:$id_calon
        $key = "profil_calon_id:{$id_calon}";

        echo "PROCESSING DELETE KEY => {$key}\n";

        // FROM STANDARD CACHE
        echo "STANDARD CACHE\n";
        $this->handeDelete($key);
        echo "\n";

        // FROM REDIS
        echo "REDIS\n";
        // $this->handeDelete($key, true);
        echo "===========================\n\n";


        // profil_calon:jenis_dewan:md5(foto)

        if(strlen($calon->kode_dapil) === 2){
            $hash = md5("../".$calon->foto);
        }else{
            $hash = md5($calon->foto);
        }

        $key = "profil_calon:{$calon->dapil->jenis_dewan}:{$hash}.json";

        echo "PROCESSING DELETE KEY => {$key}\n";

        // FROM STANDARD CACHE
        echo "STANDARD CACHE\n";
        $this->handeDelete($key);
        echo "\n";

        // FROM REDIS
        echo "REDIS\n";
        // $this->handeDelete($key, true);
        echo "===========================\n\n";
    }

    private function handeDelete($key, $useRedis=false){
        if($this->cache->get($key, $useRedis)){
            echo "{$key} is EXIST\n";
            echo "ATTEMPT TO DEL\n";
            if($this->cache->del($key)){
                echo "{$key} is SUCCESSFULLY DELETED\n";
            }
        }else{
            echo "{$key} is NOT EXIST\n";
        }
    }
}
