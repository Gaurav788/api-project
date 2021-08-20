<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Config, Auth, Validator, Hash, Crypt};
use Illuminate\Validation\Rule;
use Illuminate\Support\{Collection, Str};
use Carbon\Carbon;
use App\Http\Requests\AdminRequest;
use App\{User, UserDetails, PasswordReset,Job, Earning};
use App\Traits\AutoResponderTrait;
use Spatie\Permission\Models\{Role, Permission}; 
use Image,DB,Session;

class AdminDashboardController extends Controller
{
    use AutoResponderTrait;

    /*
    Method Name:    index
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To display dashboard for admin after login
    Params:         []
    */
    public function index(Request $request)
    {
        $start = $end = $daterange = '';
  
        if($request->has('daterange_filter') && $request->daterange_filter != '') {
            $daterange = $request->daterange_filter;
            $daterang = explode(' / ',$daterange);
            $start = $daterang[0].' 00:05:00';
            $end = $daterang[1].' 23:05:59';
        }
        $usersDetails = UserDetails::where('user_id', Auth::user()->id)->first();
        $userCount = User::role('User')->when($daterange != '', function ($query) use ($start, $end)
        {
            $query->whereBetween('created_at', [$start, $end]);

        })->count();
        $activeUserCount = User::role('User')->where('status',1)->when($daterange != '', function ($query) use ($start, $end)
        {
            $query->whereBetween('created_at', [$start, $end]);
        })->count();

        if (!is_null($usersDetails)) {
            Session::put('userdetails', $usersDetails);
        }
        
        return view('admin.home', compact('userCount', 'activeUserCount', 'daterange'));
    }
    /* End Method index */

    /*
    Method Name:    login
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        For Admin login form
    Params:         []
    */
    public function login()
    { 
        if (auth::check()) {
            return redirect()->route('admindashboard');
        } else {
            return view('admin.loginform');
        }
    }
    /* End Method login */

    /*
    Method Name:    authenticateUser
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Admin login credentials check
    Params:         [email, password]
    */
    public function authenticateUser(AdminRequest $request)
    {  
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $attempt = [
            $fieldType => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($attempt)) {
            return redirect()->route('admindashboard');
        } else {
            return redirect()
                ->route('admin')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.WRONG_CREDENTIAL'));
        }
    }
    /* End Method authenticateUser */

    /*
    Method Name:    logout
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Logout Admin
    Params:
    */
    public function logout(){
		Auth::logout();
        return redirect()->to('/');
    }
    /* End Method logout */

    /*
    Method Name:    resetPassword
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Form for forgot password
    Params:
    */
    public function resetPassword()
    {
        if (auth::check()) {
            return redirect()->route('admindashboard');
        }

        return view('admin.passwordreset');
    }
    /* End Method resetPassword */

    /*
    Method Name:    resetPasswordLink
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Send reset password link email if admin email exist
    Params:         [email]
    */
    public function resetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $roles = ['User', 'Company'];

        $adminRoles = [];
        foreach ($this->getAdminRoles($roles) as $row) {
            $adminRoles[] = $row->name;
        }
        $user = User::role($adminRoles)->where('email', $request->email)->first();
        $template = $this->get_template_by_name('FORGOT_PASSWORD');

