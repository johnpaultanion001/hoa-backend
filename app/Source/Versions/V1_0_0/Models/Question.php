<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        "survey_id",
        "content",
        "required",
        "type",
    ];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function options() {
        return $this->hasMany(Option::class);
    }
}
