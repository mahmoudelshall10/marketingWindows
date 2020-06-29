<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['message' , 'from' , 'to' , 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
