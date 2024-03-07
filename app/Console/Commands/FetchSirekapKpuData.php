<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Dapils;

class FetchSirekapKpuData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sirekap:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'FETCH KPU DATA';

    //configs

    protected $configs_urls = [
        'master' => [
            'pilpres' => 'https://sirekap-obj-data.kpu.go.id/pemilu/ppwp.json',
            'partai' => 'https://sirekap-obj-data.kpu.go.id/pemilu/partai.json',
            'caleg' => 'https://sirekap-obj-data.kpu.go.id/pemilu/caleg/[jenis_dewan]/[kode_dapil].json'
        ],
        'suara' => [
            'pilpres' => 'https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/ppwp.json',
            'dpd' => 'https://sirekap-obj-data.kpu.go.id/pemilu/hhcw/pdpd/[kode_dapil].json',
            'dpr' => 'https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdpr/[kode_dapil].json',
            'dprdp' => 'https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdprdp/[kode_provinsi]/[kode_dapil].json',
            'dprdk' => 'https://sirekap-obj-data.kpu.go.id/pemilu/hhcd/pdprdk/[kode_provinsi]/[kode_kabkota]/[kode_dapil].json',
        ],
        'wilayah' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/ppwp/[kode_wilayah].json'
    ];

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */

    public function handle()
    {
        // Fetch Pilpres
        $url = $this->configs_urls['master']['pilpres'];
        $result = $this->hitRequest($url);
        if($result){
            $this->getFromFile($url);
        }else{
            echo "ERROR REQUEST MASTER PILPRES\n";
        }

        $url_suara = $this->configs_urls['suara']['pilpres'];
        $result = $this->hitRequest($url_suara);
        if($result){
            $this->getFromFile($url_suara);
        }else{
            echo "ERROR REQUEST SUARA PILPRES\n";
        }

        $url_wilayah = preg_replace('/\[kode_wilayah\]/', 0, $this->configs_urls['wilayah']);
        $result = $this->hitRequest($url_wilayah);
        if($result){
            $this->getFromFile($url_wilayah);
        }else{
            echo "ERROR REQUEST WILAYAH PILPRES\n";
        }

        // Fetch Partai
        $url = $this->configs_urls['master']['partai'];
        $result = $this->hitRequest($url);
        if($result){
            $this->getFromFile($url);
        }else{
            echo "ERROR REQUEST MASTER PARTAI\n";
        }

        // Fetch Nasional DPR
        $url = $this->configs_urls['suara']['dpr'];
        $url = preg_replace("/\[kode_dapil\]/", 0, $url);
        $result = $this->hitRequest($url);
        if($result){
            $this->getFromFile($url);
        }else{
            echo "ERROR REQUEST SUARA NASIONAL DPR RI\n";
        }

        // Fetch data from the database
        $data = Dapils::all(); // Replace YourModel with the appropriate model

        // Do something with the fetched data
        foreach ($data as $dapil) {
            $this->info($dapil->toJson());
            // You can perform any further processing here

            // FETCH MASTER CALEG
            $url = $this->configs_urls['master']['caleg'];
            if($dapil->jenis_dewan == "dpd"){
                $url = preg_replace("/\[jenis_dewan\]/", "dpd", $url);

                $url_wilayah = $this->configs_urls['wilayah'];
                $url_wilayah = preg_replace("/\[kode_wilayah\]/", $dapil->kode_dapil, $url_wilayah);
                $result = $this->hitRequest($url_wilayah);
                if($result){
                    $this->getFromFile($url_wilayah);
                }else{
                    echo "ERROR REQUEST WILAYAH DPD DAPIL:{$dapil->kode_dapil}\n";
                }
                    
            }else{
                $url = preg_replace("/\[jenis_dewan\]/", "partai", $url);
            }
            $url = preg_replace("/\[kode_dapil\]/", $dapil->kode_dapil, $url);
            $result = $this->hitRequest($url);
            if($result){
                $this->getFromFile($url);
            }else{
                echo "ERROR REQUEST MASTER CALEG {$dapil->jenis_dewan}; DAPIL:{$dapil->kode_dapil}\n";
            }

            // Fetch SUARA DAPIL
            $url = $this->configs_urls['suara'][$dapil->jenis_dewan];
            $url = preg_replace("/\[kode_dapil\]/", $dapil->kode_dapil, $url);
            switch ($dapil->jenis_dewan) {
                case 'dprdp':
                    $url = preg_replace("/\[kode_provinsi\]/", substr($dapil->kode_dapil, 0, 2), $url);
                    break;

                case 'dprdk':
                    $url = preg_replace("/\[kode_provinsi\]/", substr($dapil->kode_dapil, 0, 2), $url);
                    $url = preg_replace("/\[kode_kabkota\]/", substr($dapil->kode_dapil, 0, 4), $url);
                    break;
                
                default:
                    break;
            }

            $result = $this->hitRequest($url);
            if($result){
                $this->getFromFile($url);
            }else{
                echo "ERROR REQUEST SUARA CALEG {$dapil->jenis_dapil}; DAPIL :{$dapil->kode_dapil}\n";
            }
        }
    }

    private function hitRequest($url){
        $response = Http::withHeaders([
            'Referer' => 'https://pemilu2024.kpu.go.id'
        ])->retry(10, 200)->get($url);
        if($response->ok()){
            return $this->saveToFile($url, $response->object());
        }
        return false;
    }

    private function saveToFile($url, $data){
        // Remove protocol and host
        $directory = parse_url($url, PHP_URL_PATH);

        $filename = basename($directory);
        $directory = dirname($directory);

        // Create the directory if it doesn't exist
        Storage::makeDirectory($directory);

        // Define the file path
        $filePath = $directory . '/' . $filename;

        // Store the data in the JSON file
        return Storage::put($filePath, json_encode($data));
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
            // $fileContents = Storage::get($filePath);
            // Output or process the file contents as needed
            // echo "{$fileContents}\n";
            echo "OK; URL {$url}\n";
        } else {
            // File does not exist
            echo "BAD; URL {$url}; File does not exist.\n";
        }
    }
}
