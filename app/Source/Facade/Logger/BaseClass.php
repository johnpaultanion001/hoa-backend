<?php

namespace Api\Facade\Logger;

use Api\Facade\Logger\Contract\LoggerInterface;

abstract class BaseClass implements LoggerInterface
{
    /**
     * @var string $message
     */
    protected $message = "";

    /**
     * @var array $fullBackTrace 
     */
    protected $fullBackTrace = [];


    /**
     * Set the error message
     * @param string $message
     * @return self
     */
    public function message(string $message) : self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the fullbacktrace of the error
     * @param array $fullBackTrace
     * @return self
     */
    public function fullBackTrace(array $fullBackTrace) : self
    {
        $this->fullBackTrace = $fullBackTrace;

        return $this;
    }

    /**
     * Log deatails
     * @return void
     */
    abstract function log() : void;
}