<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\{User, Role, UserDetails, Job};

class UserController extends Controller
{
    function __construct(){

    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To get list of all users
    Params:
    */
    public function getList(Request $request){
        $start = $end = $keyword = $daterange = '';
 
        if($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        }
        if($request->has('daterange_filter') && $request->daterange_filter != '') {
            $daterange = $request->daterange_filter;
            $daterang = explode(' / ',$daterange);
            $start = $daterang[0].' 00:05:00';
            $end = $daterang[1].' 23:05:59';
        } 
        session(['startDate' => $start, 'endDate' => $end, 'keyword' => $keyword]); 

        $data = User::where(function ($q) use($start,$end) {
            $q->when(!empty($start) && !empty($end) ,function($query) use($start ,$end) {
                $query->whereBetween('created_at', [$start, $end]);
            }); 
        })
        ->where(function ($q) use($keyword ) {
            $q->when(!empty($keyword),function($qu) use($keyword) {
                $qu->where('first_name', 'like', '%'.$keyword.'%')
                ->orWhere('last_name', 'like', '%'.$keyword.'%')
                ->orWhere('email', 'like', '%'.$keyword.'%')
                ->orWhere('id', $keyword);
            });
        })->role('User')
        ->sortable(['id' => 'desc'])->paginate(Config::get('constants.PAGINATION_NUMBER'));
        return view('admin.users.list', compact('data','keyword','daterange'));
    }
    /* End Method getList */

    /*
    Method Name:    createDetail
    Developer:      Shine Dezign
    Created Date:   2021-05-19 (yyyy-mm-dd)
    Purpose:        To update user details
    Params:         [edit_record_id, first_name, last_name, email, role, status]
    */
    public function createDetail(Request $request, $id = NULL){
        if ($request->isMethod('get')) {
            $roles = Role::where('name', '<>', 'Administrator')->get();
            return view('admin.users.add',compact('roles'));
        }
        else
        {
            $postData = $request->all();
            $request->validate([
                'first_name' => 'required|string|max:200',
                'middle_name' => 'max:200',
                'last_name' => 'required|string|max:200',
                'address' => 'required|max:200',
                'dob' => 'required',
                'email' => 'required|email:rfc,dns|unique:users',
                'mobile' => 'required|numeric|unique:user_details', 
                'city' => 'required|string|max:50',
                'state' => 'required|string|max:50', 
            ]);
            try {
                $data = array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'social_type' => 'Website',
                    'social_id' => 0,
                    'status' => 1,
                );
                $user = User::create($data);

                $role = Role::where('name', 'User')->first();
                $user->assignRole([$role->id]);
                $data1 = array(
                    'user_id' => $user->id,
                    'mobile' => $request->mobile,                    
                    'address' => $request->address,  
                    'dob' => $request->dob, 
                    'fax_no' => $request->fax_no, 
                    'city' => $request->city, 
                    'state' => $request->state, 
                    'zipcode' => $request->zipcode, 
                    'mobile' => $request->mobile 
                );
                UserDetails::create($data1);  
                $routes = ($request->action == 'saveadd') ? 'user.add' : 'user.list';
                return redirect()->route($routes)->with('status', 'success')->with('message', 'User details '.Config::get('constants.SUCCESS.CREATE_DONE'));
            } catch ( \Exception $e ) {
                return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
            }
        }
    }
    /* End Method createDetail */

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-08-09 (yyyy-mm-dd)
    Purpose:        To delete any user by id
    Params:         [id]
    */
    public function del_record($id){
        try { 
            User::where('id',$id)->update(['is_deleted' => 1]);
        	return redirect()->back()->with('status', 'success')->with('message', 'User details '.Config::get('constants.SUCCESS.DELETE_DONE'));
        } catch(Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    /* End Method del_record */

    /*
    Method Name:    del_restore
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To restore deleted user by id
    Params:         [id]
    */
    public function del_restore($id){
        try {
            User::where('id',$id)->update(['is_deleted' => 0]);
        	return redirect()->back()->with('status', 'success')->with('message', 'User details '.Config::get('constants.SUCCESS.RESTORE_DONE'));
        } catch(Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    /* End Method del_restore */

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update user details
    Params:         [edit_record_id, first_name, last_name, address, dob, mobile, city, state, status]
    */
    public function updateDetail(Request $request, $id = NULL){ 
        if ($request->isMethod('get')) {
            $userDetail = User::with('user_detail')->find( decode_userdata($id) );
            if(!$userDetail)
                return redirect()->route('users.list');
            $roles = Role::where('name', '<>', 'Administrator')->get();
            return view('admin.users.edit',compact('userDetail','roles'));
        }
        else
        {
            $id = $request->edit_record_id;
            $request->validate([
                'first_name' => 'required|string|max:200',
                'middle_name' => 'max:200',
                'last_name' => 'required|string|max:200',
                'address' => 'required|max:200',
                'dob' => 'required',
                'mobile' => 'required|numeric|unique:user_details,mobile,'.$id.',user_id', 
                'city' => 'required|string|max:50',
                'state' => 'required|string|max:50', 
            ]);
            try {
                $status = 0;
                if($request->status == "on") {
                    $status = 1;
                }
                $users = User::findOrFail($id); 
                $users->first_name = $request->first_name;
                $users->last_name = $request->last_name; 
                $users->status = $status; 
                $users->push();
                $user_detail = UserDetails::firstOrNew(['user_id' =>  $id]); 
                $user_detail->address = $request->address;  
                $user_detail->dob = $request->dob; 
                $user_detail->fax_no = $request->fax_no; 
                $user_detail->city = $request->city; 
                $user_detail->state = $request->state; 
                $user_detail->zipcode = $request->zipcode; 
                $user_detail->mobile = $request->mobile; 
                $user_detail->save();

                return redirect()->route('user.list')->with('status', 'success')->with('message', 'User details '.Config::get('constants.SUCCESS.UPDATE_DONE'));
            } catch ( \Exception $e ) { 
                return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
            }
        }
    }
    /* End Method update_record */

    /*
    Method Name:    change_password
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update password form
    Params:         [id]
    */
    public function change_password($id){
    	return view('admin.users.password', compact('id'));
    }
    /* End Method change_password */

    /*
    Method Name:    update_password
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update password of user
    Params:         [password, password_confirmation]
    */
    public function update_password(Request $request){
		$id = $request->edit_record_id;
		$request->validate([
			'password' => 'required_with:password_confirmation|string|confirmed',
        ], [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Confirmed Password not matched with password'
        ]);
    	try {
        	$data = [
        		'password' => bcrypt($request->password),
        		'updated_at' => date('Y-m-d H:i:s')
            ];
			$record = User::where('id', $id)->update($data);
        	return redirect()->route('user.list')->with('status', 'success')->with('message', 'User password '.Config::get('constants.SUCCESS.UPDATE_DONE'));

        } catch ( \Exception $e ) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    /* End Method update_password */ 
    
    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To get detail of user
    Params:         [id]
    */
    public function view_detail($id,Request $request){
        $userDetail = User::role('User')->find($id);
        
        if(!$userDetail)
            return redirect()->route('user.list');

        return view('admin.users.view_detail',compact('userDetail'));
    }
    /* End Method view_detail */

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To change the status of user[active/inactive]
    Params:         [id, status]
    */

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
        return response()->json(['success' => 'Status change successfully.','message' => 'User '.Config::get('constants.SUCCESS.STATUS_UPDATE')]);
    }
    
    /* End Method view_detail */
}