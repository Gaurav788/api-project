
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Solardrop') }}</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ asset('frontend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('frontend/css/adminlte.min.css') }}"> 
	<!-- Custom style -->
	<link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<a href="{{ url('/') }}" class="text-primary"><b>{{ config('app.name', 'Solardrop') }}</b></a>
	</div>
	<!-- /.login-logo -->
	<div class="card card-outline card-primary">
		<div class="card-body login-card-body">
            <form method="POST" action="{{ route('passwordreset') }}" id="passwordreset_form">
			@csrf
				<div class="flash-message"> 
					@if(session()->has('status'))
						@if(session()->get('status') == 'success')
							<div class="alert alert-success  alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
							</div>
						@endif
						@if(session()->get('status') == 'error')
							<div class="alert alert-danger  alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
							</div>
						@endif
					@endif
				</div> 
                <div class="form-group row">
                    <label for="email" class=" col-form-label text-md-right">Email Address</label> 
                </div>
                <div class="form-group row">  
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus> 
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                </div> 
                <div class="form-group "> 
                    <button type="submit" class="btn btn-primary btn-block">
                        Send Password Reset Link
                    </button>
                    <a class="btn btn-link" href="{{ route('login') }}">
                        Log in
                    </a> 
                </div>
            </form>
		</div>
		<!-- /.login-card-body -->
	</div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('frontend/js/adminlte.min.js') }}"></script>
<!-- Validate Form -->
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script> 
<script>
$( document ).ready(function() {
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
		submitHandler: function(form) {
			form.submit();
		}
	});
});
</script>
</body>
</html>
