@include('admin.layout.header')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>



<script type="text/javascript" src='https://cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.js'></script>
    <link media="screen" rel="stylesheet" href='https://cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css' />
    <link media="screen" rel="stylesheet" href='https://cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.css' />

<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                @include('flash-message')
							
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Services Details</li>
							</ol>
						</nav>
					</div>
				</div>
				
         

                        <div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table table-bordered data-table" style="width:100%">
										<thead>
                                        <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th>Total Stock</th>
												<th>Sellout Stock</th>
												<th>qty_opt</th>
                                       		</tr>
										</thead>
										<tbody>
										</tbody>
										
									</table>
								</div>
							</div>
						</div>
				<!--end row-->
			</div>
		</div>


	
@include('admin.layout.footer')
<script type="text/javascript">
  $(function () {

        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength:10,
        retrieve:true,
        ajax: {
          url: "{{ route('warehouse_manage/inventory_requestdata') }}",
            data: function (d) {
                d.search = $('input[type="search"]').val(),
                d.searchStart_date = $('.searchStart_date').val(),
                d.searchEndDate = $('.searchEndDate').val()
            },
        },
        columns: [
            {mData: 'id',
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
		     {data:'product_name',name:"product_name"},
			 {data:'total_available',name:'total_available'},
			 {data:'total_dr',name:'total_dr'},
			 {data:'qty_opt',name:'qty_opt'},
          
		]
    });

});
	</script>