<?php

namespace App\Http\Controllers\Response;

use App\Helpers\ServiceResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     *
     * @param ServiceResponse 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponse(ServiceResponse $result)
    {

        return response()->json([
            'status' => $result->status,
            'message' => $result->message,
            'data' => $result->data,
        ], $result->statusCode);
    }
}
