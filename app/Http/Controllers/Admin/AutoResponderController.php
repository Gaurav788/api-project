<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\AutoResponder;
use DB;

class AutoResponderController extends Controller
{
    function __construct(){
        
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To get all added templates
    Params:         
    */
    public function getList(Request $request)
    {
        $data = AutoResponder::when($request->search_keyword, function ($q) use ($request){
            $q->where('template_name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('template', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword);
        })
            ->sortable(['id' => 'desc'])
            ->paginate(Config::get('constants.PAGINATION_NUMBER'));
        return view('admin.autoresponder.list', compact('data'));
    }
    /* End Method getList */

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Form to add new template
    Params:         
    */
    public function add_form(){
        return redirect()->route('autoresponder.list');
        return view('admin.autoresponder.add');
    }
    /* End Method add_form */

    /*
    Method Name:    create_record
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To add new template detailsinto database
    Params:         [subject, template_name, template, status]

    */
    public function create_record(Request $request){
        return redirect()->route('autoresponder.list');
        $request->validate(['subject' => 'required|max:200', 'template_name' => 'required|max:200', 'template' => 'required', 'status' => 'required']);
        try {
            $record = AutoResponder::create($request->all());
            if ($record) {
                $routes = ($request->action == 'saveadd') ? 'autoresponder.add' : 'autoresponder.list';
                return redirect()
                    ->route($routes)->with('status', 'success')
                    ->with('message', 'Auto responder template ' . Config::get('constants.SUCCESS.CREATE_DONE'));
            }
            return redirect()
                    ->back()->with('status', 'error')
                    ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch(\Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }
    /* End Method create_record */

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        Form to update template details
    Params:         [id]
    */
    public function edit_form($id){
        $record = AutoResponder::find($id);
        if(!$record)        
        return redirect()->route('autoresponder.list');
        return view('admin.autoresponder.edit', compact('record'));
    }
    /* End Method edit_form */

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To update template details 
    Params:         [edit_record_id, subject, template_name, template, status]
    */
    public function update_record(Request $request){
        $request->validate(['subject' => 'required|max:200', 'template' => 'required']);
        try {
            $data = [
                'subject' => $request->subject,
                'template' => $request->template
            ];
            $record = AutoResponder::where('id', $request->edit_record_id)
                ->update($data);
            return redirect()->route('autoresponder.list')
                ->with('status', 'success')
                ->with('message', 'Auto responder template ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch(\Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }
    /* End Method update_record */

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To delete the template
    Params:         [id]
    */
    public function del_record($id){
        return redirect()->route('autoresponder.list');
        try {
            AutoResponder::where('id', $id)->delete();
            return redirect()
                ->back()
                ->with('status', 'success')
                ->with('message', 'Auto responder template ' . Config::get('constants.SUCCESS.DELETE_DONE'));
        } catch(Exception $ex) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $ex->getMessage());
        }
    }
    /* End Method del_record */

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-08-19 (yyyy-mm-dd)
    Purpose:        To change the status of template by id
    Params:         [id, status]
    */
    public function change_status(Request $request) {
        return redirect()->route('autoresponder.list'); 
        $autoresponder = AutoResponder::find($request->id);
        $autoresponder->status = $request->status;
        $autoresponder->save();
        return redirect()
            ->back()
            ->with('status', 'success')
            ->with('message', 'Auto responder template ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
    /* End Method change_status */
}