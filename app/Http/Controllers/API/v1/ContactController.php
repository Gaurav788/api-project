<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use Validator;
use App\Traits\SendResponseTrait;


class ContactController extends Controller
{
	use SendResponseTrait;

	public function saveContacts(Request $request)
	{
		if ($request->isMethod('post')) {
			$rules = [
			'ic' => 'required|string',
			'contact' => 'required|string',
			
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json([
				'message'=>$validator->errors(),
			], '422');
		}	
		try
		{
			$contact = Contact::where('ic', $request->ic)->first();
			if($contact){
				$contact->contact = $request->contact;
				$contact->save();
			}
			else{
				$contact = new Contact();
				$contact->ic = $request->ic;
				$contact->contact = $request->contact;
				$contact->save();
			}
			return $this->apiResponse('success', '200', 'Data saved', $contact);
		}
			catch (\Exception $e)
			{
				
				return $this->apiResponse('success', '422', $e->getMessage());
			}

		}
		else
		{
			return $this->apiResponse('success', '422', 'Method is not allowed');
		}


	}

}


