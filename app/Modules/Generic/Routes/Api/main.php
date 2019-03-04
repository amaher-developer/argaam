<?php

Route::any('home', 'Api\MainApiController@main')->middleware('api');
Route::any('splash', 'Api\GenericApiController@splash')->middleware('api');
Route::any('log_errors', 'Api\GenericApiController@logErrors')->middleware('api');
Route::any('update_push_token', 'Api\GenericApiController@updatePushToken')->middleware('api');


Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/settings', function () {
        return \App\Modules\Generic\Models\Setting::all();
    });

});