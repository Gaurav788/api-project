@extends('admin.layouts.adminlayout')
@section('body') 
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>User</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="{{route('user.list')}}">User</a></li>
						<li class="breadcrumb-item active">Update Password</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<!-- .flash-message -->  
	@alert @endalert  
	<!--/ end .flash-message -->

    <!-- Main content -->
    <section class="content"> 
    	<!-- Default box .card-->
		<div class="card"> 
			<div class="card-header">
				Update Password
			</div>
			<form action="{{route('user.updatepassword')}}" method="post" class="user" id="update_password_form" >
			@csrf	
				<div class="card-body">
					<input type="hidden" name="edit_record_id" value="{{$id}}">
					<div class="row">
						<div class="col-lg-4 col-md-6 col-12">
							<div class="form-group">
								<label>Password<span class="required">*</span></label>
								<input type="password" name="password" id="password" value="{{old('password')}}" class="form-control form-control-user"  />
								@if ($errors->has('password'))
								<span class="text-danger">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6 col-12">
							<div class="form-group">
								<label>Confirm Password<span class="required">*</span></label>
								<input type="password" name="password_confirmation" id="password_confirmation" value="{{old('password_confirmation')}}" class="form-control form-control-user"  />
								@if ($errors->has('password_confirmation'))
								<span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
								@endif
							</div>
						</div>
					</div> 
				</div>
				<!-- /.card-body -->
				<div class="card-footer">
					<div class=" btn-group">
						<button type="submit" id="save-membershipplan-btn" class="btn bg-gradient-info">Update Password</button>&nbsp
						<a href="{{route('user.list')}}" class="btn bg-gradient-danger">Cancel</a>
					</div>
				</div>
			</form>
		</div>  
		<!--Default box /.card --> 
    </section>
    <!--Main content /.content -->  
@endsection
@section('scripts')
	<script>
		$( document ).ready(function() {
			$("form[id='update_password_form']").validate({
				// Specify validation rules
				rules: {
					password : {
						required: true,
						minlength : 6
					},
					password_confirmation : {
						required: true,
						equalTo : "#password"
					}
				},
				// Specify validation error messages
				messages: {
					password: {
						required: 'Password field is required',
						minlength: 'Please enter minimum 6 length password'
					},
					password_confirmation: {
						required: 'Confirm Password field is required',
						equalTo : "Confirm Password must be same as password"
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
@stop