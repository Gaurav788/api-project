<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{User, Loan, UserProfile, UserDocument};
use Validator;
use App\Traits\SendResponseTrait;


class LoanController extends Controller
{
	use SendResponseTrait;

	public function saveLoan(Request $request)
	{
		if ($request->isMethod('post')) {
			$rules = [
				'first_name' => 'required|string',
				'last_name' => 'required|string',
				'email' => 'required|string',
				'ic' => 'required|string',
				'contact' => 'required|string',
				'facebook' => 'required|string',
				'address' => 'required|string',
				'loan_purpose' => 'required|string',
			];
			
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json([
					'message'=>$validator->errors(),
				], '422');
			}	
			try
			{
				$userfecth = User::where('email', $request->email)->first();
				$icNumber = $icNumberString = NULL;
				
				if($request->ic)
				{
					$icNumberString = str_replace('-', '', $request->ic);
					$icNumberString = str_replace(' ', '', $icNumberString);
					$icNumber = $icNumberString;
				}
				if($icNumberString && (strlen($icNumberString) > 8)){
					$icNumberfirst = substr($icNumberString, 0, 6); 
					$icNumberSecond = substr($icNumberString, 6, 2);
					$icNumberRemaning = substr($icNumberString, 8);
					$icNumber = $icNumberfirst.'-'.$icNumberSecond.'-'.$icNumberRemaning;
				} elseif($icNumberString && (strlen($icNumberString) > 6)){
					$icNumberfirst = substr($icNumberString, 0, 6); 
					$icNumberRemaning = substr($icNumberString, 6);
					$icNumber = $icNumberfirst.'-'.$icNumberRemaning;
				}
				if($userfecth){
					$user_id = $userfecth->id;
					
					$data = [
						'ic' => $icNumber,
						'contact' => $request->contact,
						'facebook' => $request->facebook,
						'address' => $request->address,
						'father_name' => $request->father_name,
						'father_contact' => $request->father_contact,
						'mother_name' => $request->mother_name,
						'mother_contact' => $request->mother_contact,
						'wife_husband_name' => $request->wife_husband_name,
						'wife_husband_contact' => $request->wife_husband_contact,
						'sibling_name' => $request->sibling_name,
						'sibling_contact' => $request->sibling_contact,
						'company_name' => $request->company_name,
						'company_contact' => $request->company_contact,
						'company_address' => $request->company_address,
						'colleauge_name' => $request->colleauge_name,
						'colleauge_contact' => $request->colleauge_contact,
						'mobile_mac_id' => $request->mobile_mac_id,
						'location' => $request->location,
						'app' => $request->app,
						'jason_pull_contact' => $request->jason_pull_contact ? json_encode($request->jason_pull_contact) : NULL
					];
					
					UserProfile::where('user_id', $user_id)->update($data);
				}
				else{
					$user = new User();
					$user->first_name = $request->first_name;
					$user->last_name = $request->last_name;
					$user->email  = $request->email ;
					$user->password = '$2y$10$aYheEf4KViVX8jsH6/jvNe.eFXkxZhICk3K37WXcCU0jqKGfSug2S';
					$user->supirior_id = '0';
					$user->group_id  = '2' ;
					$user->status = '0';
					$user->save();
					$user_id = $user->id;

					$UserProfile = new UserProfile();
					$UserProfile->user_id = $user_id;
					$UserProfile->ic = $icNumber;
					$UserProfile->contact = $request->contact;
					$UserProfile->facebook = $request->facebook;
					$UserProfile->address = $request->address;
					$UserProfile->father_name = $request->father_name;
					$UserProfile->father_contact = $request->father_contact;
					$UserProfile->mother_name = $request->mother_name;
					$UserProfile->mother_contact = $request->mother_contact;
					$UserProfile->wife_husband_name = $request->wife_husband_name;
					$UserProfile->wife_husband_contact = $request->wife_husband_contact;
					$UserProfile->sibling_name = $request->sibling_name;
					$UserProfile->sibling_contact = $request->sibling_contact;
					$UserProfile->company_name = $request->company_name;
					$UserProfile->company_contact = $request->company_contact;
					$UserProfile->company_address = $request->company_address;
					$UserProfile->colleauge_name = $request->colleauge_name;
					$UserProfile->colleauge_contact = $request->colleauge_contact;
					$UserProfile->mobile_mac_id = $request->mobile_mac_id;
					$UserProfile->location = $request->location;
					$UserProfile->app = $request->app;
					$UserProfile->jason_pull_contact = $request->jason_pull_contact ? json_encode($request->jason_pull_contact) : NULL;
					$UserProfile->save();
				}

				$loan = new Loan();
				$loan->user_id = $user_id;
				$loan->loan_purpose = $request->loan_purpose;
				$loan->requested_loan_amount = $request->requested_loan_amount;
				$loan->issue_loan_amount = $request->issue_loan_amount;
				$loan->return_amount = $request->return_amount;
				$loan->issue_date = $request->issue_date;
				$loan->emi_interval = $request->emi_interval;
				$loan->no_of_emi = $request->no_of_emi;
				$loan->emi_started_at = $request->emi_started_at;
				$loan->remarks = $request->remarks;
				$loan->status = $request->status;
				$loan->save();

				if($request->has('bill')){
					$info = [
						'user_id' => $user_id,
						'loan_id' => $loan->id,
						'name' => 'Utility bill',
						'document_type' => 'png',
						'documents' => $request->bill,
					];
					UserDocument::create($info);
				}
				if($request->has('selfie')){
					$info = [
						'user_id' => $user_id,
						'loan_id' => $loan->id,
						'name' => 'Selfie',
						'document_type' => 'png',
						'documents' => $request->selfie,
					];
					UserDocument::create($info);
				}
				
				return $this->apiResponse('success', '200', 'Data saved');
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


