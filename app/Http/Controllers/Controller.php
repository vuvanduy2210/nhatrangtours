<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function response($dataResponse = [], $statusCode = 200, $message = '')
    {
        if (is_numeric($dataResponse)) {
            $message = $statusCode;
            $statusCode = $dataResponse;
            $dataResponse = [];
        }

        return response([
            'status' => $statusCode,
            'code' => $statusCode,
            'message' => $message,
            'data' => $dataResponse
        ]);
    }

    public function sendResponse($data, $message, $extraData = [])
    {
        return Response::json($this->makeResponse($message, $data, $extraData));
    }

    private function makeResponse($message = 'ok', $data = [], array $extraData = [])
    {
        $response = [
            'code' => 200,
            'data' => $data,
            'message' => $message,
        ];

        if (!empty($extraData)) {
            $response = array_merge($response, $extraData);
        }

        return $response;
    }

    private function makeError($code, $message = '', $data = [])
    {
        $response = [
            'code' => $code,
            'data' => $data,
            'message' => $message,
        ];

        return $response;
    }


    public function sendError($code, $message = '', $data = [])
    {
        return Response::json($this->makeError($code, $message, $data));
    }
}
