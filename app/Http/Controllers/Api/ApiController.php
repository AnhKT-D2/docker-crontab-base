<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\LogLevel;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    protected function response($res, $status = 200)
    {
        if (is_null($res) || (is_array($res) && count($res) == 0)) {
            $status = 204;
        }

        return response()->json($res, $status);
    }

    /**
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    protected function sendSuccess($result = null, $message = null): JsonResponse
    {
        $response = [
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * @param $code
     * @param $message
     * @param $status
     * @param $logLevel
     * @return JsonResponse
     */
    protected function sendError($code, $status, $message = null, $logLevel = LogLevel::ERROR): JsonResponse
    {
        // Log context
        $context = $this->getContext($code);

        if ($logLevel == LogLevel::DEBUG) {
            Log::debug($message, $context);
        } elseif ($logLevel == LogLevel::INFO) {
            Log::info($message, $context);
        } elseif ($logLevel == LogLevel::WARNING) {
            Log::warning($message, $context);
        } elseif ($logLevel == LogLevel::ERROR) {
            Log::error($message, $context);
        } elseif ($logLevel == LogLevel::ALERT) {
            Log::alert($message, $context);
        }

        $response = [
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];

        return response()->json($response, $status);
    }

    /**
     * Get log context.
     *
     * @param $code
     * @return array
     */
    private function getContext($code = null): array
    {
        if ($code) {
            return $context = [
                'code' => $code,
                'user_id' => Auth::check() ? Auth::user()->id : null,
                'input' => request()->all(),
            ];
        }

        return $context = [
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'input' => request()->all(),
        ];
    }

    protected function createDataForm($data)
    {
        $result = [];
        foreach ($data as $value => $text) {
            $result[] = [
                "value" => $value,
                "text" => $text,
            ];
        }

        return $result;
    }
}
