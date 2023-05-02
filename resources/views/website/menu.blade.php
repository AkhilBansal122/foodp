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
                                 <button onClick="menuSelect({{$row->id}},{{$k}});return false" class="addtocard">
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
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12" id="cartitemDiv">
                              <!-- <div style="display: flex;" class="card mt-3 px-2 py-2">
                                 <div style="display: flex;">
                                    <img src="http://localhost/foodpanel/public/upload/restaurent/sub_menus/167808755736.jpg" width="80vh" height="80vh" alt="">
                                    <div>
                                    <i class="bi bi-file-x" style="color: #fb0606; margin-left: 170px;"></i>
                                 </div>
                                 </div>
                                 <div class="mx-2">
                                    <p>Burger mozzo XL</p>
                                    <div class="quantity d-flex">
                                        <button onclick="increment()" style="border: none; height: 37px; background-color: orange; color: white;">+</button>
                                       <h2 id="counting" class="form-control" style="background-color: orange; width: 60px; color: white;"></h2>
                                       <button onclick="decrement()" style="border: none; height: 37px; background-color: orange; color: white;">-</button> 
                                    </div>
                                    <div>
                                       <p>Price : Rs.120</p>
                                    </div>
                                 </div>
                              </div> -->


                           </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
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
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Total </p>
                           </div>
                           <small class="text-body-secondary">Rs.1000</small>
                        </div>
                        <a href="{{url('/')}}/{{auth()->user()->table_id}}/shipping_address"><button class="form-control text-white" style="border: none; background-color: orange;" >Check Out</button></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript">
         //initialising a variable name data
  
         var data = 0;
           
         //printing default value of data that is 0 in h2 tag
       //  document.getElementById("counting").innerText = data;
           
         //creation of increment function
         function increment(key,qty) {
            // console.log(key);
             qty = qty + 1;
             console.log(qty);
             var id ="'"+ "counting_"+key+"'";

             document.getElementById(id).inner= qty;
         }
         //creation of decrement function
         function decrement(key,qty) {
             qty = qty - 1;
               var id ="'"+ "counting_"+key+"'";
               console.log(qty);
             document.getElementById(id).inner = qty;
            // document.getElementById("counting").innerText = data;
         }
      </script> 
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
         <script>
            
            $(document).on("click",".addtocart",function(){
              id= $(this).data("id");
              table_id= $(this).data("table_id");
              price= $(this).data("price");
              selected=  $(this).data("seleted");      
                  $.ajax({
            url: "{{url('"+table_id+"/add_tocart')}}",
                      method: 'POST',
                      type: "post",
             cache: false,
            data: {"product_id":id,"table_id":table_id,"price":price},
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(response)
            {
               cartItemCAll(table_id);
            },
            error: function(response) {
            }
        });
    });
            cartItemCAll('TBL-002672671');

      function cartItemCAll(table_id){
           // console.log("table_id--->",table_id);
         $.ajax({
            url: "{{url('"+table_id+"/cartItemList')}}",
             method: 'POST',
             type: "post",
             cache: false,
            data: {"table_id":table_id,},
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(response)
            {
               html ="";
               if(response.status==true){
                  var result  =response.data;
               console.log(result);

$.each( result, function( key, value ) {
  var product_name = value.product_name;
  var product_price = value.product_price;
  var product_image = value.product_image;
  var cart_id = value.cart_id;
  var id = value.cart_item_id;
  var product_qty = value.qty;



                   html +='<div style="display: flex;" class="card mt-3 px-2 py-2">';
                                 html+='<div style="display: flex;">';
                                    html+='<img src="'+product_image+'" width="80vh" height="80vh" alt="">';
                                    html+='<div>';
                                    html+='<i class="bi bi-file-x" style="color: #fb0606; margin-left: 170px;"></i>';
                                 html+='</div>';
                                 html+='</div>';
                                 html+='<div class="mx-2">';
                                    html+='<p>'+product_name+'</p>';
                                   html+=' <div class="quantity d-flex">';
                                      html+='  <button onclick="increment('+key+','+product_qty+');return false;"   style="border: none; height: 37px; background-color: orange; color: white;">+</button>';
                                      html+=' <h2 id="counting_'+key+'" class="form-control " style="background-color: orange; width: 60px; color: white;">'+product_qty+'</h2>';
                                     html+='  <button onclick="decrement('+key+','+product_qty+');return false" data-cart_id='+cart_id+' data-cart_item_id='+id+' style="border: none; height: 37px; background-color: orange; color: white;">-</button>'; 
                                  html+='  </div>';
                                  html+='  <div>';
                                   html+='    <p>Price : Rs.'+product_price+'</p>';
                                html+='    </div>';
                               html+='  </div>';
                             html+=' </div>';


});
                             $("#cartitemDiv").empty();
                             $("#cartitemDiv").append(html);

               }
            // console.log();  
            },
            error: function(response) {
            }
        });
         } 
         </script>
        @include('website.layout.footer')
        <script>
            menuSelect($("#menu_id").val(),"{{auth()->user()->table_id}}");
            function menuSelect(menu_id,tab_id){
                formData={menu_id:menu_id,tab_id:tab_id};
                route=  "{{url('/')}}"+"/"+tab_id+"/getsub_menu_by_menu_id";
                ajaxCall(route,formData,'sub_menu_div')
            }
         </script>




