<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;

class SitemapController
{

    use AuthorizesRequests, ValidatesRequests;

    public function pilkada_surat_suara()
    {

        $sitemap = Storage::disk('public')->get('sitemap/pilkada_surat_suara.xml');

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);

    }

    public function pilkada_pasangan_calon()
    {
        $sitemap = Storage::disk('public')->get('sitemap/pilkada_pasangan_calon.xml');

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);

    }

    public function pilkada_profil_calon()
    {
        $sitemap = Storage::disk('public')->get('sitemap/pilkada_profil_calon.xml');

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);

    }
}