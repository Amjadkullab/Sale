$(document).ready(function () {


    $(document).on('change', '#item_code_add', function (e) {
      var item_code = $(this).val();
      if (item_code != "") {
        var token_search = $("#token_search").val();
        var ajax_get_item_uoms_url = $("#ajax_get_item_uoms_url").val();
        jQuery.ajax({
          url: ajax_get_item_uoms_url,
          type: 'post',
          dataType: 'html',
          cache: false,
          data: { item_code: item_code, "_token": token_search },
          success: function (data) {

            $("#UomDivAdd").html(data);
            $(".relatied_to_itemCard").show();
            var type = $("#item_code_add").children('option:selected').data("type");
            if (type == 2) {

              $(".relatied_to_date").show();
            } else {
              $(".relatied_to_date").hide();
            }

          },
          error: function () {
            $(".relatied_to_itemCard").hide();
            $("#UomDivAdd").html("");
            $(".relatied_to_date").hide();

            alert("حدث خطاما");
          }
        });

      } else {
        $(".relatied_to_itemCard").hide();
        $("#UomDivAdd").html("");
        $(".relatied_to_date").hide();
      }


    });
});
