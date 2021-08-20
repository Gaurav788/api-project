<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ToArray;
use Illuminate\Support\Facades\Validator;

use App\{User};  
class ApiResponseController extends Controller
{ 
    public $successStatus = 200; 
    
    /*
    API Name:       userList
    Developer:      Shine Dezign
    Created Date:   2021-05-14 (yyyy-mm-dd)
    Purpose:        return the list of all users
    */
    public function userList() 
    { 
        $user = User::get(); 
        return response([ 'data' => ToArray::collection($user), 'message' => 'Users list retrieved successfully'], $this->successStatus);
    }
    
    /*
    API Name:       managerList
    Developer:      Shine Dezign
    Created Date:   2021-05-14 (yyyy-mm-dd)
    Purpose:        return the list of all Manager
    */
    public function managerList() 
    { 
        $manager = User::role("User")->get();
        return response([ 'data' => ToArray::collection($manager), 'message' => 'Users list retrieved successfully'], $this->successStatus);
    }
}
