<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

/**
 * AdminController
 * Handles approval workflow for business accounts submitted by users.
 * Accessible directly at /admin and via API endpoints /api/admin/*
 */
class AdminController extends Controller
{
    /**
     * Get all pending business creation requests.
     */
    public function pendingBusinesses(Request $request)
    {
        $pending = Business::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'slug' => $b->slug,
                    'name' => $b->name,
                    'bengaliName' => $b->bengali_name,
                    'category' => $b->category,
                    'description' => $b->description,
                    'location' => $b->location,
                    'phone' => $b->phone,
                    'website' => $b->website,
                    'facebookUrl' => $b->facebook_url,
                    'status' => $b->status,
                    'createdAt' => $b->created_at ? $b->created_at->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                    'creator' => $b->user ? [
                        'id' => $b->user->id,
                        'name' => $b->user->name,
                        'email' => $b->user->email,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'count' => $pending->count(),
            'data' => $pending,
        ]);
    }

    /**
     * Approve a pending business creation request.
     */
    public function approve(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Business account approved successfully.',
            'data' => $business,
        ]);
    }

    /**
     * Reject a pending business creation request.
     */
    public function reject(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Business account request rejected.',
            'data' => $business,
        ]);
    }
}
