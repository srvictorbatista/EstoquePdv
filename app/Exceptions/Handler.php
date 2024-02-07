<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /* Habilita exibicao de erros em formato json com laravel-debugbar --dev 
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->renderJsonException($exception); // exibe linha e arquivo do erro
        // return $this->renderException($request, $exception); // apenas o erro
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return response()->json(['error' => $e->validator->errors()->first()], 422);
    }

    protected function renderException($request, Throwable $exception)
    {
        $statusCode = $this->isHttpException($exception) ? $exception->getStatusCode() : 500;

        return response()->json(['error' => $exception->getMessage()], $statusCode);
    }

    protected function renderJsonException(Throwable $exception)
    {
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        $response = [
            'error' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        return new JsonResponse($response, $statusCode);
    }/**/

}
