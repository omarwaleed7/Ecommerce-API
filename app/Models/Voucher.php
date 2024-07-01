<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
        'user_id',
    ];

    /**
     * Get the user that owns the voucher.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
