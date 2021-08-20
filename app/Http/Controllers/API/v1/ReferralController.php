<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Referral;
use Validator;
use App\Traits\SendResponseTrait;

class ReferralController extends Controller
{
	use SendResponseTrait;
	public function save_referral(Request $request)
	{
		if ($request->isMethod('post')) {
			$rules = [
			'contact' => 'required|string',
			'referral_name' => 'required|string',
			'referral_contact' => 'required|string',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json([
				'message'=>$validator->errors(),
			], '422');
		}	
		try
		{
			$referral = new Referral();
			$referral->user_id = $request->user_id;
			$referral->ic = $request->ic;
			$referral->contact = $request->contact;
			$referral->referral_contact = $request->referral_contact;
			$referral->referral_name = $request->referral_name;
			$referral->location = $request->location;
			$referral->mobile_mac_id = $request->mobile_mac_id;
			$referral->app = $request->app;
			$referral->jason_pull_contact = $request->jason_pull_contact;
			$referral->save();
			return $this->apiResponse('success', '200', 'Data saved', $referral);
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



