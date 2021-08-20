@extends('admin.layouts.adminlayout')
@section('body')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
    <div class="row mb-4 ml-1">
        <div class="card h-100">
            <div class="card-body">
                <form class="navbar-search" id="search-form">
                    <div class="input-group">
                        <input type="text" id="daterange_filter" value="{{$daterange}}" name="daterange_filter" class="form-control bg-light border-1 small" placeholder="Select Date"
                        aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-md btn-default" type="submit">
                                <i class="fa fa-search fa-sm"></i>
                            </button>
                        </div>
                        <div class="input-group-append">
                            <a title="Reset" href="{{route('admindashboard')}}" class="btn btn-md btn-info" >
                                <i class="fa fa-redo" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $userCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Active Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeUserCount }}</div>
                            
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection