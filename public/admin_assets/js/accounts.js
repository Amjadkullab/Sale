$(document).ready(function(){
    $(document).on('change','#is_parent',function(e){

      if($(this).val()==0){

        $("#parentDiv").show();

      }else{
        $("#parentDiv").hide();

      }



});
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
     var start_balance_status= $("#start_balance_status").val();
if(start_balance_status== ""){
    alert("من فضلك ادخل حالة الحساب اولا ");
    $(this).val("");
    return false;
}
 if($(this).val()== 0 && start_balance_status != 3){
    alert("يجب ادخال مبلغ اكبر من الصفر");
    $(this).val("");
    return false;

 }
});

});






















