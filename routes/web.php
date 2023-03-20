<?php

use Illuminate\Support\Facades\Route;
use Unisoft\LaravelPermissionEditor\Http\Controllers\RoleController;
use Unisoft\LaravelPermissionEditor\Http\Controllers\PermissionController;

Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
