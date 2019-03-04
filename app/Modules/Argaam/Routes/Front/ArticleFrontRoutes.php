<?php

Route::name('listFrontArticles')
    ->get('category/{category_id}/{category}', 'Front\ArticleFrontController@articles');

Route::name('listFrontArticle')
    ->get('article/{id}/{article}', 'Front\ArticleFrontController@article');