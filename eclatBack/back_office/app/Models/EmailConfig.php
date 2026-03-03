<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'host',
        'username',
        'password',
        'encryption',
        'port',
        'from_address',
        'from_name'
    ];

    protected $casts = [
        'port' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}