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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\FrontendController;
use App\Domains\Auth\Http\Controllers\LoginController;
use App\Domains\Page\Http\Controllers\App\PageEditorController;
use App\Domains\Workflow\Http\Controllers\App\WorkflowEditorController;
use App\Domains\Collection\Http\Controllers\App\CollectionEditorController;

// Authentication Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/app/collection-editor', CollectionEditorController::class);
Route::get('/app/page-editor/{page}', PageEditorController::class);
Route::get('/app/workflow-editor/{workflow}', WorkflowEditorController::class);
Route::get('/app/{resource?}', AppController::class)->where('resource', '(.*)');

// Catch-all resource routing.
Route::get('{any?}', FrontendController::class)->where('any', '(.*)');
