<?php

use Illuminate\Support\Facades\Route;
use App\Domains\User\Http\Controllers\Backoffice\ShowUserController;
use App\Domains\User\Http\Controllers\Backoffice\ListUsersController;

Route::get('/users', ListUsersController::class)->name('backoffice.list-users');
Route::get('/users/{user}', ShowUserController::class)->name('backoffice.show-user');
