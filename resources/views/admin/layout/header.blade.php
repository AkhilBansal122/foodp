<!doctype html>
<html lang="en">


<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('/public/admin/assets/images/favicon.png')}}" type="image/png" />
		
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--plugins-->
	<link href="{{asset('/public/admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
	<link href="{{asset('/public/admin/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />


	<link href="{{asset('/public/admin/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('/public/admin/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />


	<link href="{{asset('/public/admin/assets/plugins/input-tags/css/tagsinput.css')}}" rel="stylesheet" />

	<link href="{{asset('/public/admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{asset('/public/admin/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
		<!-- loader-->
        <link href="{{asset('/public/admin/assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('/public/admin/assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('/public/admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/public/admin/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('/public/admin/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('/public/admin/assets/css/icons.css')}}" rel="stylesheet">

	<link href="{{asset('/public/admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.0/css/font-awesome.css" />
	
	<title>Food</title>

	<style>
.img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
}

img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
</head>


<?php
$url = Request::segment(2);
?>
<body class="bg-theme bg-theme1">
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{asset('/public/admin/assets/images/logo-icon.png')}}" alt="logo icon">
				</div>
				
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
			
			@if(auth()->user()->is_admin==1)
				<li class="@if($url=='dashboard')  mm-active  @endif ">
					<a href="{{url('admin/dashboard')}}">
						<div class="parent-icon"><i class="bx bx-tachometer" aria-hidden="true"></i>

						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li  class="@if($url=='customer') mm-active @endif ">
					<a href="{{route('admin/customer')}}">
						<div class="parent-icon"><i class="bx bx-user" aria-hidden="true"></i></div>
						<div class="menu-title">User Manager</div>
					</a>
				</li>	
				@elseif(auth()->user()->is_admin==2)
				<li class="@if($url=='dashboard')  mm-active  @endif ">
					<a href="{{url('restaurent.dashboard')}}">
						<div class="parent-icon"><i class="bx bx-tachometer" aria-hidden="true"></i>

						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li  class="@if($url=='banner') mm-active @endif ">
					<a href="{{route('restaurent.banner')}}">
						<div class="parent-icon"><i class="bx bx-user" aria-hidden="true"></i></div>
						<div class="menu-title">Banner Manage</div>
					</a>
				</li>	
				<li  class="@if($url=='services') mm-active @endif ">
					<a href="{{route('restaurent.services')}}">
						<div class="parent-icon"><i class="bx bx-user" aria-hidden="true"></i></div>
						<div class="menu-title">Services Manage</div>
					</a>
				</li>	
				<li  class="@if($url=='branch') mm-active @endif ">
					<a href="{{route('restaurent.branch')}}">
						<div class="parent-icon"><i class="bx bx-user" aria-hidden="true"></i></div>
						<div class="menu-title">Branch Manage</div>
					</a>
				</li>
				<li  class="@if($url=='manager') mm-active @endif ">
					<a href="{{route('restaurent.manager')}}">
						<div class="parent-icon"><i class="bx bx-user" aria-hidden="true"></i></div>
						<div class="menu-title">Manager Manage</div>
					</a>
				</li>	
				<li  class="@if($url=='menu') mm-active @endif ">
					<a href="{{route('restaurent/menus')}}">
						<div class="parent-icon"><i class="bx bx-user" aria-hidden="true"></i></div>
						<div class="menu-title">Menu Manage</div>
					</a>
				</li>	

				@endif

				
			
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1" style="display:none">
						<div class="position-relative search-bar-box">
							<input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
							<span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
						</div>
					</div>
					<div class="top-menu ms-auto" >
			
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="{{asset('/public/admin/assets/images/avatars/avatar-2.png')}}" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
							<?php
							if(!empty(auth()->user()))
							{
								$user = \App\Models\User::where("id",session('userId'))->first();
								?>
								<p class="user-name mb-0">{{auth()->user()->name}}</p>
								<p class="designattion mb-0"> {{ auth()->user()->is_admin==1 ? 'Super Admin' :'' }} </p>
							<?php } ?>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="{{url('admin/change_password')}}"><i class="bx bx-user"></i><span>Change Password</span></a>
							</li>
							<li><a class="dropdown-item" href="{{url('admin/settings')}}"><i class="bx bx-cog"></i><span>Settings</span></a>
							</li>
							<li><a class="dropdown-item" href="{{url('admin/logout')}}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		
		