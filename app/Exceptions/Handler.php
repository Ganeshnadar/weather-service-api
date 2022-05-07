<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


   /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {

        // return parent::render($request, $e);
        list($status, $e) = $this->getStatusCodeFromException($e);

        if (env('APP_DEBUG')) {
            $error['success'] = false;
            $error['status'] = $status;
            $error['message'] = $e->getMessage();
            $error['file'] = $e->getFile() . ':' . $e->getLine();
            $error['trace'] = explode("\n", $e->getTraceAsString());

            return response()->json($error, $status, [],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        }

        return \response()->json([
            'success' => false,
            'status' => $status,
            'message' => $e->getMessage()
        ], $status);
    }

    private function getStatusCodeFromException(Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            $status = Response::HTTP_UNAUTHORIZED;
            $e      = new AuthenticationException('HTTP_UNAUTHORIZED');
        } elseif ($e instanceof HttpResponseException) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $status = Response::HTTP_METHOD_NOT_ALLOWED;
            $e      = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);
        } elseif ($e instanceof NotFoundHttpException) {
            $status = Response::HTTP_NOT_FOUND;
            $e      = new NotFoundHttpException('HTTP_NOT_FOUND', $e);
        } elseif ($e instanceof AuthorizationException) {
            $status = Response::HTTP_FORBIDDEN;
            $e      = new AuthorizationException('HTTP_FORBIDDEN', $status);
        } elseif ($e instanceof \Dotenv\Exception\ValidationException) {
            $status = Response::HTTP_BAD_REQUEST;
            $e      = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $e);
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $e = new HttpException($status, 'HTTP_INTERNAL_SERVER_ERROR');
        }

        return [$status, $e];
    }
}
