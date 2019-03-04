<?php
/**
 * Created by PhpStorm.
 * User: AMiR
 * Date: 5/3/2017
 * Time: 2:40 PM
 */

Route::get('logout', 'Front\AuthFrontController@logout')->name('logout');

Route::get('register', 'Front\AuthFrontController@showRegistrationForm')->name('register');
Route::post('register', 'Front\AuthFrontController@register');
Route::post('social_register', 'Front\AuthFrontController@socialRegister')->name('socialRegister');

Route::get('login', 'Front\AuthFrontController@showLoginForm')->name('login');
Route::get('social_login', 'Front\AuthFrontController@redirectToProvider')->name('socialLogin');
Route::get('provider_callback', 'Front\AuthFrontController@handleProviderCallback');

Route::get('google_login', 'Front\AuthFrontController@redirectToGoogle')->name('loginByGoogle');
Route::get('google_callback', 'Front\AuthFrontController@handleGoogleCallback');

Route::post('login', 'Front\AuthFrontController@login');

Route::get('profile/show', 'Front\AuthFrontController@showProfile')->name('profile');
Route::get('profile/edit/{user}', 'Front\AuthFrontController@editProfile')->name('editProfile');
Route::post('profile/edit/{user}', 'Front\AuthFrontController@updateProfile');

Route::get('update_password/{user}', 'Front\AuthFrontController@showUpdatePasswordForm');
Route::patch('update_password/{user}', 'Front\AuthFrontController@updatePassword');


Route::post('password/email', 'Front\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Front\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Front\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Front\ResetPasswordController@showResetForm')->name('password.reset');


