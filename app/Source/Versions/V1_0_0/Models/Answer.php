<?php

namespace Api\V1_0_0\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        "response_id",
        "survey_id",
        "question_id",
        "option_id",
        "user_id",
        "answer",
    ];

    public function response() {
        return $this->belongsTo(Response::class);
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function option() {
        return $this->belongsTo(Option::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
