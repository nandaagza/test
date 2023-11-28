<?php

use Illuminate\Contracts\Routing\ResponseFactory;

if (!function_exists('response_success')) {
    function response_success($status = 200, $headers = [])
    {
        $headers = $headers + ['accept' => 'application/json'];

        return app(ResponseFactory::class)->json(['success' => true], $status, $headers);
    }
}

if (!function_exists('response_error')) {
    function response_error($message, $status = 500, $headers = [])
    {
        $data = [
            'message' => $message,
            'status' => $status,
        ];

        $headers = $headers + ['accept' => 'application/json'];

        return app(ResponseFactory::class)->json($data, $status, $headers);
    }
}

if (!function_exists('response_unauthorized')) {
    function response_unauthorized($message = 'Unauthorized', $headers = [])
    {
        return response_error($message, 403, $headers);
    }
}

if (!function_exists('response_404')) {
    function response_404($message = 'Data Missing', $headers = [])
    {
        return response_error($message, 404, $headers);
    }
}
