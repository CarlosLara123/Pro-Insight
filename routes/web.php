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
    if(isset(auth()->user()->id)){
        return redirect('home');
    }else{
        return view('auth.login');
    }
});

Auth::routes();

//HOME
Route::get('/home', 'HomeController@index')->name('home');

//PROVIDERS
Route::get('/providers', 'ProviderController@index')->name('providers.index');
Route::get('/providers/all', 'ProviderController@get_providers')->name('providers.get_providers');
Route::post('/provider/add', 'ProviderController@store')->name('provider.store');

//PRODUCTS
Route::get('/products', 'ProductController@index')->name('products.index');
Route::get('/products/all', 'ProductController@getProducts')->name('product.getProducts');
Route::post('/product', 'ProductController@getProduct')->name('product.getProduct');
Route::post('/product/add', 'ProductController@store')->name('product.store');
Route::post('/product/update', 'ProductController@update')->name('product.update');

//PRODUCT PROVIDERS
Route::get('/product/providers', 'ProductProvidersController@index')->name('products.provider.index');
Route::post('/product/provider', 'ProductProvidersController@getProduct')->name('product.provider.getProduct');
Route::post('/product/providers/add', 'ProductProvidersController@store')->name('product.provider.store');
Route::post('/product/providers/price', 'ProductProvidersController@updatePrice')->name('product.provider.price');

//CONTAINERS
Route::get('/containers', 'ContainerController@index')->name('containers.index');
Route::post('/container/add', 'ContainerController@store')->name('container.store');
Route::post('/container/products/add', 'ContainerController@storeProducts')->name('container.products.store');

//CONTAINER PRODUCTS
Route::get('/container/products', 'ContainerController@indexContainerProdutcs')->name('container.products.index');

//AIRPORTS
Route::get('/airports', 'AirportController@index')->name('airport.index');
Route::post('/airport/add', 'AirportController@store')->name('airport.store');

//ORDERS
Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::post('/order/add', 'OrderController@store')->name('order.store');