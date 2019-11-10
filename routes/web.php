<?php

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

Route::get('/server', 'ServerController@show')->name('server.show');
Route::get('/server/create', 'ServerController@create')->name('server.create');
Route::post('/server/create', 'ServerController@createServer')->name('server.create.post');
Route::get('/server/delete/{id}', 'ServerController@delete')->name('server.delete');
Route::get('/server/deleted/{id}', 'ServerController@deleted')->name('server.deleted');
Route::get('/server/vnc/{id}', 'ServerController@vnc')->name('server.vnc');
Route::get('/port', 'MikrotikController@show')->name('port.show');
Route::get('/port/delete/{id}', 'MikrotikController@delete')->name('port.delete');
Route::get('/port/create', 'MikrotikController@create')->name('port.create');
Route::post('/port/create', 'MikrotikController@createPort')->name('port.create.post');
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/synchronize', 'AdminController@synchronize')->name('admin.synchronize');