<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionPlan;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'company_name', 'company_short_name', 'contact_person_full_name', 'website_address',
        'contact_number', 'whatsapp_number', 'email', 'address_1', 'address_2', 'state',
        'city', 'pin_code', 'password', 'currency', 'currency_symbol',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_id');
    }
 
}