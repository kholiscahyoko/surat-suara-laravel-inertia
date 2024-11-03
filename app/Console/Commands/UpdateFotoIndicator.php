<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Helpers\ImageAssetHelper;

class UpdateFotoIndicator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indicator:foto:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'REFRESH FOTO INDICATOR';

    private object $image;

    public function __construct()
    {
        parent::__construct();

        $this->image = new ImageAssetHelper();
    }
    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->image = new ImageAssetHelper();

        echo "=============BEGIN=============\n";
        foreach ($this->image->hosts as $host => $url) {
            if(!empty($url)){
                $key = "{$this->image->prefix_cache}:{$host}";
                echo "=============UPDATE KEY : {$key}=============\n";
                echo "URL: {$url}\n";
                $status = $this->hitRequest($url);
                echo "STATUS: {$status}\n";
                $this->image->setCache($key, !$status);
            }
        }
        echo "=============FINISHED=============\n";
    }

    private function hitRequest($url){
        $response = Http::retry(10, 200)->get($url);
        return $response->ok();
    }
}
