@extends('admin.layouts.adminlayout')
@section('body')  
<div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User List</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div>
		
          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
			  @alert @endalert  
                <div class="card-header py-3 ">
				<form class="form-inline float-left" id="search-form">
					<div class="input-group">
						<input type="search" class="form-control form-control-md" data-model="order" data-searchcoulnm="first_name,last_name,email" id="search_keyword" value="{{$keyword}}" name="search_keyword" placeholder="What are you looking for?">
						<input type="text" class="form-control" id="daterange_filter" value="{{$daterange}}" name="daterange_filter"  placeholder="Select Date" readonly>
						<div class="input-group-append">
							<button type="submit" class="btn btn-md btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
						<div class="input-group-append">
							<a title="Reset" href="{{route('user.list')}}" class="btn btn-md btn-info">
								<i class="fa fa-redo" aria-hidden="true"></i>
							</a>
						</div>
					</div> 
				</form>
				<div class="card-tools">
					<a  href="{{route('user.add')}}" class="btn btn-outline-success pull-right btn-block btn-flat"><i class="fa fa-plus"> </i> Add User </a> 
				</div>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
				  <thead>
						<tr>
							<th>@sortablelink('id', 'UID')</th>
							<th>@sortablelink('first_name', 'First Name')</th>
							<th>@sortablelink('last_name', 'Last Name')</th>
							<th>@sortablelink('email', 'Email')</th>
							<th>@sortablelink('status', 'Status')</th>
							<th>@sortablelink('created_at', 'Created Date')</th>
							<th>Action</th>
						</tr>
					</thead>
                   <tbody>
						@foreach($data as $key => $row) 
							<tr>
								<td>{{$row->id}}</td>
								<td>{{$row->first_name ? $row->first_name : 'N/A' }}</td>
								<td>{{$row->last_name ? $row->last_name : 'N/A' }}</td>
								<td>{{$row->email ? $row->email : 'N/A' }}</td>
								<td>
								    <input data-id="{{$row->id}}" class="toggle-class"  data-style="ios" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"  data-size="mini" data-on="Active" data-off="InActive ." {{ $row->status ? 'checked' : '' }}>
								</td>
								<td>{{$row->created_at ? change_date_format($row->created_at) : 'N/A'}}</td>
								<td  class="align-middle">  
									<div class="btn-group btn-group-sm"> 
										<a title="Edit" href="{{route('user.edit',[$row->id])}}" class="btn btn-info">
											<i class="fas fa-edit info" aria-hidden="true" ></i>
										</a>&nbsp
										<a title="Update Password" class="btn btn-secondary" href="{{route('user.changepassword',[$row->id])}}" >
											<i class="fas fa-key success" aria-hidden="true" ></i>
										</a>&nbsp
										<a title="View" href="{{route('user.details',[$row->id])}}" class="btn btn-primary">
											<i class="fas fa-eye primary" aria-hidden="true" ></i>
										</a>&nbsp
										@if($row->is_deleted == 0)
											<a title="Delete" href="{{route('user.delete',[$row->id])}}" class="btn btn-danger delete-confirm">
												<i class="fas fa-trash danger" aria-hidden="true" ></i>
											</a>
										@else
											<a title="Restore" href="{{route('user.restore',[$row->id])}}" class="btn btn-warning">
												<i class="fas fa-trash-restore success"></i>
											</a>
										@endif
									</div>
								</td>  
							</tr>
						@endforeach
						@if ($data->count() == 0)
							<tr>
								<td colspan="10" class="text-center text-danger">No record found.</td>
							</tr>
						@endif 
					</tbody>
                  </table>
                </div>
                <div class="card-footer">
				<div class="text-right"> 
					{{ $data->appends(request()->except('page'))->links() }}
					<p>
						Displaying {{$data->count()}} of {{ $data->total() }} user(s).
					</p>
				</div>
				</div>
              </div>
            </div>
          </div>
          <!--Row-->

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

    </div> 
@endsection 
@section('scripts') 
	<script>
		$(function() {
			$('.toggle-class').change(function() { 
				var status = $(this).prop('checked') == true ? 1 : 0; 
				var user_id = $(this).data('id'); 
				
				$.ajax({
					type: "GET",
					dataType: "json",
					url: baseurl+'/admin/user/changeStatus',
					data: {'status': status, 'user_id': user_id},
					success: function(data){
						// console.log(data.message) ;
						$(function() {
							var Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000
							});

							Toast.fire({
								icon: 'success',
								title: data.message,
							}) 
						})
					}
				});
			})
		})
	</script> 
@stop