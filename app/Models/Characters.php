<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characters extends Model
{
    use HasFactory;
    protected $table='characters';
    protected $fillable=[
        'id',
        'name',
        'seed',
        'assistant_id',
        'assistant_intro',
        'instructions',
        'tools',
        'model',
        'slug',
        'opening_greeting',
        'photo',
        'is_public',
        'lock',
        'is_active',
        'created_at',
        'updated_at',
    ];

}
