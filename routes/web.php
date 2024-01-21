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
    'nama_wilayah' => '[a-z-]+',
    'kode_wilayah' => '[0-9]+',
]);

Route::get('/surat-suara/{jenis}/{nama_dapil?}/{kode_dapil?}', [SuratSuaraController::class, 'jenis'])
->where([
    'jenis', '(pilpres|dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
]);


Route::post('/logout', function(){
   dd(request('foo')); 
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});