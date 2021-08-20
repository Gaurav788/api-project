<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\{User, UserDetails, PasswordReset};
use Auth;

class VerifyEmail extends Controller
{
    public function verifyEmail($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset)
        {
            if (Auth::check())
            {
                $role_name = Auth::user()->getRoleNames()
                    ->first();
                switch ($role_name)
                {
                    case "User":
                        return redirect()
                            ->route('userdashboard')
                            ->with('status', 'error')
                            ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
                    break;
                    default:
                        return redirect()
                            ->route('home')
                            ->with('status', 'error')
                            ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
                }
            } else {
                return redirect()
                    ->route("login")
                    ->with('status', 'error')
                    ->with('message', Config::get('constants.ERROR.VERIFY_TOKEN_INVALID'));
            }
        } else {
            $users = User::where('email', $passwordReset->email)
                ->update(['status' => 1]);
            $passwordReset->delete();
            if (auth::check())
            {
                $role_name = Auth::user()->getRoleNames()
                    ->first();
                switch ($role_name)
                {
                    case "User":
                        return redirect()
                            ->route('userdashboard')
                            ->with('status', 'success')
                            ->with('message', Config::get('constants.SUCCESS.WELCOME'));
                    break;
                    default:
                        return redirect()
                            ->route('home')
                            ->with('status', 'success')
                            ->with('message', Config::get('constants.SUCCESS.WELCOME'));
                }
            } else {
                return redirect()
                    ->route("login")
                    ->with('status', 'success')
                    ->with('message', Config::get('constants.SUCCESS.WELCOME_LOGIN'));
            }

        }
    }
}
