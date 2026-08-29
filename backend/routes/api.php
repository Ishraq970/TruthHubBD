<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Public and Protected API routes for TruthHubBD backend
*/

// Public business discovery & review API endpoints
Route::get('/businesses', [BusinessController::class, 'index']);
Route::get('/businesses/{slug}', [BusinessController::class, 'show']);
Route::get('/reviews/recent', [BusinessController::class, 'recentReviews']);
Route::post('/businesses', [BusinessController::class, 'store']); // Business creation (Pending admin approval)

// Admin approval workflow endpoints (/admin)
Route::get('/admin/pending-businesses', [AdminController::class, 'pendingBusinesses']);
Route::post('/admin/businesses/{id}/approve', [AdminController::class, 'approve']);
Route::post('/admin/businesses/{id}/reject', [AdminController::class, 'reject']);

// Protected routes requiring Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => response()->json(['user' => $request->user()]));
    Route::patch('/profile', [ProfileController::class, 'update']);

    // Business owner profile editing & reviews
    Route::patch('/businesses/{id}', [BusinessController::class, 'update']);
    Route::post('/businesses/{id}/reviews', [BusinessController::class, 'storeReview']);
});
