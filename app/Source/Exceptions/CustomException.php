<?php

namespace Api\Exceptions;

use Exception;

class CustomException extends Exception
{
    /**
     * Status code of the response
     * @var int $statusCode
     */
    protected $statusCode;

    /**
     * Message of the response
     * @var string $message
     */
    protected $message;

    /**
     * Creatre new instance
     * @param int $statusCode
     * @param string $message
     */
    public function __construct(int $statusCode, string $message)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            "code" => $this->statusCode,
            "success" => false,
            "message" => $this->message
        ], $this->statusCode);
    }
    
    /**
     * Get the status code
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }
}
