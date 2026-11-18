<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DisplayAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_no',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'newspaper_id',
        'ad_category_id',
        'publish_date',
        'title',
        'page_position',
        'color_type',
        'columns',
        'height_inches',
        'total_col_inches',
        'rate_applied',
        'artwork_file',
        'needs_designer',
        'total_amount',
        'payment_method',
        'payment_trx_id',
        'payment_sender_phone',
        'payment_status',
        'status',
        'published_proof_url',
        'published_proof_image',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',
            'columns' => 'integer',
            'height_inches' => 'decimal:2',
            'total_col_inches' => 'decimal:2',
            'rate_applied' => 'decimal:2',
            'needs_designer' => 'boolean',
            'total_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newspaper(): BelongsTo
    {
        return $this->belongsTo(Newspaper::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AdCategory::class, 'ad_category_id');
    }

    public static function generateTrackingNo(): string
    {
        return 'DSP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
    }
}
