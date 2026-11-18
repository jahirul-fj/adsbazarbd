<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'user_id',
        'order_type',
        'order_id',
        'amount',
        'payment_method',
        'trx_id',
        'sender_phone',
        'status',
        'notes',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function generateInvoiceNo(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
    }
}
