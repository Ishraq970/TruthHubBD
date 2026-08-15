<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller handling user profile management.
 */
class ProfileController extends Controller
{
    /**
     * Update the authenticated user's profile information.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $request->user()->update($request->validated());

        return response()->json([
            'user' => $request->user()->fresh(),
        ]);
    }
}
