<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'key', 'value'];

    protected $casts = ['value' => 'array'];

    public  function  user(){
        return $this->belongsTo(User::class);
    }
}
