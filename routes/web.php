<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login_shopify', 'InstallAppController@appLoginPreInstall');
Route::get('/generate_token', 'InstallAppController@generateToken');

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/home', function () {
        return view('home');
    });
    
    Route::get('/uninstall_app', 'InstallAppController@unInstallApp');

});


