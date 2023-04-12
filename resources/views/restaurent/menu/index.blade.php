@extends('layouts.admin.header') 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
   @extends('layouts.yajradatable') 
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
            		<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Menu Details</h4>
                                <a href="{{route('restaurent.menu.create')}}" class="btn btn-primary mt-3 mt-sm-0">
							 Add New Menu</a>
                            </div>
                            @include('flash-message')
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="type" class="form-control searchRestaurentName" placeholder="Search for Restauremt Type Only...">
                                        </div>


                                        <div class="col-md-1">
                                            <input type="button" id="filter" value="Filter" class="btn btn-primary"/>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="button" id="reset" value="Reset" class="btn btn-primary"/>
                                        </div>
                                    </div>
                                    <table class="table table-bordered data-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>image</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th width="100px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
@endsection

<script type="text/javascript">
  $(function () {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('restaurent.menu.data') }}",
          data: function (d) {
                d.name = $('.searchRestaurentName').val(),
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            {mData: 'id',
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
            {data: 'image', name: 'image'},
            {data: 'type', name: 'type'},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    

    $(document).on('change','.statusAction',function(){
        var id = $(this).attr('data-id');
        var value = $(this).val();
        let statusMsg = "";
        if(value == 'Active') {
            statusMsg = 'Are you sure you want to active?';
        } else if(value == 'Inactive') {
            statusMsg = 'Are you sure you want to inactive?';
        }
        if(window.confirm(statusMsg)) {
            var path = $(this).data('path');               
       //     $('.loader').show();
            $.ajax({
                url:path,
                method: 'post',
                data: {'id':id,'value':value},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(result){
                toastr.success(result.type,result.message);
                table.ajax.reload();  
            }
            });        
        }else{
            var oldValue = $(this).attr('data-value');
            $(this).val(oldValue);
            return false;
        }
    });
    $("#filter").on("click",function(){
        table.ajax.reload();
    });

    $("#reset").on("click",function(){
        $('.searchRestaurentName').val('');
        table.ajax.reload();
    });
});

// function select_changes2(id,value){
//     formData={id:id,status:value};
//     route =  "{{ route('restaurent.menu.status_change') }}";
//     ajaxCall(route,formData)
// }
    

</script>