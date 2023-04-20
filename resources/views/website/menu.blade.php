@include('website.layout.header')
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Food Menu</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
         <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                    <h1 class="mb-5">Most Popular Items</h1>
                </div>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        @if(!empty($getMenu))
                        <input type="hidden" id="menu_id" value="{{$getMenu[0]['id']}}"/>    
                            @foreach($getMenu as $k=> $row)
                        <li class="nav-item">
                            <a  onClick="menuSelect({{$row->id}},{{$k}});return false" @if($k==0)   class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active menu_active" @else class="d-flex align-items-center text-start mx-3 ms-0 pb-3" @endif  data-bs-toggle="pill" href="#tab-1">
                                <i class="fa fa-coffee fa-2x text-primary"></i>
                                <div class="ps-3">
                                    <small class="text-body">Popular</small>
                                    <h6 class="mt-n1 mb-0">{{$row->name}}</h6>
                                </div>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <div class="tab-content" id="sub_menu_div"> </div>
                </div>
            </div>
        </div>
        @include('website.layout.footer')
        <script>
            menuSelect($("#menu_id").val(),"{{auth()->user()->table_id}}");
            function menuSelect(menu_id,tab_id){
                formData={menu_id:menu_id,tab_id:tab_id};
                route=  "{{url('/')}}"+"/"+tab_id+"/getsub_menu_by_menu_id";
                ajaxCall(route,formData,'sub_menu_div')
            }
            </script>