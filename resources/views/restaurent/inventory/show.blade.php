@extends('layouts.admin.header') 
@section('content')
<div class="content-body">
	<!-- row -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Show Inventory Details</h4>
					</div>
					<div class="card-body">
						<div class="form-validation">
						@include('flash-message')
							<form enctype='multipart/form-data' action="{{route('restaurent.inventory_manage.store')}}" method="post">
							@csrf
                            <div class="bacic-info mb-3">
    <h4 class="mb-3">Basic info</h4>
    <div class="row">
        
        <div class="col-xl-3">
            <label class="form-label">Address <span style="color:red">*</span></label>
            <textarea readonly name="address" class="form-control mb-3" required style="height:116px" placeholder="Admin@1234">{{ isset($data->address) ? $data->address : '' }}</textarea>
        </div>
        
    </div>
</div>
</div>
<div class="Security">
    <div class="row">
        <div class="col-xl-12">
            <a href="{{ route('restaurent.inventory_manage') }}" class="btn btn-outline-primary float-end ms-3">Back</a>
        </div>
    </div>
</div>

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