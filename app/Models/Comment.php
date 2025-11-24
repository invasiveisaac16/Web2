<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // --- AGREGA ESTO ---
    // Lista blanca de campos que se pueden guardar con create()
    protected $fillable = [
        'content',
        'user_id',
        'post_id'
    ];
    // -------------------

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}