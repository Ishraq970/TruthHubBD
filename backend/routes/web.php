<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

// API status page
Route::get('/', function () {
    if (request()->wantsJson()) {
        return response()->json([
            'name'         => 'TruthHubBD API Service',
            'status'       => 'online',
            'version'      => '1.0.0',
            'message'      => 'TruthHubBD Laravel REST API & Authentication Service is running.',
            'frontend_url' => config('app.frontend_url', 'http://localhost:3000'),
        ]);
    }

    return response('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TruthHubBD — API Service</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #0b1930; color: #fff; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: #112441; border: 1px solid rgba(255,255,255,0.1); padding: 40px; border-radius: 20px; max-width: 500px; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.3); }
        .badge { display: inline-block; background: #08766d; color: #2dd4bf; padding: 6px 14px; border-radius: 99px; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 16px; }
        h1 { margin: 0 0 12px; font-size: 2rem; color: #fff; }
        p { color: #94a3b8; font-size: 1rem; line-height: 1.6; margin-bottom: 24px; }
        a { display: inline-block; background: linear-gradient(135deg, #0f9f91, #4f46e5); color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 0.95rem; }
        a:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">● API Service Online</span>
        <h1>TruthHubBD Backend API</h1>
        <p>This is the Laravel REST API server handling authentication, MySQL user sessions, and profile endpoints.</p>
        <a href="http://localhost:3000" target="_blank">Open TruthHubBD Web Application &rarr;</a>
    </div>
</body>
</html>');
});

// Named login route for Laravel internal redirects
Route::get('/login', function () {
    return redirect(config('app.frontend_url', 'http://localhost:3000') . '/login');
})->name('login');

// Email verification link from inbox (Signed URL, no auth session required)
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

// Resend verification email notification
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

// Guest-only routes
Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('throttle:6,1');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:10,1');

    // Google OAuth
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

    // Password reset
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('throttle:6,1');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('throttle:6,1');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});
