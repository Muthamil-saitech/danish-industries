$(function () {
    "use strict";
    /**
     * @description This function is used to set the serial number
     */
    $('#tax_value').on('input', function () {
        // console.log('sdfsd');
        const value = parseFloat($(this).val()) || 0;
        const cgst = (value / 2).toFixed(2);
        const sgst = (value / 2).toFixed(2);
        const igst = (parseFloat(cgst) + parseFloat(sgst)).toFixed(2);
        $('#cgst').val(cgst);
        $('#sgst').val(sgst);
        $('#igst').val(igst);
    });
    function setSN() {
        $('.set_sn').each(function(i, obj) {
            i++;
            $(this).html(i);
        });
    }
    //remove tax row
    $(document).on('click','.remove_this_tax_row',function(){
        $(this).parent().parent().remove();
        setSN();
    });
    $('#add_tax').on('click',function(){
        let table_tax_body = $('#tax_table_body');
        let show_tax_row = '';
        show_tax_row += '<tr class="tax_single_row">';
        show_tax_row += '<td class="set_sn ir_txt_center align-middle"></td>';
        show_tax_row += '<td><input type="text" autocomplete="off" name="taxes[]" placeholder="Tax Name" class="form-control check_required"/></td>';
        show_tax_row += '<td><input type="text" autocomplete="off" name="tax_rate[]" placeholder="Tax Rate" class="form-control" /></td>';
        show_tax_row += '<td class="align-middle">%</td>';
        show_tax_row +=
            '<td class="ir_txt_center align-middle"><span class="remove_this_tax_row dlt_button" style="cursor:pointer;"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></span></td>';
        show_tax_row += '</tr>';
        table_tax_body.append(show_tax_row);
        setSN();
    });
    $(document).on('change', 'input[name="collect_tax"]', function () {
        if ($(this).val() === 'Yes') {
            $('.tax_yes_section').removeClass('d-none');
        } else {
            $('.tax_yes_section').addClass('d-none');
        }
        $('.tax_fields_form').removeClass('d-none');
    });
    
    $("#tax_update").submit(function(){
        let status = true;
        let focus = 1;
        $(".check_required").each(function () {
            let this_value = $(this).val();
            if(this_value==''){
                status = false;
                $(this).css("border","1px solid red");
                if(focus==1){
                    $(this).focus();
                    focus++;
                }
            }else{
                $(this).css("border","1px solid #ccc");
            }
        });

        if(status == false){
            return false;
        }
    });

    setSN();
});