<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'branch_id', 'customer_id', 'user_id', 'status', 'valid_until', 'notes', 'total'];

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
}
