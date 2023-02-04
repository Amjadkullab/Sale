
$(document).ready(function(){
    $(document).on('click',"#do_exchange_now_btn",function(){
        var move_date = $("#move_date").val();
        if(move_date == ""){
            alert("من فضلك اختر التاريخ");
            $("#move_date").focus();
            return false ; // عشان ما يكمل ال submit بتاعنا
        }
        var account_number = $("#account_number").val();
        if(account_number == ""){
            alert("من فضلك اختر الحساب المالي");
            $("#account_number").focus();
            return false ;
        }
        var mov_type = $("#mov_type").val();
        if(mov_type == ""){
            alert("من فضلك اختر الحركة المالية");
            $("#mov_type").focus();
            return false ;
        }


        var treasuries_id = $("#treasuries_id").val();
        if(treasuries_id == ""){
            alert("من فضلك اختر  خزنة التحصيل ");
            $("#treasuries_id").focus();
            return false ;
        }
        var money =$("#money").val();
        if(money == "" ||money <= 0){
            alert("من فضلك ادخل مبلغ التحصيل");
            $("#money").focus();
            return false ;
        }
        var treasuries_balance = $("#treasuries_balance").val();
        if(treasuries_balance == "" || treasuries_balance == 0){
            alert("عفوا لا يوجد لديك رصيد كافي في الخزنة !!");
            $("#money").focus();
            return false ;
        }
        if(parseFloat(money)>parseFloat(treasuries_balance)){
            alert("عفوا لا يوجد لديك رصيد كافي في الخزنة !!");
            $("#money").focus();
            return false ;
         }
        var byan =$("#byan").val();
        if(byan == ""){
            alert("من فضلك ادخل  البيان بشكل واضح");
            $("#byan").focus();
            return false ;
        }
    });
    $(document).on('change',"#account_number",function(){
        var account_number = $(this).val();
        if(account_number ==""){
            $("#mov_type").val("");
        }else{
 var account_type =$("#account_number option:selected").data("type");
 // اذا  كان مورد
          if(account_type == 2){
            $("#mov_type").val(9);
          }else if(account_type == 3){
            // اذا كان عميل
            $("#mov_type").val(6);
          }
          else if(account_type == 6){
            // اذا كان بنك
            $("#mov_type").val(18);
          }
          else {
            // اذا كان عام
            $("#mov_type").val(3);
          }
        }

    });
    $(document).on('change',"#mov_type",function(){
        var account_number = $("#account_number").val();
        if(account_number == ""){
            alert("من فضلك اختر الحساب المالي أولا");
            $("#mov_type").val("");
            return false ;
        }
            var account_type =$("#account_number option:selected").data("type");
            // اذا  كان مورد
            if(account_type == 2){
                $("#mov_type").val(9);
              }else if(account_type == 3){
                // اذا كان عميل
                $("#mov_type").val(6);
              }
              else if(account_type == 6){
                // اذا كان بنك
                $("#mov_type").val(18);
              }
              else {
                // اذا كان عام
                $("#mov_type").val(3);
              }
                   });


});
