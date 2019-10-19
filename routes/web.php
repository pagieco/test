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

Route::get('/app/page-designer/{page}', 'App\PageDesignerController');
Route::get('/app/{resource?}', 'AppController')->where('resource', '(.*)');

// Catch-all resource routing.
Route::get('{any?}', 'FrontendController')->where('any', '(.*)');
