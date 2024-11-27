<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Provinsi;
use App\Models\Kabkota;
use PhpParser\Node\Stmt\TryCatch;

class FetchSirekapPilkadaKpuData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sirekap-pilkada:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'FETCH KPU DATA';

    //configs

    protected $configs_urls = [
        'master' => [
            'pkwkp' => 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/paslon/pkwkp.json',
            'pkwkk' => 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/paslon/pkwkk.json'
        ],
        'suara' => [
            'pkwkp' => 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/hhcw/pkwkp/[kode_provinsi].json',
            'pkwkk' => 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/hhcw/pkwkk/[kode_provinsi]/[kode_kabkota].json'
        ],
        'rekap' => [
            'pkwkp' => 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/hr/pkwkp/[kode_provinsi].json',
            'pkwkk' => 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/hr/pkwkk/[kode_provinsi]/[kode_kabkota].json'
        ],
        // 'wilayah' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/ppwp/[kode_wilayah].json'
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
        // Fetch Gubernur
        $url = $this->configs_urls['master']['pkwkp'];
        $result = $this->hitRequest($url);
        if($result){
            $this->getFromFile($url);
        }else{
            echo "ERROR REQUEST MASTER GUBERNUR\n";
        }


        // FETCH REAL COUNT Gubernur
        $data = Provinsi::all(); // Replace YourModel with the appropriate model

        // Do something with the fetched data
        foreach ($data as $wilayah) {
            $this->info($wilayah->toJson());
            // You can perform any further processing here

            // Fetch SUARA Provinsi
            $url = $this->configs_urls['suara']["pkwkp"];
            $url = preg_replace("/\[kode_provinsi\]/", substr($wilayah->kode_wilayah, 0, 2), $url);
            $url = preg_replace("/\[kode_kabkota\]/", $wilayah->kode_wilayah, $url);

            $result = $this->hitRequest($url);
            if($result){
                $this->getFromFile($url);
            }else{
                echo "ERROR REQUEST SUARA GUBERNUR PROVINSI :{$wilayah->nama} {$url}\n";
            }

            // Fetch HASIL REKAP DAPIL
            $url = $this->configs_urls['rekap']["pkwkp"];
            $url = preg_replace("/\[kode_provinsi\]/", substr($wilayah->kode_wilayah, 0, 2), $url);
            $url = preg_replace("/\[kode_kabkota\]/", $wilayah->kode_wilayah, $url);

            $result = $this->hitRequest($url);
            if($result){
                $this->getFromFile($url);
            }else{
                echo "ERROR REQUEST REKAP GUBERNUR PROVINSI :{$wilayah->nama} {$url}\n";
            }
        }

        // Fetch Bupati / Walikota
        $url = $this->configs_urls['master']['pkwkk'];
        $result = $this->hitRequest($url);
        if($result){
            $this->getFromFile($url);
        }else{
            echo "ERROR REQUEST MASTER Bupati/Walikota\n";
        }

        // FETCH REAL COUNT Bupati/Walikota
        $data = Kabkota::all(); // Replace YourModel with the appropriate model

        // Do something with the fetched data
        foreach ($data as $wilayah) {
            $this->info($wilayah->toJson());
            // You can perform any further processing here

            // Fetch SUARA Provinsi
            $url = $this->configs_urls['suara']["pkwkk"];
            $url = preg_replace("/\[kode_provinsi\]/", substr($wilayah->kode_wilayah, 0, 2), $url);
            $url = preg_replace("/\[kode_kabkota\]/", $wilayah->kode_wilayah, $url);

            $result = $this->hitRequest($url);
            if($result){
                $this->getFromFile($url);
            }else{
                echo "ERROR REQUEST SUARA Bupati/Walikota :{$wilayah->nama}  {$url}\n";
            }

            // Fetch HASIL REKAP DAPIL
            $url = $this->configs_urls['rekap']["pkwkk"];
            $url = preg_replace("/\[kode_provinsi\]/", substr($wilayah->kode_wilayah, 0, 2), $url);
            $url = preg_replace("/\[kode_kabkota\]/", $wilayah->kode_wilayah, $url);

            $result = $this->hitRequest($url);
            if($result){
                $this->getFromFile($url);
            }else{
                echo "ERROR REQUEST REKAP Bupati/Walikota :{$wilayah->nama} {$url}\n";
            }
        }
    }

    private function hitRequest($url){
        try {
            // Make the HTTP GET request
            $response = Http::withHeaders([
                'Referer' => 'https://pilkada2024.kpu.go.id'
            ])->retry(10, 200)->get($url);
            
            // Check if the request was successful (status code 2xx)
            if($response->ok()){
                return $this->saveToFile($url, $response->object());
            }
            return false;
        } catch (\Throwable $e) {
            // An exception occurred during the request, return the result from file
            return false;
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
