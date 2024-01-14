<?php

use App\Models\User;
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
        'users' => User::query()
        ->when(Request::input('search'), function($query, $search){
            $query->where('name', 'like', "%{$search}%");
        })
        ->paginate(10)
        ->withQueryString()
        ->through(fn($user) => [
            'id' => $user->id,
            'name' => $user->name
        ]),
        'filters' => Request::only(['search'])
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