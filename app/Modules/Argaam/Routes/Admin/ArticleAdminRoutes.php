<?php

Route::prefix('operate/article')
    ->middleware(['auth'])
    ->group(function () {
    Route::name('listArticle')
        ->get('/', 'Admin\ArticleAdminController@index')
        ->middleware(['permission:super|article-index']);
    Route::name('createArticle')
        ->get('create', 'Admin\ArticleAdminController@create')
        ->middleware(['permission:super|article-create']);
    Route::name('storeArticle')
        ->post('create', 'Admin\ArticleAdminController@store')
        ->middleware(['permission:super|article-create']);
    Route::name('editArticle')
        ->get('{article}/edit', 'Admin\ArticleAdminController@edit')
        ->middleware(['permission:super|article-edit']);
    Route::name('editArticle')
        ->post('{article}/edit', 'Admin\ArticleAdminController@update')
        ->middleware(['permission:super|article-edit']);
    Route::name('deleteArticle')
        ->get('{article}/delete', 'Admin\ArticleAdminController@destroy')
        ->middleware(['permission:super|article-destroy']);

    Route::name('arrangeArticle')
        ->post('/arrangeArticle', 'Admin\ArticleAdminController@arrange')
        ->middleware(['permission:super|article-index']);

    Route::name('deleteArticleImage')
        ->get('articleImage/{id}/delete', 'Admin\ArticleAdminController@deleteArticleImage')
        ->middleware(['permission:super|article-destroy']);
});
