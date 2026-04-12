<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'branch_id', 'customer_id', 'assigned_user_id',
        'status', 'title', 'description', 'promise_date', 'comments', 'checklist_json'
    ];

    protected function casts(): array
    {
        return ['promise_date' => 'date', 'checklist_json' => 'array'];
    }
}
