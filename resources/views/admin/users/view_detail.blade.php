@extends('admin.layouts.adminlayout')
@section('body') 
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">User</h1>
		<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{route('user.list')}}">User</a></li>
		<li class="breadcrumb-item active">User Detail</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-lg-12">
              <!-- Form Basic -->
			<div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">User Detail</h6>
                </div>
                <div class="card-body">
				<div class="row">
					<div class="col-xl-6 col-md-6">
						<div class="card shadow">
							<div class="card-body"> 
								<ul class="list-group">
									<li class="list-group-item d-flex align-items-center">
										<span class="shadow-title"><strong>User Name</strong></span>
										<h5><span class="badge  badge-pill">{{ucfirst($userDetail->first_name) ." ".ucfirst($userDetail->last_name)}}</span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>Email</strong></span>
										<h5><span class="badge  badge-pill">{{$userDetail->email}}</span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>Contact</strong></span>
										<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->mobile) ? $userDetail->user_detail->mobile : "N/A"}}</span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>Fax No.</strong></span>
										<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->fax_no) ? $userDetail->user_detail->fax_no :"N/A"}} </span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>Status</strong></span>
										@if($userDetail->status == "1")
											<h5><span class="badge badge-success badge-pill">Active</span></h5>
										@else
											<h5><span class="badge badge-danger  badge-pill">Inactive</span></h5>
										@endif
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-md-6">
						<div class="card shadow">
							<div class="card-body">
								<ul class="list-group">
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>Address</strong></span>
										<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->address) ? $userDetail->user_detail->address :"N/A"}}</span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>City</strong></span>
										<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->city) ? $userDetail->user_detail->city :"N/A"}}</span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>State</strong></span>
										<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->state) ? $userDetail->user_detail->state :"N/A"}}</span></h5>
									</li>
									<li class="list-group-item d-flex align-items-center">
									<span class="shadow-title"><strong>Zipcode</strong></span>
										<h5><span class="badge  badge-pill">{{isset($userDetail->user_detail->zipcode)? $userDetail->user_detail->zipcode :"N/A"}}</span></h5>
									</li>
								</ul>
							</div>
						</div> 
					</div>
				</div> 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 