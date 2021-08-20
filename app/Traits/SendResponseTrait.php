<?php
 
namespace App\Traits;

trait SendResponseTrait {
    
    public function apiResponse($apiResponse, $statusCode = '404', $message = 'No records Found', $data = []) {
        $responseArray = [];
        if($apiResponse == 'success') {
            $responseArray['api_response'] = $apiResponse;
            $responseArray['status_code'] = $statusCode;
            $responseArray['message'] = $message;
            $responseArray['data'] = $data;
        } else {
            $responseArray['api_response'] = 'error';
            $responseArray['status_code'] = $statusCode;
            $responseArray['message'] = $message;
            $responseArray['data'] = [];    
        }
        return response()->json($responseArray);
    }
}