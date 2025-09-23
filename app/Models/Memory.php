<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    protected $fillable = [
        'name',
        'relation',
        'message',
        'media_path',
        'media_mime',
        'consent',
        'status',
        'ip',
    ];

    protected $casts = [
        'consent' => 'boolean',
        'created_at' => 'datetime',
    ];
}
