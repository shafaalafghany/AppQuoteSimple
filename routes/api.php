<?php

//Auth
Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::get('profile', 'Api\UserController@profile')->middleware('auth:api');

//Quotes
Route::post('quotes', 'Api\QuoteController@store')->middleware('auth:api');
Route::get('quotes', 'Api\QuoteController@index')->middleware('auth:api');
Route::get('quotes/{quote}', 'Api\QuoteController@show')->middleware('auth:api');
Route::put('quotes/{quote}', 'Api\QuoteController@update')->middleware('auth:api');
Route::delete('quotes/{quote}', 'Api\QuoteController@destroy')->middleware('auth:api');

//Untuk meringkas 5 endpoint diatas bisa seperti ini
// Route::apiResource('quote', 'Api\QuoteController')->middleware('auth:api');
