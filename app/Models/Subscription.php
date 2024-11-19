<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'android_subscription_key',
        'ios_subscription_key',
        'price',
        'discount',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
