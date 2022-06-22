<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login_shopify', 'InstallAppController@appLoginPreInstall');
Route::get('/generate_token', 'InstallAppController@generateToken');

// Route::group(['middleware' => ['auth']], function () { 
Route::get('/home', 'HomeController@index');

Route::get('/uninstall_app', 'InstallAppController@unInstallApp');

Route::group(['prefix'=> 'script-tag'], function(){
    Route::post('/', 'ScriptTagController@store')->name('script-tag.store');
    Route::delete('/{id}', 'ScriptTagController@destroy')->name('script-tag.destroy');

    Route::get('/url', 'ScriptTagController@scriptUrl')->name('script-tag.url');

});


Route::get('/product-variants', function(){
    // header('Access-Control-Allow-Origin: *');

    return "product variant";
});