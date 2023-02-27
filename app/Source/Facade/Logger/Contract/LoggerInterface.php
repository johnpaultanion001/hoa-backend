<?php

namespace Api\Facade\Logger\Contract;

interface LoggerInterface 
{
    /**
     * Log the details
     * @return void
     */
    public function log() : void ;

    /**
     * Message
     * @param string $message
     * @return self
     */
    public function message(string $message) : self ;

    /**
     * Full back trace
     * @param array $fullBackTrace
     * @return self
     */
    public function fullBackTrace(array $fullBackTrace) : self;
}