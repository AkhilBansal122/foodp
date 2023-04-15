@include('admin.layout.header')
<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Content Details</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				@include('flash_message')
				<div class="row">
					<div class="col-xl-12 mx-auto">
                		<h6 class="mb-0 text-uppercase"></h6>
				
                     
                        <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered  mb-0 " style="width:100%">
								<thead>
									<tr>
											<th scope="col">Title</th>
											<th scope="col">Slug</th>
                                            <th scope="col">Created Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
                                @if(!empty($data))
                                            @foreach($data as $k=> $value)    
                                        <tr>
											<td>{{$value->title}}</td>
											<td>{{$value->slug}}</td>
											
                                            <td> {{date('d-m-Y h:i:s A', strtotime($value->created_at))}}</td>
                                          <td> <select name="status" data-record_id="{{$value->id}}" data-url = "{{url('restaurent/content/status_change')}}" class="form-select StatusChange">
                                                <option value="Active" @if($value->status=='Active') selected @endif >Active</option>
                                                <option value="Inactive" @if($value->status=='Inactive') selected @endif>Inactive</option>
										    </select></td>
                                            <td> 
                                        <a href="{{url('restaurent/content/edit')}}/{{encrypt($value->id)}}" class="btn btn-light  radius-0"><i class="bx bx-edit"></i></a>  
										<a href="{{url('restaurent/content/view')}}/{{encrypt($value->id)}}" class="btn btn-light  radius-0"><i class="bx bx-show"></i></a>  
                                		</tr>
                                        @endforeach
                                        @endif
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
				
						
					</div>
				</div>
				<!--end row-->
			</div>
		</div>


	
@include('admin.layout.footer')
<script>
	  
	  $(document).ready(function() {
		$('#example').DataTable({
		ordering: false,
	  });

	  $(".StatusChange").on('change',async function(){  
		let optionVal  = $(this).val(); 
		token =$('meta[name="csrf-token"]').attr('content');
		var conf = confirm('Are You Sure?');			
		if(!conf){ 
			if(optionVal=="Active"){
				$(this).val("Inactive");
			}else{
				$(this).val("Active");
			}
		}
		else{ 
			id =   $(this).data("record_id");
        	statusVal =   $(this).val();
          	url = $(this).data('url');
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': token
					}
				});
				$.post(url,
				{
					id: id,
					status: statusVal,
				},
				function(data, status){
					if(status=='success')
					{
						location.reload();
					}
				});
			}
		});

      
	});
	  
	</script>