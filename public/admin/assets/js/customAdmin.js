
 
 

   function postRequest(data,method,routeUrl,responseDisplayIdClass,typeClassId){
    //  $(responseDisplayIdClass).empty();

    if(typeClassId==1)
    {
      if(responseDisplayIdClass=="product_user_id"){
         $("#div_user_id").show();
         $("#"+responseDisplayIdClass).empty();
      }
      else{
         $("#"+responseDisplayIdClass).empty();
      }
    }
    else if(typeClassId==2)
    {
       $("."+responseDisplayIdClass).append();
    }
     $.ajax({
         url:routeUrl,
         type: method,
      
         data:data,
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
         success: function (response) {
            if(response.status==true)
            {
               if(responseDisplayIdClass=='')
               {
                  toastr.success(data.message);
               }
               if(typeClassId==1)
               {
                  $("#"+responseDisplayIdClass).append(response.data);
               }
               else if(typeClassId==2)
               {
                  $("."+responseDisplayIdClass).append(response.data);
               }

               // 
            }
         },

         error: function (error) {
             console.log(`Error ${error}`);
         }
     });


   }

   


