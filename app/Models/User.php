<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // テーブル名
    protected $table = 'users';

    // 可変項目
    protected $fillable = 
    [
        'name',
        'email',
        'password',
    ];

    protected $hidden = 
    [
        'password',
        'remember_token',
    ];

    protected $casts = 
    [
        'email_verified_at' => 'datetime',
    ];
}
