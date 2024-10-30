<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Meta;
use App\Helpers\GoogleEnhancement;
use App\Helpers\CacheHelper;
use App\Helpers\HttpHelper;
use App\Helpers\ImageAssetHelper;
use App\Helpers\SirekapHelper;
use App\Helpers\PilkadaHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public object $meta;
    public object $genhancement;
    public object $cache;
    public object $sirekap;
    public object $pilkada;
    public object $image;

    public function __construct() {
        $this->meta = new Meta();
        $this->genhancement = new GoogleEnhancement();
        $this->cache = new CacheHelper();
        $this->sirekap = new SirekapHelper();
        $this->pilkada = new PilkadaHelper();
        $this->image = new ImageAssetHelper();
        view()->share('meta', $this->meta);
        view()->share('genhancement', $this->genhancement);
    }

    public function setMeta(array $data = []){

    }

}
