$(document).ready(function(){
    "use strict";
    /**
     * @description This function is used to validate the email
     * @param {*} email 
     * @returns 
     */
    function validateEmail(email) {
        let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    function validateGST(gst_no) {
        let gstRegex  = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
        return gstRegex.test(gst_no);
    }

    $(document).on('click', '#addCustomer', function(e){
        // console.log('add');
        let name = $('input[name=name]').val();
        let phone = $('input[name=phone]').val();
        let gst_no = $('input[name=gst_no]').val();
        let emailAddress = $('input[name=emailAddress]').val();
        let supAddress = $('textarea[name=supAddress]').val();
        let note = $('textarea[name=note]').val();
        let error = 0;
        if(name == '') {
            error = 1;
            let cl1 = ".customer_err_msg";
            let cl2 = ".customer_err_msg_contnr";
            $(cl1).text("The Customer Name field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else {
            $('input[name=name]').css('border', '1px solid #ccc');
        }

        if(phone == '') {
            error = 1;
            let cl1 = ".customer_phone_err_msg";
            let cl2 = ".customer_phone_err_msg_contnr";
            $(cl1).text("The phone No field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else {
            $('input[name=phone]').css('border', '1px solid #ccc');
        }
        if(emailAddress){
            if (!validateEmail(emailAddress)) {
                error = 1;
                let cl1 = ".customer_email_err_msg";
                let cl2 = ".customer_email_err_msg_contnr";
                $(cl1).text("Please enter valid email!");
                $(cl2).show(200).delay(6000).hide(200,function(){
                });
            }else{
                $('input[name=emailAddress]').css('border', '1px solid #ccc');
            }
        }
        if(gst_no == '') {
            error = 1;
            let cl1 = ".customer_gst_err_msg";
            let cl2 = ".customer_gst_err_msg_contnr";
            $(cl1).text("The GST No field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else if(!validateGST(gst_no)) {
            error = 1;
            let cl1 = ".customer_gst_err_msg";
            let cl2 = ".customer_gst_err_msg_contnr";
            $(cl1).text("Please enter valid GST No!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else {
            $('input[name=gst_no]').css('border', '1px solid #ccc');
        }

        if(error == 0) {
            let hidden_base_url = $("#hidden_base_url").val();
            $.ajax({
                url:hidden_base_url+'addCustomerByAjax',
                method:"GET",
                dataType:'json',
                data: {
                    name:name,
                    phone:phone,
                    emailAddress:emailAddress,
                    supAddress:supAddress,
                    note:note,
                    gst_no:gst_no
                },
                success:function(data){
                    $("#customer_id").html(data.html);
                    $("#customer_id").val(data.customer_id).change();
                    $("#customerModal").modal('hide');
                }
            });
        }

    });

});