<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get(string $key, $default = null)
    {
        $settings = static::getAllCached();
        return $settings[$key] ?? $default;
    }

    public static function getAllCached(): array
    {
        try {
            return Cache::remember('site_settings', 3600, function () {
                return static::all()->pluck('value', 'key')->toArray();
            });
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function set(string $key, $value, string $group = 'general')
    {
        $record = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget('site_settings');

        return $record;
    }
}

