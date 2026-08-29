<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Review Model
 * Stores community reviews for a business entity.
 * Supports Issue #3 (optional location), Issue #4 (optional facebook_url), and Issue #5 (optional image_path).
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'author',
        'initials',
        'rating',
        'title',
        'body',
        'date',
        'disclaimer',
        'verified_experience',
        'location',      // Issue #3: Optional location
        'facebook_url',  // Issue #4: Optional Facebook page URL
        'image_path',    // Issue #5: Uploaded receipt/photo file path
        'helpful_count',
        'discussion_count',
        'service_rating',
        'value_rating',
        'comm_rating',
    ];

    protected $casts = [
        'verified_experience' => 'boolean',
        'rating' => 'integer',
        'helpful_count' => 'integer',
        'discussion_count' => 'integer',
    ];

    /**
     * Relationship: A review belongs to a business entity.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

