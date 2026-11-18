<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignOrderMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'design_order_id',
        'sender_id',
        'message',
        'attachment_file',
        'is_draft_submission',
        'is_final_submission',
    ];

    protected function casts(): array
    {
        return [
            'is_draft_submission' => 'boolean',
            'is_final_submission' => 'boolean',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(DesignOrder::class, 'design_order_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
