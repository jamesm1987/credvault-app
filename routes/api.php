<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::apiResource('clients', ClientController::class);
    // Route::apiResource('clients.credentials', CredentialController::class);

    // Route::post('credentials/{credential}/reveal', [CredentialController::class, 'reveal']);

    // Route::apiResource('categories', CategoryController::class)->only('index', 'show');
    // Route::apiResource('environments', EnvironmentController::class)->only('index');
})->middleware('auth:sanctum');