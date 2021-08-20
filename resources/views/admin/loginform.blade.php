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
	<div class="card card-outline card-primary">
		<div class="card-body login-card-body">
			<p class="login-box-msg"><h5>{{ __('Login') }}</h5></p> 
			<form method="POST" action="{{ route('login.check') }}" id="login_form" >@csrf
				<!--.flash-message -->
				<div class="flash-message"> 
					@if(session()->has('status'))
						@if(session()->get('status') == 'Success')
							<div class="alert alert-success  alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
							</div>
						@endif
						@if(session()->get('status') == 'Error')
							<div class="alert alert-danger  alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
							</div>
						@endif
					@endif
				</div>
				<!--/ end .flash-message -->
				<div class="input-group mb-3">
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus> 
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
				<div class="input-group mb-3">
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
					@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="row">
					<div class="col-8">
						<div class="icheck-primary">
						
						</div>
					</div>
					<!-- /.col -->
					<div class="col-4">
						<button type="submit" class="btn btn-info btn-block">{{ __('Login') }}</button>
					</div>
					<!-- /.col -->
				</div>
			</form> 
			<!-- /.social-auth-links --> 
			<p class="mb-1">
				<a href="{{ route('resetpassword') }}">{{ __('Forgot Your Password?') }}</a>
			</p>
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
	$("form[id='login_form']").validate({
		// Specify validation rules
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
			}
		},
		// Specify validation error messages
		messages: {
			email: {
				required: 'Email address is required',
				email: 'Provide a valid Email address',
			},
			password: {
				required: 'Password is required',
				
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

