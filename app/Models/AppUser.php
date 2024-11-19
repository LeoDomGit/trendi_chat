<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AppUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'customer_id',
        'name',
        'phone',
        'email',
        'status',
        'password',
        'writer_limit',
        'chat_limit',
        'image_limit',
        'fcmtoken',
        'join_by_referral_code',
        'referral_code',
        'chat_request',
        'chat_word_count',
        'proms_request',
        'proms_word_count',
        'image_request',

    ];
 
    public function subscription(): HasOne
    {
        return $this->hasOne(SubscriptionUser::class,'user_id');
    }
}
