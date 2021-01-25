<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function topic() {
        return $this->hasOne('App\Models\Conversation', 'id', 'topic_id');
    }
    
    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
