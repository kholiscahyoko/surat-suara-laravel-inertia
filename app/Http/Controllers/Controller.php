<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Meta;
use App\Helpers\CacheHelper;
use App\Helpers\HttpHelper;
use App\Helpers\SirekapHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public object $meta;
    public object $cache;
    public object $sirekap;

    public function __construct() {
        $this->meta = new Meta();
        $this->cache = new CacheHelper();
        $this->sirekap = new SirekapHelper();
        view()->share('meta', $this->meta);
    }

    public function setMeta(array $data = []){

    }

}
