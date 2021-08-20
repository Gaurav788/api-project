<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Freight Management') }}</title>
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
		<a href="{{ url('/') }}" class="text-primary"><b>{{ config('app.name', 'Freight Management') }}</b></a>
	</div>
	<!-- /.login-logo -->
	<div class="card card-outline card-primary">
		<div class="card-body login-card-body">
		<p class="login-box-msg"><h5>{{ __('Login') }}</h5></p> 
		<div class="" id="status" ></div> 
            <form class="form" method="POST" action="{{ route('login') }}" id="login_form">@csrf
               	<!-- .flash-message -->  
                @alert @endalert  
                <!--/ end .flash-message -->
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block" id="sign_in">
                            LOG IN
                        </button>
                        
                        <!-- <button class="btn btn-custom"> -->
                            <a href="{{ route('password.reset') }}" class="font-fourteen">Forgot my password</a>
                        <!-- </button> -->										
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
		submitHandler: function(form) { 
            var formdata = jQuery("form[id='login_form']");
            var urls = formdata.prop('action');
            jQuery("#sign_in").html('LOG IN <i class="fa fa-spinner fa-spin"></i>');
            jQuery("#sign_in").attr("disabled", true);
            jQuery.ajax({
                type: "POST",
                url: urls,
                data: formdata.serialize(), 
                success:function(data){ 
                    let result = JSON.parse(data);  
                    if (result.success == true)
                    {
                        location.href = result.message;  
                    } else if(result.success == false){
                        jQuery("#status").html('<div class="alert alert-danger  alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message+'</div>');
                        jQuery("#sign_in").html('LOG IN');
                        jQuery("#sign_in").attr("disabled", false);
                    } 
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    
                    if (jqXHR.status === 302) {
                        swal({
                            title: "Warning",
                            text: "Session timeout!",
                            icon: "warning",
                        });
                        window.location.reload();
                    }
                    else if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        var errors = jQuery.parseJSON(jqXHR.responseText);
                        var erro = '';
                        jQuery.each(errors['errors'], function(n, v) {
                            erro += '<p class="inputerror">' + v + '</p>';
                        });
                        jQuery("#sign_in").html('LOG IN');
                        jQuery("#sign_in").attr("disabled", false);
                        jQuery("#status").html('<div class="alert alert-danger alert-dismissible hidden"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+erro+'</div>');
                        jQuery("#errorsinfo").html(erro);
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.info(msg);
                }  
            }); 
		}
	});
});
</script>
</body>
</html>