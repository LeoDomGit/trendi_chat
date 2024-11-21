<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'id',
        'room_id',
        'character_id',
        'message',
        'is_read',
        'sort',
        'created_at',
        'updated_at',
    ];

    /**
     * Define a relationship with the Conversation model.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'room_id');
    }

    /**
     * Define a relationship with the Character model.
     */
    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id'); // Updated the key to match the corrected column
    }
}
