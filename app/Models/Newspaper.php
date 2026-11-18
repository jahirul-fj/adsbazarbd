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
        'display_rates',
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
            'display_rates' => 'array',
            'front_page_multiplier' => 'decimal:2',
            'back_page_multiplier' => 'decimal:2',
            'inner_page_multiplier' => 'decimal:2',
            'color_charge_percent' => 'integer',
            'min_words' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getDisplayRate(string $position, string $color = 'color'): float
    {
        $posKey = match ($position) {
            'fp', 'front_page' => 'fp',
            'bp', 'back_page' => 'bp',
            'before_bp', 'before_back_page' => 'before_bp',
            'page_2', 'p2' => 'page_2',
            'page_3', 'p3' => 'page_3',
            'page_5', 'p5' => 'page_5',
            'sports', 'sports_page' => 'sports',
            default => 'inner',
        };

        $colorKey = ($color === 'black_white' || $color === 'bw') ? 'bw' : 'color';
        $fullKey = "{$posKey}_{$colorKey}";

        if (!empty($this->display_rates) && isset($this->display_rates[$fullKey]) && is_numeric($this->display_rates[$fullKey]) && $this->display_rates[$fullKey] > 0) {
            return (float) $this->display_rates[$fullKey];
        }

        if (!empty($this->display_rates)) {
            if ($colorKey === 'bw' && isset($this->display_rates["{$posKey}_color"])) {
                return round((float)$this->display_rates["{$posKey}_color"] * 0.75, 2);
            }
            if ($colorKey === 'color' && isset($this->display_rates["{$posKey}_bw"])) {
                return round((float)$this->display_rates["{$posKey}_bw"] * 1.35, 2);
            }
            if (isset($this->display_rates["inner_{$colorKey}"]) && $this->display_rates["inner_{$colorKey}"] > 0) {
                return (float) $this->display_rates["inner_{$colorKey}"];
            }
        }

        $mult = match ($posKey) {
            'fp' => (float)$this->front_page_multiplier,
            'bp' => (float)$this->back_page_multiplier,
            default => (float)$this->inner_page_multiplier,
        };
        $rate = (float)$this->display_rate_col_inch * $mult;
        if ($colorKey === 'color') {
            $rate = $rate * (1 + ($this->color_charge_percent / 100));
        }

        return round($rate, 2);
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
