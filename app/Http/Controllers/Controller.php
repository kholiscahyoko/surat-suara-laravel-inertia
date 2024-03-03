<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Meta;
use App\Helpers\CacheHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public object $meta;
    public object $cache;

    public function __construct() {
        $this->meta = new Meta();
        $this->cache = new CacheHelper();
        view()->share('meta', $this->meta);
    }

    public function setMeta(array $data = []){

    }

}
