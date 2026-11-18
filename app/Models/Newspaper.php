<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Newspaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'language',
        'logo',
        'classified_rate_per_word',
        'display_rate_col_inch',
        'front_page_multiplier',
        'back_page_multiplier',
        'inner_page_multiplier',
        'color_charge_percent',
        'min_words',
        'contact_email',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'classified_rate_per_word' => 'decimal:2',
            'display_rate_col_inch' => 'decimal:2',
            'front_page_multiplier' => 'decimal:2',
            'back_page_multiplier' => 'decimal:2',
            'inner_page_multiplier' => 'decimal:2',
            'color_charge_percent' => 'integer',
            'min_words' => 'integer',
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
