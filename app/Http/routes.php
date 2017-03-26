<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [ 'as' => 'orders', 'uses' => 'OrderController@index'] );

Route::get('/orders', [ 'as' => 'orders', 'uses' => 'OrderController@index'] );
Route::post('/orders', [ 'as' => 'orders', 'uses' => 'OrderController@store'] );


Route::get('/orders/edit/{id}', [ 'as' => 'edit', 'uses' => 'OrderController@edit'] );
Route::post('/orders/edit/{id}', [ 'as' => 'edit', 'uses' => 'OrderController@update'] );

Route::get('/orders/delete/{id}', [ 'as' => 'delete', 'uses' => 'OrderController@delete'] );