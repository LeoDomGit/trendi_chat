<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'user_id',
        'subscription_id',
        'transaction_details',
    ];
    
}
