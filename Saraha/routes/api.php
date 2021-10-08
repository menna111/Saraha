<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');


Route::middleware('token.auth')->group(function (){

    Route::post('/logout', 'AuthController@logout');
    Route::post('/user-profile', 'AuthController@userprofile');
    Route::get('/home','HomeController@index');
    Route::post('/send/{id}','MessageController@store');
    Route::post('/profile','ProfileController@update');
});
