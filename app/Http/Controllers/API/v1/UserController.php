<?php

namespace App\Http\Controllers\API\v1;
use Illuminate\Support\Facades\{Config, File};
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\ToArray;
use App\Traits\AutoResponderTrait;
use Illuminate\Support\Str;
use App\Http\Requests\RegisterRequest;
use Validator, Session ;
use App\{User, UserDetails, PasswordReset, Cart };  
use Illuminate\Support\Facades\Hash;

class UserController extends Controller 
{
    use AutoResponderTrait;
    public $successStatus = 200; 

    /*
    API Method Name:register
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        For user registration
    */ 
    public function register(Request $request) 
    {  
        $validator = Validator::make($request->all(), [ 
            'first_name' => 'required', 
            'last_name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        } 

        try {
            $password = bcrypt($request->password);  
            $request->request->add([
                'social_type' => 'Website',
                'social_id' => 0, 
                'status' => 0,   
                'remember_token' => Str::random(10),      //remove this line after API testing 
                'password' => $password,
            ]);  
            $user = User::create($request->all()); 
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            $userDetail = [ 'user_id' => $user->id ];

            $create_status = UserDetails::create($userDetail);
            $user->assignRole('User');

            /*Send Verification Link*/
            $passwordReset = PasswordReset::updateOrCreate(['email' => $request->email], ['email' => $request->email, 'token' => Str::random(12) ]);

            $logtoken = Str::random(12);
            $link = route('verifyEmail', $passwordReset->token);
            $template = $this->get_template_by_name('VERIFY_EMAIL');

            $string_to_replace = [ '{{$name}}', '{{$token}}', '{{$logToken}}' ];
            $string_replace_with = [ $request->first_name . ' ' . $request->last_name, $link, $logtoken ];

            $newval = str_replace($string_to_replace, $string_replace_with, $template->template);
            $logId = $this->email_log_create($request->email, $template->id, 'VERIFY_EMAIL', $logtoken);

            $result = $this->send_mail($request->email, $template->subject, $newval);
            if ($result) {
                $this->email_log_update($logId);
            }
            /*End of Send Email Verification Link*/
            if ($create_status) {   
                $response['success'] = true;
                $response['message'] = Config::get('constants.SUCCESS.ACCOUNT_CREATED');
                $response['token'] =  $token; 
            } else { 
                $response['success'] = false;
                $response['message'] = Config::get('constants.ERROR.OOPS_ERROR'); 
            } 

            return response()->json(['response'=>$response], $this->successStatus); 
        } catch ( \Exception $e ) {
            return response([ 'status' => false, 'data' => '', 'message' => $e->getMessage()], $this->successStatus); 
        }
    } 
    /* End Method register */ 

    /*
    API Method Name:login
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        return that user is authorized or not
    Remarks:        Passport Must Installed
    */  
    public function login(Request $request){ 
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
        try {
            $user = User::where('email', $request->email)->first();
            if($user->status == 0){
                $response['success'] = false;
                $response['message'] = 'User email not verified yet';
                return response($response, 422);
            }      
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $response['success'] = true; 
                    $response['user_details'] = $user->where('email', $request->email)->select('id','first_name','last_name','email')->first();
                    $response['token'] =  $user->createToken('Laravel Password Grant Client')->accessToken; 
                    return response($response, 200);
                } else { 
                    $response['success'] = false;
                    $response['message'] = 'Password mismatch';
                    return response($response, 422);
                }
            } else {
                $response['success'] = false;
                $response["message"] = 'User does not exist';
                return response($response, 422);
            }
        } catch ( \Exception $e ) {
            return response([ 'status' => false, 'data' => '', 'message' => $e->getMessage()], $this->successStatus); 
        }
    }  
    /* End Method login */

    /*
    API Method Name:passwordResetLink
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Send the password reset link to requested Email
    */ 
    public function passwordResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [ 'email' => 'required|email' ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        } 
        try {
            $user = User::role('User')->where('email', $request->email)->first(); 

            if (!$user) {
                $response['success'] = false; 
                $response['message'] = Config::get('constants.ERROR.WRONG_CREDENTIAL');
            } else { 
                $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => Str::random(12) ]);

                $link = route('checktoken', $passwordReset->token); 
                $template = $this->get_template_by_name('FORGOT_PASSWORD');

