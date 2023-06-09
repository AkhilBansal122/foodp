@include('website.layout.header')
        
<input type="hidden" id="table_id" value="{{$id}}"/>
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
                           <small class="text-body-secondary" id="sub_total">Rs.120</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Discount Amount</p>
                           </div>
                           <small class="text-body-secondary" id="discount_amount">Rs.00</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Delivery Charge</p>
                           </div>
                           <small class="text-body-secondary" id="shipping_amount">Rs.00</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>GST Amount</p>
                           </div>
                           <small class="text-body-secondary" id="gstAmount">Rs.00</small>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="btn-group">
                              <p>Total </p>
                           </div>
                           <small class="text-body-secondary" id="total_final_amount">Rs.1000</small>
                        </div>
                        <a href="{{url('/')}}/{{auth()->user()->table_id}}/shipping_address"><button class="form-control text-white" style="border: none; background-color: orange;" >Check Out</button></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
      
      <script type="text/javascript">
         //initialising a variable name data
  
         var data = 0;
        //   $("#spinner").hide();
         //printing default value of data that is 0 in h2 tag
       //  document.getElementById("counting").innerText = data;
           
         //creation of increment function
         function increment(key,qty) {
            
            var id  =".quantity_"+key;
            quantity= parseInt($(id).val());
           
            cart_id= $(id).data('cart_id');
            cart_details_id= $(id).data('cart_item_id');
           
            quantity+=1;
            table_id = $("#table_id").val();
            console.log("cart_id->",cart_details_id);
            $(id).val(quantity);
            data={
               "type":1,
               "qty":quantity,
               "cart_id":cart_id,
               "cart_details_id":cart_details_id
            }
            CartItemIncDec(data,table_id);
         }
         //creation of decrement function
         function decrement(key,qty) {
            var id  =".quantity_"+key;
           
            cart_id= $(id).data('cart_id');
            cart_details_id= $(id).data('cart_item_id');
           
            table_id = $("#table_id").val();
            
            quantity= parseInt($(id).val());
            quantity-=1;
            if(quantity>0)
            {
               $(id).val(quantity);
               data={
               "type":2,
               "qty":quantity,
               "cart_id":cart_id,
               "cart_details_id":cart_details_id
               };
               CartItemIncDec(data,table_id);
            }

         }
         function CartItemIncDec(data,table_id){
          //  console.log("::->",data);
            $.ajax({
                     url: "{{url('"+table_id+"/CartItemIncDec')}}",
                     method: 'POST',
                     type: "post",
                     cache: false,
                     data: data,
                     dataType: 'JSON',
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     beforeSend:function(){
                        $("#spinner").addClass("show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center");
                      },   
                     success:function(response)
                     {
                        cartItemCAll(table_id);
                     },
                     error: function(response) {
                     }
               });
         }
            
            $(document).on("click",".addtocart",function(){
          
              id= $(this).data("id");
              table_id = $("#table_id").val();
              // table_id= $(this).data("table_id");
              price= $(this).data("price");
              id= $(this).data("id");
              selected=  $(this).data("seleted");  
              var routes =  "{{url('"+table_id+"/add_tocart')}}"; 
                $.ajax({
                     url: routes,
                     data: {"product_id":id,"table_id":table_id,"price":price,'id':id},
                     method: 'POST',
                     type: "post",
                     cache: false,
                   //  data: data,
                     dataType: 'JSON',
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     beforeSend:function(){
                        $("#spinner").addClass("show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center");
                      },
                     success:function(response)
                     {
                        $("#spinner").removeClass("show");
                        console.log(response);
                        if(response.status == true)
                        {
                           cartItemCAll(table_id);
                        }
                     },
                     error: function(response) {
                     }
               });
            });

            $(document).on("click",".remove_cartItem",function(e){
               var cart_id = $(this).data("cart_id");
               var cart_item_id = $(this).data("cart_item_id");
               var  table_id = $("#table_id").val();
               var index = $(this).data('index');
               var classs = ".remove_cartItem_"+index;
               $(classs).hide();

            //   alert(cart_id);
               $.ajax({
                     url: "{{url('"+table_id+"/remove_cartItem')}}",
                     method: 'POST',
                     cache: false,
                     data: {"cart_item_id":cart_item_id,"table_id":table_id,"cart_id":cart_id},
                     dataType: 'JSON',
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     beforeSend:function(){
                     $("#spinner").addClass("show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center");
                     },
                     success:function(response)
                     {
                        $("#spinner").removeClass("show");
                        if(response.status == true)
                        {
                           cartItemCAll(table_id);
                        }
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
            beforeSend:function(){
               $("#spinner").addClass("show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center");
            },
            success:function(response)
            {
               $("#spinner").removeClass("show");
               html ="";
               if(response.status==true){
               var result  =response.data;
               
               var price = response.cart.price;
               var final_amount = response.cart.final_amount;
               var discount_amount = response.cart.discount_amount;
               var shipping_price = response.cart.shipping_price;
               var price = response.cart.price;
               var gstAmount = response.cart.gstAmount;

               $("#sub_total").text("Rs."+price);
               $("#discount_amount").text("Rs."+discount_amount);
               $("#shipping_amount").text("Rs."+shipping_price);
               $("#gstAmount").text("Rs."+gstAmount);
               $("#total_final_amount").text("Rs."+final_amount);
              
               $.each( result, function( key, value ) {
                  var product_name = value.product_name;
                  var product_price = value.product_price;
                  var product_image = value.product_image;
                  var cart_id = value.cart_id;
                  var id = value.id;
                  var product_qty = value.qty;
                    html +='<div style="display: flex;" class="card mt-3 px-2 py-2 remove_cartItem_'+key+'">';
                                 html+='<div style="display: flex;">';
                                    html+='<img src="'+product_image+'" width="80vh" height="80vh" alt="">';
                                    html+='<div>';
                                    html+='<i class="bi bi-file-x remove_cartItem" data-index='+key+' data-cart_id='+cart_id+' data-cart_item_id='+id+' style="color: #fb0606; margin-left: 170px;"></i>';
                                 html+='</div>';
                                 html+='</div>';
                                 html+='<div class="mx-2">';
                                    html+='<p>'+product_name+'</p>';
                                   html+=' <div class="quantity d-flex">';
                                      html+='  <button onclick="increment('+key+','+product_qty+');return false;"    style="border: none; height: 37px; background-color: orange; color: white;">+</button>';
                                      html+=' <input type="text" id="quantity" readonly value="'+product_qty+'" data-cart_id='+cart_id+' data-cart_item_id='+id+' class="quantity_'+key+'" style="background-color: orange; width: 60px; color: white;">';
                                     html+='  <button onclick="decrement('+key+','+product_qty+');return false"  style="border: none; height: 37px; background-color: orange; color: white;">-</button>'; 
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




