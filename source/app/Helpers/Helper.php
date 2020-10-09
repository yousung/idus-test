<?php

declare(strict_types=1);

use \Illuminate\Http\JsonResponse;

if (!function_exists('makeJson')) {
    function makeJson($message, $status = 200):JsonResponse
    {
        if (is_string($message)) {
            $message = [
                'message' => $message,
            ];
        }

        if ($message instanceof \Illuminate\Support\Collection) {
            $message = [
                'data' => $message,
            ];
        }

        $message['status'] = $status;

        return response()->json($message, $status, [], 128);
    }
}
