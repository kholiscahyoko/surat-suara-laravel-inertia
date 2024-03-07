<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SirekapHelper {
    private bool $ok;
    private object $object;

    public function __construct() {
        $this->ok = false;
    }

    public function getData($url){
        try {
            // Make the HTTP GET request
            $response = Http::withHeaders([
                'Referer' => 'https://pemilu2024.kpu.go.id'
            ])->get($url);
        
            // Check if the request was successful (status code 2xx)
            if ($response->ok()) {
                $this->ok = true;
                return $response;
            } else {
                // Request failed (non-2xx status code), return the result from file
                $this->object = $this->getFromFile($url);
                if($this->object){
                    $this->ok = true;
                }else{
                    $this->ok = false;
                }
                return $this;
            }
        } catch (\Throwable $e) {
            // An exception occurred during the request, return the result from file
            $this->object = $this->getFromFile($url);
            if($this->object){
                $this->ok = true;
            }else{
                $this->ok = false;
            }
            return $this;
    }
        // Use or return $responseData as needed
    }

    public function ok(){
        return $this->ok;
    }

    public function object(){
        return $this->object;
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
}