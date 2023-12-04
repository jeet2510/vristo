<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory; 

protected $fillable = ['plan_name', 'plan_type', 'amount', 'num_of_companies_allowed'];


}
