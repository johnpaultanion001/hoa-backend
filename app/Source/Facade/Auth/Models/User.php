<?php

namespace Api\Facade\Auth\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','last_login_at','uid','phone_number','photo_url','disabled','email_verified','role','name'
    ];




}
