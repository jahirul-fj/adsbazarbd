<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'icon',
        'sample_text',
        'requires_document',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'requires_document' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function classifiedAds(): HasMany
    {
        return $this->hasMany(ClassifiedAd::class);
    }

    public function displayAds(): HasMany
    {
        return $this->hasMany(DisplayAd::class);
    }
}
