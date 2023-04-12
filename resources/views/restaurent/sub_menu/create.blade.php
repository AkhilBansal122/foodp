@extends('layouts.admin.header') 
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
  <style>
    .error{
     color: #FF0000; 
    }
  </style>
@section('content')
<div class="content-body">
	<!-- row -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">New Add Sub Menu</h4>
					</div>
					<div class="card-body">
						<div class="form-validation">
						@include('flash-message')
							<form enctype='multipart/form-data' action="{{route('restaurent.sub_menu.store')}}" method="post">
								@include('restaurent.sub_menu.form') 
							</form>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection