<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Setting extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    
    protected $fillable = [
        'writer_limit',
        'chat_limit',
        'image_limit',
        'reffered_limit',
        'apikey_android_revenuecat',
        'apikey_ios_revenuecat',
        'openai_api_key',
        'add_is_enabled',
        'android_app_id',
        'ios_app_id',
        'android_banner_id',
        'ios_banner_id',
        'android_interstitial_id',
        'ios_interstitial_id',
        'support_email',
        'privacy_policy',
        'terms_and_conditions',
        'faq',
        'app_version',
        'ads_writer_limit',
        'ads_chat_limit',
        'ads_image_limit',
        'android_reward_ads_id',
        'ios_reward_ads_id',
        'app_homepage_theme',
        'model_type',
    ];
}
