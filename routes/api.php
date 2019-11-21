<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');

    Route::group(['prefix' => 'clients'], function () {
        Route::post('', 'AuthController@registerClient');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'admins'], function () {
            Route::post('', 'AuthController@registerAdmin');   
        });

        Route::group(['prefix' => 'librarians'], function () {
            Route::post('', 'AuthController@registerLibrarian');   
        });

        Route::group(['prefix' => 'books'], function() {
            Route::post('rent', 'BookController@rentBook');
        });
    });
});