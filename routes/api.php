// routes/api.php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\GalleryImageController;

Route::apiResource('testimonials', TestimonialController::class);
Route::apiResource('gallery', GalleryImageController::class);