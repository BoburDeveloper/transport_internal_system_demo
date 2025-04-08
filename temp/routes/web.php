<?php

use Illuminate\Support\Facades\Route;

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
$prefix = '{locale}';

Route::group([
    'prefix' => $prefix,
    'where' => ['locale' => '[uz|oz]{2}'],
    'middleware' => \App\Http\Middleware\LocaleMiddleware::class,
], function() {
    Route::get('/', ['uses'=>'App\Http\Controllers\Site@index']);
    Route::get('/cabinet/form/{type}/{id}', ['uses'=>'App\Http\Controllers\Cabinet@form'])->where('id', '[0-9]+');
    Route::post('/cabinet/form/{type}/{id}', ['uses'=>'App\Http\Controllers\Cabinet@form_save'])->where('id', '[0-9]+');
    Route::get('/cabinet/list/{type}', ['uses'=>'App\Http\Controllers\Cabinet@list']);
    Route::get('/cabinet/detail/{type}/{id}', ['uses'=>'App\Http\Controllers\Cabinet@detail'])->where('id', '[0-9]+');
    Route::get('/site/{type}/{id}', ['uses'=>'App\Http\Controllers\Site@document']);
    Route::get('/site/qrcode', ['uses'=>'App\Http\Controllers\Site@qrcode']);
    Route::get('/site/logout', ['uses'=>'App\Http\Controllers\Site@logout']);
    Route::get('/site/login', ['uses'=>'App\Http\Controllers\Site@login']);
    Route::post('/site/login', ['uses'=>'App\Http\Controllers\Site@login']);
    Route::any('/ajax/refreshcaptcha', ['uses'=>'App\Http\Controllers\Ajax@refreshCaptcha']);


    Route::get('refresh-csrf', function(){
        return csrf_token();
    });
});

Route::any('/', ['uses'=>'App\Http\Controllers\Site@index']);

Route::get('/site/info/{type}/{id}', ['uses'=>'App\Http\Controllers\Site@document']);

