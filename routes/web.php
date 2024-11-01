<?php

use App\Http\Controllers\SuratSuaraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PilkadaController;
use App\Http\Controllers\IndexController;

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

Route::get('/', [PilkadaController::class, 'index']);
Route::get('/cari', [IndexController::class, 'cari']);
Route::get('/tentang-kami',[IndexController::class, 'tentang_kami']);
Route::get('/kebijakan-privasi',[IndexController::class, 'privasi']);
Route::get('/hubungi-kami',[IndexController::class, 'hubungi_kami']);


// PEMILU
Route::get('/pemilu', [SuratSuaraController::class, 'index']);

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

// Route::get('/anggota-baru/{jenis}/{nama_wilayah?}/{kode_wilayah?}', [SuratSuaraController::class, 'anggota_lengkap'])
// ->where([
//     'jenis', '(dpd|dpr|dprd-provinsi|dprd-kabkota)',
//     'nama_wilayah' => '[a-z0-9-]+',
//     'kode_wilayah' => '[0-9]+',
// ]);

Route::get('/cek-profil/{jenis}/{nama_dapil}/{kode_dapil}/{nama_calon}', [SuratSuaraController::class, 'cari_profil'])
->where([
    'jenis', '(dpd|dpr|dprd-provinsi|dprd-kabkota)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+'
]);

Route::get('/get_list_wilayah_by_dapil', [SuratSuaraController::class, 'get_list_wilayah_by_dapil']);


// PILKADA
Route::get('/pilkada', [PilkadaController::class, 'index']);
Route::get('/pilkada/wilayah', [PilkadaController::class, 'wilayah']);
Route::get('/pilkada/profil-calon/{jenis}/{nama_dapil}/{kode_dapil}/{nama_calon}/{calon_id}', [PilkadaController::class, 'profil'])
->where([
    'jenis', '(gubernur|wakil-gubernur|walikota|calon-walikota|bupati|wakil-bupati)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+',
    'calon_id' => '[0-9]+',
]);
Route::get('/pilkada/pasangan-calon/{jenis}/{nama_dapil}/{kode_dapil}/{nama_calon}/{paslon_id}', [PilkadaController::class, 'paslon'])
->where([
    'jenis', '(gubernur-dan-wakil-gubernur|walikota-dan-wakil-walikota|bupati-dan-wakil-bupati)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
    'nama_calon' => '[a-z0-9-]+',
    'paslon_id' => '[0-9]+',
]);
Route::get('/pilkada/surat-suara/{jenis}/{nama_dapil}/{kode_dapil}', [PilkadaController::class, 'surat_suara'])
->where([
    'jenis', '(gubernur-dan-wakil-gubernur|walikota-dan-wakil-walikota|bupati-dan-wakil-bupati)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+'
]);
