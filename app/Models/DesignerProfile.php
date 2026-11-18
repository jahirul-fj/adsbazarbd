<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tagline',
        'about',
        'experience_years',
        'starting_rate',
        'skills',
        'portfolio',
        'completed_orders',
        'rating',
        'total_reviews',
        'is_featured',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'starting_rate' => 'decimal:2',
            'completed_orders' => 'integer',
            'rating' => 'decimal:2',
            'total_reviews' => 'integer',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'portfolio' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
