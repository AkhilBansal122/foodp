@extends('layouts.admin.header') 
@section('content')
<div class="content-body">
	<!-- row -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Add New Manager</h4>
					</div>
					<div class="card-body">
						<div class="form-validation">
						@include('flash-message')
							<form enctype='multipart/form-data' action="{{route('restaurent.manager.store')}}" method="post">
								@include('restaurent.manager.form') 
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