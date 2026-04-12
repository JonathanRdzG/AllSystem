<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'branch_id', 'customer_id', 'quote_id', 'user_id', 'status', 'sale_date', 'total'];
}
