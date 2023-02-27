<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject', 'body', 'status',
        "company_id"
    ];


    public  function user(){

        return  $this->belongsTo(User::class);
    }
}
