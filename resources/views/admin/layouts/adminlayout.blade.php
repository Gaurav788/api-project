<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'ShineDezign Api Management') }} Admin</title>
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="baseurl" content="{{url('')}}">
 
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/css/adminlte.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('backend/plugins/daterangepicker/daterangepicker.css')}}"> 
	<!-- Custom style -->
	<link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('backend/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script> 
</head>

<body  class="hold-transition layout-fixed sidebar-mini layout-footer-fixed">
    @if(Auth::user())
        @php
            $user = Auth::user(); 
        @endphp
    @endif
    @section('header')
    <div id="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img  src="{{asset('backend/img/loader.gif')}}" alt="Freight Management" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('admindashboard')}}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto"> 
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        @php
                            $userdata = session()->get('userdetails');
                        @endphp
                        @if(session()->has('userdetails') && !empty($userdata['profile_picture']))  
                                <img  class="user-image img-circle elevation-3" alt="User Image" src="{{ 'data:image/' .$userdata['imagetype']. ';base64,' .base64_encode($userdata['profile_picture']) }}">
                        @else
                            <img  class="user-image img-circle elevation-3" alt="User Image" src="{{asset('backend/img/dummyprofile.jpg')}}">
                        @endif 
                        <span class="d-none d-md-inline">{{ $user->first_name.' '.$user->last_name}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary"> 
                            @if(session()->has('userdetails') && !empty($userdata['profile_picture']))  
                                    <img  class="user-image img-circle elevation-3" alt="User Image" src="{{ 'data:image/' .$userdata['imagetype']. ';base64,' .base64_encode($userdata['profile_picture']) }}">
                            @else
                                <img  class="user-image img-circle elevation-3" alt="User Image" src="{{asset('backend/img/dummyprofile.jpg')}}">
                            @endif  
                            <p>
                                {{ $user->first_name.' '.$user->last_name}}
                                <small>Administrator</small>
                            </p>
                        </li> 
                        <!-- Menu Body -->
                        <li class="user-body">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile Setting
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changepassModal">
                                <i class="fa fa-key fa-sm fa-fw mr-2 text-gray-400"></i> Change Password
                            </a>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> --> 
                            <a  class="btn btn-default btn-flat float-right" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>{{ __('Logout') }}</a> 
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li> 
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo --> 
            <a href="{{route('admindashboard')}}" class="brand-link">
                <span class="brand-text font-weight-light">{{ config('app.name', 'ShineDezign Api Management') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admindashboard')}}" class="nav-link {{ Route::currentRouteName() == 'admindashboard' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a> 
                    </li>
                    <li class="nav-item">
                        <a href="{{route('user.list')}}" class="nav-link {{ Route::is('user.*')  ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users<!-- <span class="right badge badge-danger">New</span> --></p>
                        </a>
                    </li>  
                    </ul>
                </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside> 
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper"> 
            @show @section('body')   
            @show @section('footer')
        </div> 
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{now()->year}}, {{ config('app.name', 'ShineDezign Api Management') }}</strong> 
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
 
    <!-- Profile Popup model -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleDepP">Update Profile</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="user" action="{{ route('details.update') }}" id="modalProfileSubmit"
                    enctype="multipart/form-data">@csrf
                    <div class="modal-body">
                        <div id="successMsgP" class="hidden"></div>
                        <div id="errorsDeprtP" class="hidden"></div>
                        <input type="hidden" name="adminid" value="@if(Auth::user()){{ $user->id }}@endif">
                        <div class="form-group">
                            <input type="email" name="adminemail" id="adminemail"
                                value="@if(Auth::user()){{ $user->email }}@endif" class="form-control form-control-user"
                                placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="text" name="first_name" id="profilename"
                                value="@if(Auth::user()){{ $user->first_name }}@endif"
                                class="form-control form-control-user" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" id="profilemail"
                                value="@if(Auth::user()){{ $user->last_name }}@endif"
                                class="form-control form-control-user" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <input type="file" name="profile_pic" id="profile_pic"
                                class="form-control form-control-user">
                        </div>
                        <div class="form-group">
                            @if(session()->has('userdetails'))
                                @if($userdata['profile_picture'])
                                <img class="img-profile rounded-circle"
                                    src="{{ 'data:image/' .$userdata['imagetype']. ';base64,' .base64_encode($userdata['profile_picture']) }}">
                                @else
                                    <img class="img-profile rounded-circle" src="{{asset('backend/img/dummyprofile.jpg')}}">
                                @endif
                            @else
                                <img class="img-profile rounded-circle" src="{{asset('backend/img/dummyprofile.jpg')}}">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="savedBtnP">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end Profile Popup model -->
    <!-- Change PassWord Model -->
    <div class="modal fade" id="changepassModal" tabindex="-1" role="dialog" aria-labelledby="changepassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleDepP">Change Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="user" action="{{ route('password.update') }}" id="modalchangepassSubmit">@csrf
                    <div class="modal-body">
                        <div id="successMsgPass"></div>
                        <div id="errorsDeprtPass"></div>
                        <div class="form-group">
                            <input type="password" name="oldpassword" id="oldpassword"
                                class="form-control form-control-user" placeholder="Enter Old Password!" required />
                        </div>
                        <div class="form-group">
                            <input type="password" name="newpassword" id="newpassword"
                                class="form-control form-control-user" placeholder="Enter New Password!" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="savedBtnPass">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Change PassWord model -->
    @show
    <script>
        var baseurl = $('meta[name="baseurl"]').prop('content');
        var token = $('meta[name="csrf-token"]').prop('content');
    </script>
    
    @yield('scripts')
    <!-- .Daterange Scripts -->  
	@daterangeScipts @enddaterangeScipts  
	<!--/ end .Daterange Scripts -->
        
    <!-- jQuery -->
    <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('backend/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('backend/js/adminlte.js')}}"></script>
    <!-- sweet alert Popups purposes -->
	<script src="{{asset('backend/js/sweetalert.min.js')}}"></script> 
    <!-- SweetAlert2 -->
    <script src="{{asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script> 
    <!-- Select2 -->
    <script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>
 
	<script src="https://cdn.tiny.cloud/1/g2adjiwgk9zbu2xzir736ppgxzuciishwhkpnplf46rni4g8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script>
		tinymce.init({
		selector: 'textarea.editor',
		plugins: 'code',
		toolbar: 'code',
		content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
		});
	</script>  

    <script src="{{asset('backend/js/jquery.validate.min.js')}}"></script> 
    <script src="{{asset('backend/js/custom.js')}}?{{get_timestamp()}}"></script>
    
    <!-- sweet alert Popups purposes -->
	<script src="{{asset('backend/js/sweetalert.min.js')}}"></script> 

    <!-- http://www.bootstraptoggle.com -->
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>   @yield('scriptsanalyses')
    <!-- ChartJS -->
    <script src="{{asset('backend/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <!-- <script src="{{asset('backend/plugins/sparklines/sparkline.js')}}"></script> -->
    <!-- JQVMap -->
    <!-- <script src="{{asset('backend/plugins/jqvmap/jquery.vmap.min.js')}}"></script> -->
    <!-- <script src="{{asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> -->
    <!-- jQuery Knob Chart -->
    <!-- <script src="{{asset('backend/plugins/jquery-knob/jquery.knob.min.js')}}"></script> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
 
    <!-- overlayScrollbars -->
    <!-- <script src="{{asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{asset('backend/js/demo.js')}}"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('backend/js/pages/dashboard.js')}}"></script> 
</body>

</html>