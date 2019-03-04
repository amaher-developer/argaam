<?php

Route::prefix('operate/setting')
    ->middleware(['auth'])
    ->group(function () {
    Route::name('editSetting')
        ->get('{setting}/edit', 'Admin\SettingAdminController@edit')
        ->middleware(['permission:super|setting-edit']);
    Route::name('editSetting')
        ->post('{setting}/edit', 'Admin\SettingAdminController@update')
        ->middleware(['permission:super|setting-edit']);

    Route::name('staticVariables')
        ->get('static-variables', 'Admin\SettingAdminController@staticVariableUpdate')
        ->middleware(['permission:super|static-variables']);

    Route::name('staticVariables')
        ->post('static-variables', 'Admin\SettingAdminController@staticVariableStore')
        ->middleware(['permission:super|static-variables']);

    Route::get('test', 'Admin\GenericAdminController@test')
        ->middleware(['permission:super']);

});
