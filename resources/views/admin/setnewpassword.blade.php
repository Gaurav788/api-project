<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Freight Management') }}</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('backend/css/adminlte.min.css') }}"> 
	<!-- Custom style -->
	<link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="{{ url('/') }}" class="text-info"><b>{{ config('app.name', 'Freight Management') }}</b></a>
		</div>
		<!-- /.login-logo -->
		<div class="card card-outline card-info">
			<div class="card-body login-card-body">
				<p class="login-box-msg"><h5>{{ __('Reset Password') }}</h5></p>
				<form method="POST" action="{{ route('updatenewpassword') }}" id="passwordreset_form">@csrf
					<!--.flash-message -->
					<div class="flash-message"> 
						@if(session()->has('status'))
							@if(session()->get('status') == 'Success')
								<div class="alert alert-success  alert-dismissible">
									<a class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
								</div>
							@endif
							@if(session()->get('status') == 'Error')
								<div class="alert alert-danger  alert-dismissible">
									<a class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
								</div>
							@endif
						@endif
					</div>
					<!--/ end .flash-message --> 
					<div class="input-group mb-3"> 
						<input  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="password" autofocus>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-key"></span>
							</div>
						</div> 
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="input-group mb-3"> 
						<input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="email" autofocus>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-key"></span>
							</div>
						</div>  
						@error('password_confirmation')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>  
					<label id="email-error" class="error" for="email"></label> <br/> 
						<button type="submit" class="btn btn-info float-right">{{ __('Set Password') }}</button>  
				</form> 
				<!-- /.social-auth-links --> 
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('backend/js/adminlte.min.js') }}"></script>
	<!-- Validate Form -->
	<script src="{{ asset('backend/js/jquery.validate.min.js') }}"></script> 
	<script>
		$( document ).ready(function() {
			$("form[id='passwordreset_form']").validate({
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
				errorPlacement: function(error, element) {
					var placement = $(element).data('error');
					if (placement) {
						$(placement).append(error)
					} else {
						error.insertAfter(element.parent());
					}
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
	</script>
</body>
</html>