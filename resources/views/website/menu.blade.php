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
            <div class="container-fluid">
               <div class="row">
                  <div class="col-8">
                     <div class="row mt-4">
                        <div class="col-12">
                           <nav aria-label="breadcrumb">
                              <div class="container bttn">
                                 @if(!empty($getMenu))
                                 <input type="hidden" id="menu_id" value="{{$getMenu[0]['id']}}"/>    
                                 @foreach($getMenu as $k=> $row)
                                 <button onClick="menuSelect({{$row->id}},{{$k}});return false">
                                    <span>
                                       Popular 
                                       <p>{{$row->name}}</p>
                                    </span>
                                 </button>
                                 @endforeach
                                 @endif
                              </div>
                              <style type="text/css">
                                  .btn-outline-secondary:hover {
                                        background-color: orange;
                                        border: none;
                                    }
                              </style>
                              <div class="container mt-5">
                                <div class="row">
                                    <div class="tab-content" id="sub_menu_div"> </div>
                                </div>
                              </div>
                           </nav>
                        </div>
                     </div>
                  </div>
                  <div class="col-4">
                     <div class="container">
                        <div class="row">
                           <div class="col-12">
                              <h4 class="mt-3">My orders</h4>
                              <hr>
                              <div class="mt-4">
                                 <p>Delivery address</p>
                                 <h4>1341 Morris Streets</h4>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12">
                              <div style="border: 1px solid aliceblue; display: flex; background-color: aliceblue; border-radius:10px ;">
                                 <div>
                                    <img src="burger.jpg" width="80vh" height="80vh" style="border-radius: 10px;" alt="">
                                 </div>
                                 <div>
                                    <p>Burger mozzo XL</p>
                                    <p>Extra cheess</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Sub Total</p>
                           </div>
                           <small class="text-body-secondary">Rs.120</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Delivery Charge</p>
                           </div>
                           <small class="text-body-secondary">Rs.00</small>
                        </div>
                        <div class="input-group">
                           <input type="text" class="form-control" placeholder="Find Promotion" aria-label="Input group example" aria-describedby="btnGroupAddon">
                           <div class="input-group-text" id="btnGroupAddon">Add Coupon</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Total </p>
                           </div>
                           <small class="text-body-secondary">Rs.1000</small>
                        </div>
                        <button class="form-control" style="border: none; background-color: orange;" >Check Out</button>
                     </div>
                  </div>
               </div>
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