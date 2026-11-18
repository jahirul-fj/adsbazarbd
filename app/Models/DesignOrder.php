<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DesignOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'client_id',
        'designer_id',
        'title',
        'brief_description',
        'ad_size_requirement',
        'attachment_file',
        'budget',
        'revisions_remaining',
        'status',
        'escrow_funded',
        'final_delivery_file',
        'rating',
        'review_comment',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'revisions_remaining' => 'integer',
            'escrow_funded' => 'boolean',
            'rating' => 'integer',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function designer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DesignOrderMessage::class)->oldest();
    }

    public static function generateOrderNo(): string
    {
        return 'DSN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
    }
}
