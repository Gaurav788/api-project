
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
            </div> <!-- end .flash-message -->

            <form method="POST" action="{{ route('userupdatenewpassword') }}" id="passwordreset_form">
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

                <div class="form-group ">
                    <label for="password" class=" col-form-label text-md-right">{{ __('New Password') }}</label> 
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('email') }}" autocomplete="email" autofocus>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                </div>
                <div class="form-group ">
                    <label for="password_confirmation" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label> 
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('cpassword') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="email" autofocus>
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror 
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 ">
                        <button type="submit" class="btn btn-primary">
                            Set Password
                        </button>
                    </div>
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
                    equalTo : "Confirm Password must be same as new password"
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
