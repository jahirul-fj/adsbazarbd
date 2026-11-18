<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'avatar',
        'bio',
        'balance',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDesigner(): bool
    {
        return $this->role === 'designer';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function designerProfile(): HasOne
    {
        return $this->hasOne(DesignerProfile::class);
    }

    public function classifiedAds(): HasMany
    {
        return $this->hasMany(ClassifiedAd::class);
    }

    public function displayAds(): HasMany
    {
        return $this->hasMany(DisplayAd::class);
    }

    public function clientOrders(): HasMany
    {
        return $this->hasMany(DesignOrder::class, 'client_id');
    }

    public function designerOrders(): HasMany
    {
        return $this->hasMany(DesignOrder::class, 'designer_id');
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }
}
