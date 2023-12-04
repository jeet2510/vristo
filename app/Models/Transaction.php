<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'company_id',
        'selected_plan',
        'plan_type',
        'amount',
        'collected_amount',
        'payment_mode',
        'transaction_date',
        'reference_id',
    ];
}
