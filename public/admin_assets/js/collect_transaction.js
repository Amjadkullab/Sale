
$(document).ready(function(){
    $(document).on('click',"#do_collect_now_btn",function(){
        var move_date = $("#move_date").val();
        if(move_date == ""){
            alert("من فضلك اختر التاريخ");
            $("#move_date").focus();
            return false ; // عشان ما يكمل ال submit بتاعنا
        }
        var mov_type = $("#mov_type").val();
        if(mov_type == ""){
            alert("من فضلك اختر الحركة المالية");
            $("#mov_type").focus();
            return false ;
        }
        var account_number = $("#account_number").val();
        if(account_number == ""){
            alert("من فضلك اختر الحساب المالي");
            $("#account_number").focus();
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
        var byan =$("#byan").val();
        if(byan == ""){
            alert("من فضلك ادخل  البيان بشكل واضح");
            $("#byan").focus();
            return false ;
        }
    });

});
