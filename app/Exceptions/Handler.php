<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception) {
        if ($request->ajax() || $request->wantsJson()) {
            $response = $this->getResponse($request, $exception);

            return response()->json(
                $response,
                $response["code"]
            );

        }

        return parent::render($request, $exception);
    }

    /**
     * @param \Throwable $exception
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function getResponse($request, $exception): array {

        $array = [
            "code"    => 500,
            "success" => false,
            "message" => $exception->getMessage(),
        ];

        switch (true) {

            case $exception instanceof \Illuminate\Auth\AuthenticationException:
                $array["code"] = 401;
                break;

            case $exception instanceof \Illuminate\Validation\ValidationException;
                $array["errors"] = $exception->errors();
                $array["code"] = 422;
                break;

            case $exception instanceof \Api\Exceptions\CustomException;
                $array["code"] = $exception->getStatusCode();
                break;

            case $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException:
                $array["code"] = 404;
                $array["message"] = "End-point doesn't exist!";
                break;

            default:

                $array["fullbackTrace"] = $exception->getTrace();

                $this->log(
                    $request->path(),
                    $array["message"],
                    $request->post(),
                    $request->query(),
                    $array["fullbackTrace"],
                    $request->user()
                );

                break;

        }

        return $array;
    }

    /**
     * Log the details
     * @param string $endpoint
     * @param string $message
     * @param array $requestBody
     * @param array $queryParam
     * @param array $fullBackTrace
     */
    private function log(string $endpoint, string $message, array $requestBody, array $queryParam, array $fullBackTrace, $user) {
        try {

//            $errorDetails = [
//                "message" => $message,
//                "endPoint" => $endpoint,
//                "from" => json_encode($user),
//                "requestBody" => json_encode($requestBody),
//                "queryParam" => json_encode($queryParam),
//                "fullBackTrace" => json_encode($fullBackTrace)
//            ];

            //log to database
//            (new \Api\Facade\Logger\DB\DBLogger)
//            ->message($message)
//            ->fullBackTrace($errorDetails)
//            ->log();

            //log to slack
            $error =  ["message"       => $message,
                       "endPoint"      => $endpoint,
                       "from"          => $user,
                       "requestBody"   => $requestBody,
                       "queryParam"    => $queryParam,
                       "fullBackTrace" => $fullBackTrace,
            ];

            Log::build([
                'driver' => 'single',
                'path'   => storage_path('logs/'.time().'.log'),
            ])->info(json_encode(
                $error
            ));

//            Log::channel('slack')->error($errorDetails);

        } catch (\Throwable $th) {
            dd($th);
        }

    }
}
