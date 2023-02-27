<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','key', 'role', 'actions'
    ];

    protected $casts = [
        'actions'   => 'json',
    ];
}
