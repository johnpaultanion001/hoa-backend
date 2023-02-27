<?php

namespace Api\Facade\Logger\DB;

use Api\Facade\Logger\BaseClass;
use Api\Facade\Logger\DB\ErrorLog;

class DBLogger extends BaseClass
{
    /**
     * Log to the database
     */
    public function log() : void
    {
        ErrorLog::create([
            "end_point" => $this->fullBackTrace["endPoint"],
            "message" => $this->message,
            "from" => $this->fullBackTrace["from"],
            "request_body" => $this->fullBackTrace["requestBody"],
            "query_param" => $this->fullBackTrace["queryParam"],
            "full_back_trace" => $this->fullBackTrace["fullBackTrace"]
        ]); 
    }
}