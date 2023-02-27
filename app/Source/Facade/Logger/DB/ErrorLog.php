<?php

namespace Api\Facade\Logger\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "end_point",
        "message",
        "from",
        "request_body",
        "query_param",
        "full_back_trace"
    ];
}
