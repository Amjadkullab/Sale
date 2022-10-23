$(document).ready(function () {
    $(document).on('click', '#update_image', function (e) {
        e.preventDefault();
        if (!$("#photo").length) {
            $("#update_image").hide();
            $("#cancel_update_image").show();
            $("#old_image").html('<input type ="file" onchange="readURL(this)" name="photo" id="photo">');

        }
        return false;


    });
    $(document).on('click', '#cancel_update_image', function (e) {
        e.PreventDefault();
        $("#update_image").show();
        $("#cancel_update_image").hide();
        $("#old_image").html('');


        return false; //عشان ما يعمل submit


    });
    $(document).on('click', '.are_you_sure', function (e) {

        var res = confirm("هل انت متأكد ؟");
        if (!res) {   //يجيلو انو منحدفش معناها انو لو رفض
            return false;
        }

    });



});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imageuploaded').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}












