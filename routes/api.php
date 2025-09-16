<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\GalleryImageController;
use App\Http\Controllers\Api\AuthController;

// === PUBLIC ROUTES ===
// Your landing page can still fetch testimonials and gallery images without logging in.
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/gallery', [GalleryImageController::class, 'index']);

// === AUTHENTICATION ROUTES ===
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// === PROTECTED ADMIN ROUTES ===
// All routes inside this group require the user to be authenticated.
Route::middleware('auth:sanctum')->group(function () {
    // This allows you to check who is logged in from the frontend
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // We use `Route::apiResource` but exclude the public 'index' method
    Route::apiResource('testimonials', TestimonialController::class)->except('index');
    Route::apiResource('gallery', GalleryImageController::class)->except('index');
});