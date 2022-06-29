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

Route::get('/', function () {
    return view('welcome');
});




Route::get('/login_shopify', 'InstallAppController@appLoginPreInstall');
Route::get('/generate_token', 'InstallAppController@generateToken');

// Route::group(['middleware' => ['auth']], function () { 
Route::get('/home', 'AppHomeController@index');

Route::get('/uninstall_app', 'InstallAppController@unInstallApp');

Route::group(['prefix'=> 'script-tag'], function(){
    Route::post('/', 'ScriptTagController@store')->name('script-tag.store');
    Route::delete('/{id}', 'ScriptTagController@destroy')->name('script-tag.destroy');

    Route::get('/url', 'ScriptTagController@scriptUrl')->name('script-tag.url');

});

Route::group(['prefix'=> 'app-config'], function(){
    Route::post('/activity/{id}', 'AppConfigController@toggleActivity')->name('app-config.activity');

});


Route::get('/product-variants', 'ProductVariantController@index')->name('product-variants.index');

Route::get('/test', function(){
    echo "test";
})->name('test');
