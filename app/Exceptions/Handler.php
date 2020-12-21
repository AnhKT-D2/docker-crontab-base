<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ErrorType;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     */
    public function report(Exception $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // API response
        if ($request->is('api/*')) {
            if ($exception instanceof AuthenticationException) {
                return $this->toResponse($request, ErrorType::CODE_4010, trans('errors.MSG_4010'), ErrorType::STATUS_4010);
            }

            if ($exception instanceof Responsable) {
                return $exception->toResponse($request);
            }

            // validation exception
            if ($exception instanceof ValidationException) {
                $response = [
                    'error' => [
                        'code' => (int)ErrorType::CODE_4220,
                        'message' => $exception->errors()
                    ]
                ];
                return response()->json($response, ErrorType::STATUS_4220);
            }

            // HTTP Exception
            if ($this->isHttpException($exception)) {
                if ($exception->getStatusCode() == ErrorType::STATUS_4000) {
                    return $this->toResponse($request, ErrorType::CODE_4000, __('errors.MSG_4000'), $exception->getStatusCode());
                }

                if ($exception->getStatusCode() == ErrorType::STATUS_4050) {
                    return $this->toResponse($request, ErrorType::CODE_4050, __('errors.MSG_4050'), $exception->getStatusCode());
                }
            }

            return $this->toResponse($request, ErrorType::CODE_5001, __('errors.MSG_5001'), ErrorType::STATUS_5001);
        }

        if (!($exception instanceof ValidationException)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(
                    $this->getJsonMessage($exception),
                    $this->getExceptionHTTPStatusCode($exception)
                );
            }
        }

        return parent::render($request, $exception);
    }

    protected function toResponse($request, string $code, string $message, int $status)
    {
        return (new BaseException($code, $message, $status))->toResponse($request);
    }

    protected function getJsonMessage($e)
    {
        // You may add in the code, but it's duplication
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }

    protected function getExceptionHTTPStatusCode($e)
    {
        // Not all Exceptions have a http status code
        // We will give Error 500 if none found
        return method_exists($e, 'getStatusCode') ?
            $e->getStatusCode() : 500;
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Validation\ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        $error = 'Validation Error';
        $response = [
            'status' => 'fail',
            'message' => $error,
        ];

        foreach ($exception->errors() as $key => $errors) {
            if (is_array($errors) && count($errors)) {
                foreach ($errors as $error) {
                    $response['data']['errors'][] = [
                        'key' => $key,
                        'error' => $error,
                    ];
                }
            } else {
                $response['data']['errors'] = [];
            }
        }

        return response()->json($response, $exception->status);
    }
}
