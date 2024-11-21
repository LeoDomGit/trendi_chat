<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $fillable = [
        'id',
        'user_id',
        'assistant_id',
        'thread_id',
        'run_id',
        'last_message_at',
        'last_message',
        'sort',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
