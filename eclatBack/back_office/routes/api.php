<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConfigLogoApiController;
use App\Http\Controllers\Api\HeaderContactApiController;
use App\Http\Controllers\Api\NavbarApiController;
use App\Http\Controllers\Api\NavbarBrandApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public API routes - Get configuration
Route::prefix('v1')->group(function () {
    // Site Configuration Routes - Public access
    Route::get('/config', [ConfigLogoApiController::class, 'getActive']);
    Route::get('/configs', [ConfigLogoApiController::class, 'index']);
    Route::get('/configs/{id}', [ConfigLogoApiController::class, 'show']);
    
    // Header Contact Routes - Public access
    Route::get('/header-contact', [HeaderContactApiController::class, 'getActive']);
    Route::get('/header-contacts', [HeaderContactApiController::class, 'index']);
    Route::get('/header-contacts/{id}', [HeaderContactApiController::class, 'show']);
    
    // Navbar Routes - Public access
    Route::get('/navbar', [NavbarApiController::class, 'getActive']);
    Route::get('/navbars', [NavbarApiController::class, 'index']);
    Route::get('/navbars/{id}', [NavbarApiController::class, 'show']);
    
    // Navbar Brand Routes - Public access
    Route::get('/navbar-brand', [NavbarBrandApiController::class, 'getActive']);
    Route::get('/navbar-brands', [NavbarBrandApiController::class, 'index']);
    Route::get('/navbar-brands/{id}', [NavbarBrandApiController::class, 'show']);
});

// Protected API routes - Admin only
Route::middleware(['auth:admin'])->prefix('v1')->group(function () {
    Route::post('/configs', [ConfigLogoApiController::class, 'store']);
    Route::put('/configs/{id}', [ConfigLogoApiController::class, 'update']);
    Route::patch('/configs/{id}', [ConfigLogoApiController::class, 'update']);
    Route::delete('/configs/{id}', [ConfigLogoApiController::class, 'destroy']);
    
    // Header Contact Routes - Admin only
    Route::post('/header-contacts', [HeaderContactApiController::class, 'store']);
    Route::put('/header-contacts/{id}', [HeaderContactApiController::class, 'update']);
    Route::patch('/header-contacts/{id}', [HeaderContactApiController::class, 'update']);
    Route::delete('/header-contacts/{id}', [HeaderContactApiController::class, 'destroy']);
    
    // Navbar Routes - Admin only
    Route::post('/navbars', [NavbarApiController::class, 'store']);
    Route::put('/navbars/{id}', [NavbarApiController::class, 'update']);
    Route::patch('/navbars/{id}', [NavbarApiController::class, 'update']);
    Route::delete('/navbars/{id}', [NavbarApiController::class, 'destroy']);
    
    // Navbar Brand Routes - Admin only
    Route::post('/navbar-brands', [NavbarBrandApiController::class, 'store']);
    Route::put('/navbar-brands/{id}', [NavbarBrandApiController::class, 'update']);
    Route::patch('/navbar-brands/{id}', [NavbarBrandApiController::class, 'update']);
    Route::delete('/navbar-brands/{id}', [NavbarBrandApiController::class, 'destroy']);
});
