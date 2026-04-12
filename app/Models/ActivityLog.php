<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'user_id', 'action', 'entity_type', 'entity_id', 'payload'];

    protected function casts(): array
    {
        return ['payload' => 'array'];
    }
}
