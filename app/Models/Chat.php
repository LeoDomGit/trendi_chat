<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table='messages';
    protected $fillable=[
        'id',
        'conversation_id',
        'sender_id',
        'content',
        'created_at',
        'updated_at'
    ];
}
