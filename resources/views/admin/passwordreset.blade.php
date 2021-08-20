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
		<form method="POST" action="{{ route('sendpasswordemail') }}" id="passwordreset_form" > 
		@csrf
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
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  id="inputSuccess" name="email" value="{{ old('email') }}" autocomplete="email" autofocus> 
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-envelope"></span>
					</div>
				</div>
				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>  
            <label id="email-error" class="error" for="email"></label> <br/>
                <a class="btn btn-light" href="{{ route('admin') }}">
                    {{ __('Login') }}
                </a> 
                <button type="submit" class="btn btn-info float-right">{{ __('Send Password Reset Link') }}</button>  
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
	$(document).ready(function() {
		$("form[id='passwordreset_form']").validate({
			// Specify validation rules
			rules: {
				email: {
					required: true,
					email: true
				}
			},
			// Specify validation error messages
			messages: {
				email: {
					required: 'Email address is required',
					email: 'Provide a valid Email address',
				}
			},
			errorElement : 'label',
			submitHandler: function(form) {
				form.submit();
			}
		});
	});
</script>
</body>
</html> 