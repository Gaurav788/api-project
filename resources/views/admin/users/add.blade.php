@extends('admin.layouts.adminlayout')
@section('body') 
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">User</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="{{route('user.list')}}">User</a></li>
			<li class="breadcrumb-item active">Add User</li>
		</ol>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
			@alert @endalert 
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">User Add</h6>
			</div>
			<div class="card-body">
			
			<form action="{{route('user.create')}}" method="post" class="user" id="edit_user_form" enctype="multipart/form-data">@csrf
				<div class="row">
				
				<div class="col-sm-8 col-md-8 col-lg-8 col-12">
				<div class="user-section">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						<div class="form-group">
							<label>First Name<span class="required">*</span>
							</label>
							<input type="text" name="first_name" id="first_name" value="{{old('first_name')}}" class="form-control form-control-user" />
							@if ($errors->has('first_name'))
								<span class="text-danger">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Last Name<span class="required">*</span>
						</label>
						<input type="text" name="last_name" id="last_name" value="{{old('last_name')}}" class="form-control form-control-user" />
						@if ($errors->has('last_name'))
							<span class="text-danger">{{ $errors->first('last_name') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Email<span class="required">*</span>
						</label>
						<input type="text" name="email" id="email"  value="{{old('email')}}" class="form-control form-control-user"/>
						@if ($errors->has('email'))
							<span class="text-danger">{{ $errors->first('email') }}</span>
						@endif
					</div>
				</div> 
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Mobile<span class="required">*</span>
						</label>
						<input type="number" class="form-control form-control-user" minlength="10" maxlength="10" name="mobile" id="mobile" placeholder="Mobile" value="{{old('mobile')}}" />
						@if ($errors->has('mobile'))
							<span class="text-danger">{{ $errors->first('mobile') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Date of Birth<span class="required">*</span>
						</label>
						<input type="text" class="form-control form-control-user" name="dob" id="dob" placeholder="Date of birth" value="{{old('dob')}}" readonly/>
						@if ($errors->has('dob'))
							<span class="text-danger">{{ $errors->first('dob') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Fax No.
						</label>
						<input type="number" class="form-control form-control-user" name="fax_no" id="fax_no" placeholder="Fax No." value="{{old('fax_no')}}"/>
						@if ($errors->has('fax_no'))
							<span class="text-danger">{{ $errors->first('fax_no') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-12">
					<div class="form-group">
						<label>Address<span class="required">*</span>
						</label>
						<textarea rows="3" class="form-control form-control-user" name="address" id="address" placeholder="Address"></textarea> 
						@if ($errors->has('address'))
							<span class="text-danger">{{ $errors->first('address') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>City<span class="required">*</span>
						</label>
						<input type="text" class="form-control form-control-user"  name="city" id="city" placeholder="City" value="{{old('city')}}" />
						@if ($errors->has('city'))
							<span class="text-danger">{{ $errors->first('city') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>State<span class="required">*</span>
						</label>
						<input type="text" class="form-control form-control-user"  name="state" id="state" placeholder="State" value="{{old('state')}}" />
						@if ($errors->has('state'))
							<span class="text-danger">{{ $errors->first('state') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Zipcode<span class="required">*</span>
						</label>
						<input type="text" class="form-control form-control-user" name="zipcode" id="zipcode" placeholder="Zipcode" value="{{old('zipcode')}}" />
						@if ($errors->has('zipcode'))
							<span class="text-danger">{{ $errors->first('zipcode') }}</span>
						@endif
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="form-group">
						<label>Status<span class="required">*</span></label>
						<div class="input-group">  
							<input type="checkbox" {{ old('status') ? 'checked' : ''}}  data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" name="status">
						</div>
						@if ($errors->has('status'))
						<span class="text-danger">{{ $errors->first('status') }}</span>
						@endif
					</div> 
				</div> 
				<div class=" btn-group">
				<button type="submit" class="btn btn-success">Update </button>&nbsp
				<a href="{{route('user.list')}}" class="btn btn-danger">Cancel</a>
				</div>
			 </div>
			 </div>
				</div>

			</div>

			</form>
		</div>
		</div>
	</div>
          
</div>
@endsection  
@section('scripts')
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(function() {
		var today = new Date();
			$("#dob").datepicker({
			maxDate : 0,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			});
		});
	</script>
	<script>
		$( document ).ready(function() {
			$("form[id='edit_user_form']").validate({
				// Specify validation rules
				ignore: '',
				rules: {
					first_name: {
						required: true, 
						lettersonly: true,
					}, 
					last_name: {
						required: true,
						lettersonly: true, 
					},
					email: {
						required: true,
						email: true, 
					},
					address: {
						required: true, 
					},
					city: {
						required: true,  
					},
					state: {
						required: true,  
					},
					dob : { 
						required: true, 
					},
					zipcode : {  
						required: true, 
						maxlength: 12,
						minlength: 6,
					},
					fax_no : { 
						number : true , 
						maxlength: 12,
						minlength: 6,
					},
					mobile : { 
						required: true,
						number : true , 
						maxlength: 12,
						minlength: 10,
					}, 
				},
				// Specify validation error messages
				messages: {
					first_name: {
						required: 'First name field is required', 
						lettersonly: 'First name should contains letters only',
					},  
					last_name: {
						required: 'Last name field is required', 
						lettersonly: 'Last name should contains letters only',
					}, 
					email: {
						required: 'Email field is required',
						email: 'Provide a valid email ',
					},  
					address: {
						required: 'Address field is required',
					},  
					city: {
						required: 'City field is required',
					},  
					state: {
						required: 'State field is required',
					}, 
					dob: {
						required: 'Date field is required', 
					}, 
					fax_no: {
						number: 'Fax number should contains numbers only', 
						maxlength: 'Fax number should be of 6 to 12 digit',
						minlength: 'Fax number should be of 6 to 12 digit'
					}, 
					zipcode: { 
						required: 'Zipcode field is required', 
						maxlength: 'Zipcode should be of 6 to 12 digit',
						minlength: 'Zipcode should be of 6 to 12 digit'
					}, 
					mobile: {
						required: 'Mobile number field is required',
						number: 'Mobile number should contains numbers only',
						maxlength: 'Mobile number should be of 10 to 12 digit',
						minlength: 'Mobile number should be of 10 to 12 digit'
					}, 
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
@stop