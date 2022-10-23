$(document).ready(function(){
    $(document).on('change','#does_has_retailunit',function(e){
      var uom_id =$("#uom_id").val();
      if(uom_id==''){
        alert("اختر الوحدة الأب أولا");
        $("#does_has_retailunit").val("");
        return false ;
      }
        if($(this).val()==1){
            $("#retail_uom_idDiv").show();
            var retail_uom_id = $("#retail_uom_id").val();
            if(retail_uom_id != ''){
               $(".related_retail_counter").show();

            }else{
               $(".related_retail_counter").hide();
            }


        } else{
            $(".related_retail_counter").hide();
            $("#retail_uom_idDiv").hide();

        }


        $("#retail_uom_id").val("");


});
    $(document).on('change','#uom_id',function(e){

        if($(this).val()!= ''){
          var name =   $("#uom_id option:selected ").text();
          $(".parentuomname").text(name);
          var does_has_retailunit =$("#does_has_retailunit").val();
          if(does_has_retailunit==1){
         var retail_uom_id = $("#retail_uom_id").val();
         if(retail_uom_id != ''){
            $(".related_retail_counter").show();

         }else{
            $(".related_retail_counter").hide();

         }
        } else{
         $(".related_retail_counter").hide();
         $("#retail_uom_idDiv").hide();

        }
        $(".related_parent_counter").show();

        } else{
            $(".parentuomname").text('');
            $(".related_retail_counter").hide();
            $(".related_parent_counter").hide();
            $("#retail_uom_idDiv").hide();
        }


});



$(document).on('change','#retail_uom_id',function(e){

    if($(this).val()!= ''){
      var name =   $("#retail_uom_id option:selected ").text();
      $(".childuomname").text(name);
      $(".related_retail_counter").show();


    } else{
        $(".childuomname").text('');
        $(".related_retail_counter").hide();


    }


});


$(document).on('click','#do_add_item',function(e){

    var name = $("#name").val();
    if(name == ""){
        alert("من فضلك أدخل اسم الصنف");
        $("#name").focus();
        return false ;
    }

    var item_type = $("#item_type").val();
    if(item_type == ""){
        alert("من فضلك أدخل نوع الصنف");
        $("#item_type").focus();
        return false ;
    }

    var inv_itemcard_categories_id = $("#inv_itemcard_categories_id").val();
    if(inv_itemcard_categories_id == ""){
        alert("من فضلك اختر فئة الصنف");
        $("#inv_itemcard_categories_id").focus();
        return false ;
    }
    var uom_id = $("#uom_id").val();
    if(uom_id == ""){
        alert("من فضلك اختر وحدة القياس الأب للصنف");
        $("#uom_id").focus();
        return false ;
    }
    var does_has_retailunit = $("#does_has_retailunit").val();
    if(does_has_retailunit == ""){
        alert(" من فضلك اختر حالة هل للصنف وحدة تجزئة ");
        $("#does_has_retailunit").focus();
        return false ;
    }

    if(does_has_retailunit == 1){
        var retail_uom_id = $("#retail_uom_id").val();
        if(retail_uom_id == ""){
            alert(" من فضلك اختر وحدة القياس التجزئة الابن للصنف ");
            $("#retail_uom_id").focus();
            return false ;
        }
        var retail_uom_quntToParent = $("#retail_uom_quntToParent").val();
        if(retail_uom_quntToParent == "" ||retail_uom_quntToParent == 0 ){
            alert(" من فضلك ادخل عدد وحدات التجزئة بالنسبة للاب  ");
            $("#retail_uom_quntToParent").focus();
            return false ;
        }
    }

  var price = $("#price").val();
    if(price == ""){
        alert(" من فضلك ادخل السعر القطاعي للوحدة الاب ");
        $("#price").focus();
        return false ;
    }
  var nos_gomla_price = $("#nos_gomla_price").val();
    if(nos_gomla_price == ""){
        alert(" من فضلك ادخل السعر النص جملة للوحدة الاب ");
        $("#nos_gomla_price").focus();
        return false ;
    }
  var gomla_price = $("#gomla_price").val();
    if(gomla_price == ""){
        alert(" من فضلك ادخل السعر  بالجملة للوحدة الاب ");
        $("#gomla_price").focus();
        return false ;
    }
  var cost_price = $("#cost_price").val();
    if(cost_price == ""){
        alert(" من فضلك ادخل سعر تكلفة الشراء للوحدة الاب");
        $("#cost_price").focus();
        return false ;
    }
    if(does_has_retailunit == 1){


    //start valid child prices if exists

        var price_retail = $("#price_retail").val();
        if(price_retail == ""){
            alert(" من فضلك ادخل السعر القطاعي للوحدة التجزئة ");
            $("#price_retail").focus();
            return false ;
        }
      var nos_gomla_price_retail = $("#nos_gomla_price_retail").val();
        if(nos_gomla_price_retail == ""){
            alert(" من فضلك ادخل السعر النص جملة للوحدة التجزئة ");
            $("#nos_gomla_price_retail").focus();
            return false ;
        }
      var gomla_price_retail = $("#gomla_price_retail").val();
        if(gomla_price_retail == ""){
            alert(" من فضلك ادخل السعر  بالجملة للوحدة التجزئة ");
            $("#gomla_price_retail").focus();
            return false ;
        }
      var cost_price_retail = $("#cost_price_retail").val();
        if(cost_price_retail == ""){
            alert(" من فضلك ادخل سعر تكلفة الشراء للوحدة التجزئة");
            $("#cost_price_retail").focus();
            return false ;
        }
    }
    var has_fixed_price = $("#has_fixed_price").val();
    if(has_fixed_price == ""){
        alert(" من فضلك اختر حالة هل للصنف سعر ثابت بالفواتير");
        $("#has_fixed_price").focus();
        return false;
    }
    var active = $("#active").val();
    if(active == ""){
        alert("من فضلك اختر حالة تفعيل الصنف");
        $("#active").focus();
        return false ;
    }




});

$(document).on('click','#do_edit_cardd',function(e){

    var barcode = $("#barcode").val();
    if(barcode == ""){
        alert("من فضلك أدخل باركود الصنف");
        $("#barcode").focus();
        return false ;
    }
    var name = $("#name").val();
    if(name == ""){
        alert("من فضلك أدخل اسم الصنف");
        $("#name").focus();
        return false ;
    }

    var item_type = $("#item_type").val();
    if(item_type == ""){
        alert("من فضلك أدخل نوع الصنف");
        $("#item_type").focus();
        return false ;
    }

    var inv_itemcard_categories_id = $("#inv_itemcard_categories_id").val();
    if(inv_itemcard_categories_id == ""){
        alert("من فضلك اختر فئة الصنف");
        $("#inv_itemcard_categories_id").focus();
        return false ;
    }
    var uom_id = $("#uom_id").val();
    if(uom_id == ""){
        alert("من فضلك اختر وحدة القياس الأب للصنف");
        $("#uom_id").focus();
        return false ;
    }
    var does_has_retailunit = $("#does_has_retailunit").val();
    if(does_has_retailunit == ""){
        alert(" من فضلك اختر حالة هل للصنف وحدة تجزئة ");
        $("#does_has_retailunit").focus();
        return false ;
    }

    if(does_has_retailunit == 1){
        var retail_uom_id = $("#retail_uom_id").val();
        if(retail_uom_id == ""){
            alert(" من فضلك اختر وحدة القياس التجزئة الابن للصنف ");
            $("#retail_uom_id").focus();
            return false ;
        }
        var retail_uom_quntToParent = $("#retail_uom_quntToParent").val();
        if(retail_uom_quntToParent == "" ||retail_uom_quntToParent == 0 ){
            alert(" من فضلك ادخل عدد وحدات التجزئة بالنسبة للاب  ");
            $("#retail_uom_quntToParent").focus();
            return false ;
        }
    }

  var price = $("#price").val();
    if(price == ""){
        alert(" من فضلك ادخل السعر القطاعي للوحدة الاب ");
        $("#price").focus();
        return false ;
    }
  var nos_gomla_price = $("#nos_gomla_price").val();
    if(nos_gomla_price == ""){
        alert(" من فضلك ادخل السعر النص جملة للوحدة الاب ");
        $("#nos_gomla_price").focus();
        return false ;
    }
  var gomla_price = $("#gomla_price").val();
    if(gomla_price == ""){
        alert(" من فضلك ادخل السعر  بالجملة للوحدة الاب ");
        $("#gomla_price").focus();
        return false ;
    }
  var cost_price = $("#cost_price").val();
    if(cost_price == ""){
        alert(" من فضلك ادخل سعر تكلفة الشراء للوحدة الاب");
        $("#cost_price").focus();
        return false ;
    }
    if(does_has_retailunit == 1){


    //start valid child prices if exists

        var price_retail = $("#price_retail").val();
        if(price_retail == ""){
            alert(" من فضلك ادخل السعر القطاعي للوحدة التجزئة ");
            $("#price_retail").focus();
            return false ;
        }
      var nos_gomla_price_retail = $("#nos_gomla_price_retail").val();
        if(nos_gomla_price_retail == ""){
            alert(" من فضلك ادخل السعر النص جملة للوحدة التجزئة ");
            $("#nos_gomla_price_retail").focus();
            return false ;
        }
      var gomla_price_retail = $("#gomla_price_retail").val();
        if(gomla_price_retail == ""){
            alert(" من فضلك ادخل السعر  بالجملة للوحدة التجزئة ");
            $("#gomla_price_retail").focus();
            return false ;
        }
      var cost_price_retail = $("#cost_price_retail").val();
        if(cost_price_retail == ""){
            alert(" من فضلك ادخل سعر تكلفة الشراء للوحدة التجزئة");
            $("#cost_price_retail").focus();
            return false ;
        }
    }
    var has_fixed_price = $("#has_fixed_price").val();
    if(has_fixed_price == ""){
        alert(" من فضلك اختر حالة هل للصنف سعر ثابت بالفواتير");
        $("#has_fixed_price").focus();
        return false;
    }
    var active = $("#active").val();
    if(active == ""){
        alert("من فضلك اختر حالة تفعيل الصنف");
        $("#active").focus();
        return false ;
    }




});



$(document).on('input','#search_by_text',function(e){
    make_search();


 });
$(document).on('change','#item_type_search',function(e){
    make_search();


 });
$(document).on('change','#inv_itemcard_categories_id_search',function(e){
    make_search();


 });


 $('input[type=radio][name=searchbyradio]').change(function(){
    make_search();

 });



 function make_search(){
    var search_by_text = $("#search_by_text").val();
    var item_type = $("#item_type_search").val();
    var inv_itemcard_categories_id = $("#inv_itemcard_categories_id_search").val();
    var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
    var search_token = $("#search_token").val();
    var ajax_search_url = $("#ajax_search_url").val();
    jQuery.ajax({
  url:ajax_search_url,
  type:'post',
  datatype : 'html',
  cache : false ,
  data : {search_by_text :search_by_text,item_type:item_type,inv_itemcard_categories_id:inv_itemcard_categories_id,searchbyradio:searchbyradio,"_token":search_token},
success:function(data){

    $("#ajax_responce_searchDiv").html(data);

},
error:function(){


}

});



 }
 $(document).on('click','#ajax_pagination_in_search a',function(e){
    e.preventDefault();
    var search_by_text = $("#search_by_text").val();
    var item_type = $("#item_type_search").val();
    var inv_itemcard_categories_id = $("#inv_itemcard_categories_id_search").val();
    var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
    var search_token = $("#search_token").val();

  var url = $(this).attr("href");

  jQuery.ajax({
    url:url,
    type:'post',
    datatype : 'html',
    cache : false ,
    data : {search_by_text :search_by_text,item_type:item_type,inv_itemcard_categories_id:inv_itemcard_categories_id,searchbyradio:searchbyradio,"_token":search_token},
  success:function(data){

      $("#ajax_responce_searchDiv").html(data);



  },
  error:function(){
  }
   });

});





















});
