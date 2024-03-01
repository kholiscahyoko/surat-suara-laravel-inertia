<?php

use App\Http\Controllers\SuratSuaraController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SuratSuaraController::class, 'index']);

Route::get('/calon', [SuratSuaraController::class, 'calon']);

Route::get('/dapil', [SuratSuaraController::class, 'dapil']);

Route::get('/wilayah', [SuratSuaraController::class, 'wilayah']);

Route::get('/surat-suara/{tingkatan_wilayah}/{nama_wilayah}/{kode_wilayah}', [SuratSuaraController::class, 'wilayah_dapil'])
->where([
    'tingkatan_wilayah' => '(desa|kecamatan|kabkota|provinsi)',
    'nama_wilayah' => '[a-z0-9-]+',
    'kode_wilayah' => '[0-9]+',
]);

Route::get('/hitung-suara/{tingkatan_wilayah}/{nama_wilayah}/{kode_wilayah}', [SuratSuaraController::class, 'wilayah_dapil'])
->where([
    'tingkatan_wilayah' => '(desa|kecamatan|kabkota|provinsi)',
    'nama_wilayah' => '[a-z0-9-]+',
    'kode_wilayah' => '[0-9]+',
]);

Route::get('/surat-suara/{jenis}/{nama_dapil?}/{kode_dapil?}/{nama_calon?}/{calon_id?}', [SuratSuaraController::class, 'jenis'])
->where([
    'jenis', '(pilpres|dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+',
    'calon_id' => '[0-9]+',
]);

Route::get('/hitung-suara/{jenis}/{nama_dapil?}/{kode_dapil?}/{nama_calon?}/{calon_id?}', [SuratSuaraController::class, 'real_count'])
->where([
    'jenis', '(pilpres|dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+',
    'calon_id' => '[0-9]+',
]);

Route::get('/profil-calon/{jenis}/{nama_dapil}/{kode_dapil}/{nama_calon}/{calon_id}', [SuratSuaraController::class, 'profil'])
->where([
    'jenis', '(dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+',
    'calon_id' => '[0-9]+',
]);

Route::get('/calon-terpilih/{jenis}/{nama_dapil}/{kode_dapil}', [SuratSuaraController::class, 'calon_lolos'])
->where([
    'jenis', '(dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
]);

Route::get('/cek-profil/{jenis}/{nama_dapil}/{kode_dapil}/{nama_calon}', [SuratSuaraController::class, 'cari_profil'])
->where([
    'jenis', '(dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+'
]);

Route::post('/logout', function(){
   dd(request('foo')); 
});

Route::get('/tentang-kami', function(){
   return Inertia::render('TentangKami'); 
});

Route::get('/kebijakan-privasi', function(){
   return Inertia::render('KebijakanPrivasi'); 
});

Route::get('/hubungi-kami', function(){
   return Inertia::render('HubungiKami'); 
});

Route::get('/get_list_wilayah_by_dapil', [SuratSuaraController::class, 'get_list_wilayah_by_dapil']);