<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    function sendResponse($result, $code = 200, $message = null)
    {
        $response = [
            'data' => $result,
        ];

        isset($message) ? $response['message'] = $message : null;

        return response()->json($response, $code);
    }

    function sendError($error, $code = 404, $errorMessages = [] )
    {
        $response = [
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

}