                $string_to_replace = [ '{{$name}}', '{{$token}}' ];
                $string_replace_with = [ 'User', $link ];

                $newval = str_replace($string_to_replace, $string_replace_with, $template->template);

                $logId = $this->email_log_create($user->email, $template->id, 'FORGOT_PASSWORD');
                $result = $this->send_mail($user->email, $template->subject, $newval);
            
                if ($result) { 
                    $this->email_log_update($logId);
                    $response['success'] = true;
                    $response['message'] = Config::get('constants.SUCCESS.RESET_LINK_MAIL');   
                } else { 
                    $response['success'] = false;
                    $response['message'] = Config::get('constants.ERROR.OOPS_ERROR'); 
                } 
            }
            return response()->json(['response' => $response], $this->successStatus);
        } catch ( \Exception $e ) {
            return response([ 'status' => false, 'data' => '', 'message' => $e->getMessage() ], $this->successStatus); 
        }
    }

    /* End Method passwordResetLink */
    
    /*
    API Method Name:updateNewPassword
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update new Password
    */ 
    public function updateNewPassword(Request $request)
    {
        $isRequested = PasswordReset::where('email', $request->forgotemail)->first(); 

        if (!$request->forgotemail || !$isRequested){ 
            $response['success'] = false;
            $response['message'] = Config::get('constants.ERROR.WRONG_CREDENTIAL');  

            return response()->json(['response' => $response], $this->successStatus);
        }

        $validator = Validator::make($request->all(), [  
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }  
        try {
            
            $email = $request->forgotemail; 
            $data = [
                'password' => bcrypt($request->password),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $record = User::where('email', $email)->update($data);
            PasswordReset::where('email', $email)->delete(); 

            $response['success'] = true;
            $response['message'] = 'Your password ' . Config::get('constants.SUCCESS.UPDATE_DONE');  

            return response()->json(['response' => $response], $this->successStatus);
            
        } catch(\Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();  
            
            return response()->json(['response' => $response], $this->successStatus); 
        }

    }
    /* End Method updateNewPassword */
    
    /*
    API Method Name:userDetail
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update new Password
    */ 
    public function userDetail(Request $request)
    { 
        try {
            $userId = Auth::user()->id; 
            $detail = User::with('user_detail:id,user_id,address,mobile,city,state,zipcode,dob')
            ->select('id','first_name','last_name','email')
            ->where('id', $userId)
            ->first(); 

            $response['success'] = true;
            $response['data'] = $detail;
            $response['message'] = 'User detail retrieved successfully';  

            return response()->json(['response' => $response], $this->successStatus);
            
        } catch(\Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();  
            
            return response()->json(['response' => $response], $this->successStatus); 
        }

    }
    /* End Method userDetail */

    /*
    API Method Name:updatePassword
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update new Password 
    */
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [ 
            'current_password' => 'required', 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
            ]); 
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }  
            
        try {
            $id = Auth::user()->id; 
            $record = User::where(['id' => $id])->first(); 
            if (Hash::check($request->current_password,$record->password)) { 
                $data = [
                    'password' => bcrypt($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $record = User::where('id', $id)->update($data);

                $response['success'] = true; 
                $response['message'] = 'User password '.Config::get('constants.SUCCESS.UPDATE_DONE');  
    
                return response()->json(['response' => $response], $this->successStatus);
 
            } else {
                $response['success'] = true; 
                $response['message'] = 'Current password is wrong';  

                return response()->json(['response' => $response], $this->successStatus);
            }
           

        } catch ( \Exception $e ) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();  
            
            return response()->json(['response' => $response], $this->successStatus); 
        }
    }
    /* End Method updatePassword */ 

    /*
    API Method Name:updateDetail
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update user detail 
    */
    public function updateDetail(Request $request){
        $validator = Validator::make($request->all(), [ 
            'first_name' => 'required', 
            'last_name' => 'required', 
            ]); 
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }  
                
        try { 
            $id = Auth::user()->id;  
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $record = User::where('id', $id)->update($data);
            if ($record) {
                $response['success'] = true; 
                $response['message'] = 'User detail '.Config::get('constants.SUCCESS.UPDATE_DONE');  
                
                return response()->json(['response' => $response], $this->successStatus);  
            } 

        } catch ( \Exception $e ) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();  
            
            return response()->json(['response' => $response], $this->successStatus); 
        }
    }
    /* End Method updateDetail */ 

}