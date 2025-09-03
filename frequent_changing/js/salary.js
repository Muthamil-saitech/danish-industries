$(function() {
    "use strict";
    checkAll();
    /**
     * @description This function is used to check all checkboxes
     */
    function checkAll() {
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $(".checkbox_userAll").prop("checked", true);
        } else {
            $(".checkbox_userAll").prop("checked", false);
        }
    }
    // const allIds = [];
    // $('tbody .row_counter').each(function() {
    //     allIds.push($(this).data('id'));
    // });
    // console.log("allIds",allIds);
    $(document).on('click', '.checkbox_userAll', function(e){
        let checked = $(this).is(':checked');
        if (checked) {
            $(".checkbox_user").each(function () {
                let menu_id = $(this).attr('data-menu_id');
                $(this).prop("checked", true);
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            });
            $(".checkbox_userAll").prop("checked", true);
        } else {
            $(".checkbox_user").each(function () {
                let menu_id = $(this).attr('data-menu_id');
                $(this).prop("checked", false);
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            });
            $(".checkbox_userAll").prop("checked", false);
        }
        cal_row();
    });
    $(document).on('click', '.checkbox_user', function(e){
        let menu_id = $(this).attr('data-menu_id');
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $(".checkbox_userAll").prop("checked", true);
            if($(this).is(':checked')){
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            }else{
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            }
        } else {
            $(".checkbox_userAll").prop("checked", false);
            if($(this).is(':checked')){
                $("#qty"+menu_id).val(1);
                $("#qty"+menu_id).prop("disabled", false);
            }else{
                $("#qty"+menu_id).prop("disabled", true);
                $("#qty"+menu_id).val('');
            }
        }
        cal_row();
    });
    
    $(document).on('keyup', '.cal_row', function(e){
        cal_row();
    });

});
cal_row();

/**
 * @description This function is used to calculate the total amount
 */
function cal_row() {
    let total = 0;
    $(".row_counter").each(function () {
        let id = $(this).attr("data-id");

        // Check if the user's checkbox is checked
        let isChecked = $(this).find(".checkbox_user").is(":checked");
        if (!isChecked) {
            // If not checked, still update total field for the row but skip adding to global total
            let salary = $("#salary_" + id).val() || 0;
            let additional = $("#additional_" + id).val() || 0;
            let subtraction = $("#subtraction_" + id).val() || 0;

            salary = $.isNumeric(salary) ? parseFloat(salary) : 0;
            additional = $.isNumeric(additional) ? parseFloat(additional) : 0;
            subtraction = $.isNumeric(subtraction) ? parseFloat(subtraction) : 0;

            let total_row = salary + additional - subtraction;
            $("#total_" + id).val(total_row.toFixed(2));

            return; // Skip adding to overall total
        }

        // Proceed if checkbox is checked
        let salary = $("#salary_" + id).val() || 0;
        let additional = $("#additional_" + id).val() || 0;
        let subtraction = $("#subtraction_" + id).val() || 0;

        salary = $.isNumeric(salary) ? parseFloat(salary) : 0;
        additional = $.isNumeric(additional) ? parseFloat(additional) : 0;
        subtraction = $.isNumeric(subtraction) ? parseFloat(subtraction) : 0;

        let total_row = salary + additional - subtraction;
        total += total_row;

        $("#total_" + id).val(total_row.toFixed(2));
    });

    $(".total_amount").html(total.toFixed(2));
    $("#total_amount").val(total.toFixed(2));
}