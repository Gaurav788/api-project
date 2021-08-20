<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Config;

use Closure, Auth;
use App\User;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth::check())
        {
            $admin_list = (['User']);
            $user_role = Auth::user()->getRoleNames()
                ->first();
            if (in_array($user_role, $admin_list) && Auth::user()->status == 1 )
            {
                return $next($request);
            }
            else
            {
                Auth::logout();
                if($request->ajax()) // This is what i am needing.
                {
                    return response()->json(['error' => 'error', 'message' => 'Session timeout'], 302);
                }
                return redirect()->route('login')
                    ->with('status', 'error')
                    ->with('message', Config::get('constants.ERROR.ACCOUNT_ISSUE'));
            }
            return $next($request);
        }
        else
        {
            Auth::logout();
            if($request->ajax()) // This is what i am needing.
            {
               return response()->json(['error' => 'error', 'message' => 'Session timeout'], 302);
            }
            return redirect()->route('login')
                ->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        }
    }
}