        if (is_null($user)) {
            return redirect()->back()
            ->with('status', 'Error')
            ->with('message', Config::get('constants.ERROR.WRONG_CREDENTIAL'));
        }
        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => Str::random(12)]);

        $link = route('tokencheck', $passwordReset->token);
        $string_to_replace = [
            '{{$name}}',
            '{{$token}}'
        ];
        $string_replace_with = [
            'Admin',
            $link
        ];
        $newval = str_replace($string_to_replace, $string_replace_with, $template->template);
        $logId = $this->email_log_create($user->email, $template->id, 'FORGOT_PASSWORD');
        $result = $this->send_mail($user->email, $template->subject, $newval);

        if ($result) {
            $this->email_log_update($logId);
            return redirect()
                ->route('resetpassword')
                ->with('status', 'Success')
                ->with('message', Config::get('constants.SUCCESS.RESET_LINK_MAIL'));
        } else {
            return redirect()
                ->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        }
    }
    /* End Method resetPasswordLink */

    /*
    Method Name:    verifyResetPasswordToken
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Checked reset access token
    Params:         [token]
    */
    public function verifyResetPasswordToken($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (is_null($passwordReset)) {
            return redirect()
                ->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
        }

        if (Carbon::parse($passwordReset->updated_at)
            ->addMinutes(240)
            ->isPast()) {
            $passwordReset->delete();

            return redirect()
                ->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
        }
        Session::put('forgotemail', $passwordReset->email);

        return redirect()->route('setnewpassword');
    }
    /* End Method verifyResetPasswordToken */

    /*
    Method Name:    setNewPassword
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Form to set new password after reset password
    Params:
    */
    public function setNewPassword()
    {
	    if (auth::check()) {
            return redirect()->route('admindashboard');
        }

        if (Session::has('forgotemail')) {
            return view('admin.setnewpassword');
        } else {
            return redirect()
                ->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        }
    }
    /* End Method setNewPassword */

    /*
    Method Name:    updateNewPassword
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update new password after reset pasword
    Params:         [password]
    */
    public function updateNewPassword(Request $request)
    {
        if (!Session::has('forgotemail')) {
            return redirect()
                ->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        }
        $email = Session::get('forgotemail');
        $request->validate([
            'password' => 'required_with:password_confirmation|string|confirmed'
        ]);
        try {
            $data = [
                'password' => bcrypt($request->password),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
            $record = User::where('email', $email)->update($data);
            PasswordReset::where('email', $email)->delete();
            Session::forget('forgotemail');
            return redirect()
                ->route('admin')
                ->with('status', 'success')
                ->with('message', 'Your password ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }

    }
    /* End Method updateNewPassword */

    /*
    Method Name:    updateDetails
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update admin details
    Params:         [adminemail, first_name, last_name, profile_pic]
    */
    public function updateDetails(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'adminemail' => 'required|email|unique:users,email,' . Auth::user()->id,
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        if ($validator->fails() && $request->ajax()) {
            return response()
                ->json(["success" => false, "errors" => $validator->getMessageBag()
                ->toArray() ], 422);
        }

        try { 
            $data = [
                'email' => $request->adminemail,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];

            //If Admin uploaded profile pictuce
            if ($request->hasFile('profile_pic')) {
                $allowedfileExtension = ['jpg', 'png'];
                $file = $request->file('profile_pic');
                $extension = $file->getClientOriginalExtension();

                if (in_array($extension, $allowedfileExtension)) {
                    $resizeImage = Image::make($file)->resize(null, 90, function ($constraint)
                    {
                        $constraint->aspectRatio();
                    })
                        ->encode($extension);
                    $users_details = UserDetails::where('user_id', Auth::user()->id)
                        ->first();
                    if ($users_details == null) {
                        $users_details = UserDetails::create(['user_id' => Auth::user()->id, 'profile_picture' => $resizeImage, 'imagetype' => $extension, 'status' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s') ]);
                    } else {
                        $users_details->update(['profile_picture' => $resizeImage, 'imagetype' => $extension, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s') ]);
                    }
                } else {
                    return response()->json(["success" => false, "msg" => "Please select png or jpg images."], 200);
                }
            }
            $record = User::where('id', Auth::user()->id)
                ->update($data);
            if ($record > 0){
                $users_details = UserDetails::where('user_id', Auth::user()->id)
                    ->first();
                if ($users_details != null){
                    Session::put('userdetails', $users_details);
                }
                return response()->json(["success" => true, "msg" => "User details " . Config::get('constants.SUCCESS.UPDATE_DONE') ], 200);
            } else {
                return response()->json(["success" => false, "msg" => Config::get('constants.ERROR.OOPS_ERROR') ], 200);
            }
        } catch(\Exception $e) {
            throw $e;
            return response()->json(["success" => false, "msg" => $e], 200);
        }
    }
    /* End Method updateDetails */

    /*
    Method Name:    updatePassword
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update admin password
    Params:         [oldpassword, newpassword]
    */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all() , ['oldpassword' => 'required', 'newpassword' => 'required']);
        if ($validator->fails()){
            if ($request->ajax()){
                return response()
                    ->json(["success" => false, "errors" => $validator->getMessageBag()
                    ->toArray() ], 422);
            }
        }
        $hashedPassword = Auth::user()->password;
        if (\Hash::check($request->oldpassword, $hashedPassword)){
            if (!\Hash::check($request->newpassword, $hashedPassword)){
                $users = User::find(Auth::user()->id);
                $users->password = bcrypt($request->newpassword);
                $users->save();
                return response()
                    ->json(["success" => true, "msg" => "User password updated Successfully"], 200);
            } else {
                return response()
                    ->json(["success" => false, "msg" => "New password can not be the old password!"], 200);
            }
        } else {
            return response()
                ->json(["success" => false, "msg" => 'Old password doesnt matched'], 200);
        } 
    }
    /* End Method updatePassword */
}