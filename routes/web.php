<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// Маршруты аутентификации...
Route::get('auth/login', 'Auth\LoginController@showLoginForm');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout');

// Маршруты регистрации...
Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('auth/register', 'Auth\RegisterController@register');
//Companies
Route::get('/companies', 'CompaniesController@index');
Route::get('/companies/{id}', 'CompaniesController@show');
//Straws
Route::get('/straws', 'StrawsController@index');
Route::get('/straws/company/{id}', 'StrawsController@companyStraws');
Route::get('/straws/{id}', 'StrawsController@show');
//Sensors
Route::get('/sensors', 'SensorsController@index');
Route::get('/sensors/straw/{id}', 'SensorsController@getSensorsData');
Route::get('/sensors/{id}', 'SensorsController@show');
//Measurements
Route::get('/measurements', 'MeasurementsController@index');
Route::get('/measurements/{id}', 'MeasurementsController@show');

