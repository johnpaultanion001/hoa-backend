<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $fillable = [
        "survey_id",
        "user_id",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
