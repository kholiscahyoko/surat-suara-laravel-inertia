<?php

use App\Http\Controllers\SuratSuaraController;
use App\Models\User;
use App\Models\Dapils;
use App\Models\Calons;
use App\Models\Partais;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
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

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/calon', function () {
    return Inertia::render('Calon',[
        'users' => Calons::
        query()->with('dapil')
        ->when(Request::input('search'), function($query, $search){
            $query->where('nama', 'like', "%{$search}%");
        })
        ->paginate(20)
        ->withQueryString()
        ->through(fn($user) => [
            'id' => $user->id,
            'name' => $user->nama,
            'kode_dapil' => $user->kode_dapil,
            'jenis_dewan' => $user->dapil->jenis_dewan,
            'nama_dapil' => $user->dapil->nama_dapil,
        ]),
        'filters' => Request::only(['search'])
    ]);
});

// Route::get('/surat-suara/dpd/{kode_dapil}', function ($kode_dapil) {
//     return Inertia::render('SuratSuaraDpd',[
//         'calons' => Calons::where('kode_dapil', $kode_dapil)
//         ->orderBy('no_urut')
//         ->get(),
//         'dapil' => Dapils::query()
//         ->where('kode_dapil', $kode_dapil)
//         ->first()
//     ]);
// });

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
    'jenis', '(pilpres|dpd|dpr|dprdp|dprdk)',
    'nama_dapil' => '[a-z0-9-]+',
    'kode_dapil' => '[0-9]+',
]);


Route::post('/logout', function(){
   dd(request('foo')); 
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});