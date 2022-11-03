$(document).ready(function(){


    $(document).on('change','#start_balance_status',function(e){
      if($(this).val()==""){
        $("#start_balance").val("");
      }else{
        if($(this).val()==3){

          $("#start_balance").val(0);

          }
      }

      });
      $(document).on('input','#start_balance',function(e){
       var start_balance_status=$("#start_balance_status").val();
       if(start_balance_status==""){
        alert("من فضلك اختر حالة الحساب اولا");
        $(this).val("");
        return false;
       }
       if($(this).val()==0 && start_balance_status!=3 ){
        alert("يجب ادخال مبلغ اكبر من الصفر");
        $(this).val("");
        return false;
       }


      });

      $(document).on('input','#searchbytext',function(e){
        make_search();
      });


      $('input[type=radio][name=searchbyradio]').change(function() {
        make_search();
      });



      function make_search(){
        var searchbytext=$("#searchbytext").val();
        var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
        var token_search=$("#token_search").val();
        var ajax_search_url=$("#ajax_search_url").val();

        jQuery.ajax({
          url:ajax_search_url,
          type:'post',
          dataType:'html',
          cache:false,
          data:{searchbytext:searchbytext,"_token":token_search,searchbyradio:searchbyradio},
          success:function(data){

           $("#ajax_responce_serarchDiv").html(data);
          },
          error:function(){

          }
        });

      }

      $(document).on('click','#ajax_pagination_in_search a ',function(e){
        e.preventDefault();
        var searchbytext=$("#searchbytext").val();
        var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
        var token_search=$("#token_search").val();
        var url=$(this).attr("href");

        jQuery.ajax({
          url:url,
          type:'post',
          dataType:'html',
          cache:false,
          data:{searchbytext:searchbytext,"_token":token_search,searchbyradio:searchbyradio},
          success:function(data){

           $("#ajax_responce_serarchDiv").html(data);
          },
          error:function(){

          }
        });



        });



    });
