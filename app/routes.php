<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('login', 'LoginController');
Route::resource('logout', 'LogoutController');
Route::resource('dashboard', 'DashboardController');
Route::resource('profile', 'ProfileController');
Route::resource('president', 'PresidentController');
Route::resource('user', 'UserController');
Route::resource('course', 'CourseController');

// Event::listen('laravel.query', function($sql) {
// 	var_dump($sql);
// });