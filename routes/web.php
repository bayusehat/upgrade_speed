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

// Route::group(['middleware' => ['web']], function () {
    Route::get('/','FormController@index');
    Route::post('/register','FormController@register');
    Route::post('/getnumber','FormController@getNumber');
// });
Route::get('/login','LoginController@login');
Route::post('/dologin','LoginController@doLogin');
Route::get('/dologout','LoginController@doLogout');

Route::get('showuser','FormController@showuser');

Route::group(['middleware' => ['authlogin','web']],function(){
    Route::get('/obc','ObcController@index');
    Route::get('/obc/load','ObcController@loadData');
    Route::get('/obc/edit/{id}','ObcController@edit');
    Route::post('/obc/update/{id}','ObcController@update');

    Route::get('/oplang','OplangController@index');
    Route::get('/oplang/load','OplangController@loadData');
    Route::get('/oplang/edit/{id}','OplangController@edit');
    Route::post('/oplang/update/{id}','OplangController@update');
});

