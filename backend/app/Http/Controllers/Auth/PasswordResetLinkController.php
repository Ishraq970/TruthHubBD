<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Controller handling password reset link requests.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Send a password reset link to the given user's email address.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Password reset link sent. Please check your email.',
            ]);
        }

        return response()->json([
            'message' => 'We could not find an account with that email address.',
        ], 422);
    }
}
