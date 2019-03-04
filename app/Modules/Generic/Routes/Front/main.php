<?php

Route::name('home')->get('/', 'Front\MainFrontController@index');
Route::name('about')->get('/about', 'Front\MainFrontController@about');
Route::name('search')->get('search', 'Front\MainFrontController@search');
Route::name('setCurrentArea')->post('set-area', 'Front\MainFrontController@setCurrentArea');
