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

// Route::get('/calon', function () {
//     return Inertia::render('Calon',[
//         'users' => User::query()
//         ->when(Request::input('search'), function($query, $search){
//             $query->where('name', 'like', "%{$search}%");
//         })
//         ->paginate(10)
//         ->withQueryString()
//         ->through(fn($user) => [
//             'id' => $user->id,
//             'name' => $user->name
//         ]),
//         'filters' => Request::only(['search'])
//     ]);
// });

Route::get('/calon', function () {
    return Inertia::render('Calon',[
        'users' => Calons::query()
        ->when(Request::input('search'), function($query, $search){
            $query->where('nama', 'like', "%{$search}%");
        })
        ->paginate(20)
        ->withQueryString()
        ->through(fn($user) => [
            'id' => $user->id,
            'name' => $user->nama
        ]),
        'filters' => Request::only(['search'])
    ]);
});

Route::get('/surat-suara/dpd/{kode_dapil}', function ($kode_dapil) {
    return Inertia::render('SuratSuaraDpd',[
        'calons' => Calons::where('kode_dapil', $kode_dapil)
        ->orderBy('no_urut')
        ->get(),
        'dapil' => Dapils::query()
        ->where('kode_dapil', $kode_dapil)
        ->first()
    ]);
});

Route::get('/surat-suara/dpr/{kode_dapil}', function ($kode_dapil) {
    return Inertia::render('SuratSuaraDpr',  (new SuratSuaraController)->dewan($kode_dapil));
});

Route::get('/surat-suara/dprdp/{kode_dapil}', function ($kode_dapil) {
    return Inertia::render('SuratSuaraDprdp',  (new SuratSuaraController)->dewan($kode_dapil));
});

Route::get('/surat-suara/dprdk/{kode_dapil}', function ($kode_dapil) {
    return Inertia::render('SuratSuaraDprdk',  (new SuratSuaraController)->dewan($kode_dapil));
});

Route::get('/dapil', [SuratSuaraController::class, 'dapil']);

Route::get('/wilayah', [SuratSuaraController::class, 'wilayah']);

Route::get('/surat-suara/pilpres', function(){
    return Inertia::render('SuratSuaraPilpres');
});

Route::get('/surat-suara/{tingkatan_wilayah}/{kode_wilayah}', function ($tingkatan_wilayah, $kode_wilayah) {
    return Inertia::render('SuratSuaraSampul',  (new SuratSuaraController)->wilayah_dapil($tingkatan_wilayah, $kode_wilayah, true));
}
);

Route::get('/surat-suara/{tingkatan_wilayah}/{kode_wilayah}/buka', function ($tingkatan_wilayah, $kode_wilayah) {
    return Inertia::render('SuratSuaraBuka',  (new SuratSuaraController)->wilayah_dapil($tingkatan_wilayah, $kode_wilayah));
}
);

Route::post('/logout', function(){
   dd(request('foo')); 
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});