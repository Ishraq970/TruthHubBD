<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Business Model
 * Represents a business entity in the database (Hospital, Doctor, Tech Retailer, University, Courier, etc.)
 */
class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'bengali_name',
        'category',
        'description',
        'location',
        'rating',
        'review_count',
        'verified',
        'phone',
        'website',
        'facebook_url',
        'color',
        'image',
        'branches',
        'user_id',
        'status',
    ];

    protected $casts = [
        'branches' => 'array',
        'verified' => 'boolean',
        'rating' => 'float',
        'review_count' => 'integer',
    ];

    /**
     * Relationship: A business belongs to a user owner.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A business has many reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}
