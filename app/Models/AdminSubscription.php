<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSubscription extends Model
{
    use HasFactory;
    protected $fillable = ['company_name', 'contact_person', 'subscription_id', 'start_date', 'end_date'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
