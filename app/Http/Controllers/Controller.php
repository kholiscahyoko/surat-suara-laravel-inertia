<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Meta;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public object $meta;

    public function __construct() {
        $this->meta = new Meta();
        view()->share('meta', $this->meta);
    }

    public function setMeta(array $data = []){

    }

}
