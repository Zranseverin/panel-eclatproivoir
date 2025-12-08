<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'title',
        'employment_type',
        'description',
        'mission',
        'responsibilities',
        'profile_requirements',
        'benefits',
        'image_url',
        'badge_text',
        'badge_class',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}