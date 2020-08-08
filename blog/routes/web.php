<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',function()
{
 return view('admin.login');
});

Route::get('/home',function()
{
 return view('home');
})->name('home');

Route::get('/login',function()
{
 return view('admin.login');
})->name('login');

//Auth::routes();
Route::get('/recuperarSenha', function() {
    return view('admin.recuperarSenha');
});
Route::post('/recuperarSenha', 'MainController@recuperarSenha');
Route::get('/recuperarSenha/novaSenha/{token}', 'MainController@novaSenha');
Route::post('/recuperarSenha/novaSenha/{token}', 'MainController@validarSenha');

Route::post('checklogin', 'MainController@checklogin');
Route::post('logout', 'MainController@logout');


Route::get('/home', 'HomeController@index')->name('home');
