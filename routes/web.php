<?php

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

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/calon', function () {
    return Inertia::render('Calon',[
        'nama' => "Nama Calon Mu",
        'time' => now()->toTimeString()
    ]);
});

Route::get('/dapil', function () {
    return Inertia::render('Dapil');
});

Route::post('/logout', function(){
   dd(request('foo')); 
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});
