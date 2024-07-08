<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'topic', 'body', 'pinPost'
    ];

    protected $casts = [
        'pinPost' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
