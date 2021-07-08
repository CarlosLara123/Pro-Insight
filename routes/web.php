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
    if(isset(auth()->user()->user)){
        return redirect('home');
    }else{
        return view('auth.login');
    }
});

Auth::routes();

//HOME
Route::get('/home', 'HomeController@index')->name('home');

//PROVIDER'S
Route::get('/providers', 'ProviderController@index')->name('providers.index');
Route::get('/providers/all', 'ProviderController@get_providers')->name('providers.get_providers');
Route::post('/provider/add', 'ProviderController@store')->name('provider.store');

//PRODUCT'S
Route::get('/products', 'ProductController@index')->name('products.index');
Route::post('/product/add', 'ProductController@store')->name('product.store');