$(document).ready(function(){
    "use strict";
    /**
     * @description This function is used to check the email validation
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

    $("#opening_balance_type").select2({
        dropdownParent: $("#supplierModal"),
    });

    $(document).on('click', '#addSupplier', function(e){
		let name = $('input[name=name]').val();
		// let contact_person = $('input[name=contact_person]').val();
		let phone = $('input[name=phone]').val();
		let emailAddress = $('input[name=emailAddress]').val();
        let gst_no = $('input[name=gst_no]').val();
		// let credit_limit = $('input[name=credit_limit]').val();
        // let openingBalance = $("input[name=opening_balance]").val();
        // let opening_balance_type = $("#opening_balance_type").val();
		let supAddress = $('textarea[name=supAddress]').val();
		let note = $("textarea[name=suppNote]").val();
		let error = 0;
		if(name == '') {
			error = 1;
            let cl1 = ".supplier_err_msg";
            let cl2 = ".supplier_err_msg_contnr";
            $(cl1).text("The Name field is required!");            
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=name]').css('border', '1px solid #ccc');
		}

		if(phone == '') {
            error = 1;
            let cl1 = ".customer_phone_err_msg";
            let cl2 = ".customer_phone_err_msg_contnr";
            $(cl1).text("The Phone field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
		} else {
			$('input[name=phone]').css('border', '1px solid #ccc');
		}
		if(emailAddress){
            if (!validateEmail(emailAddress)) {
                error = 1;
                let cl1 = ".supplier_email_err_msg";
                let cl2 = ".supplier_email_err_msg_contnr";
                $(cl1).text("Please enter valid email!");
                $(cl2).show(200).delay(6000).hide(200,function(){
                });
            }else{
                $('input[name=emailAddress]').css('border', '1px solid #ccc');
            }
		}
        if(gst_no == '') {
            error = 1;
            let cl1 = ".supplier_gst_err_msg";
            let cl2 = ".supplier_gst_err_msg_contnr";
            $(cl1).text("The GST No field is required!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else if(!validateGST(gst_no)) {
            error = 1;
            let cl1 = ".supplier_gst_err_msg";
            let cl2 = ".supplier_gst_err_msg_contnr";
            $(cl1).text("Please enter valid GST No!");
            $(cl2).show(200).delay(6000).hide(200,function(){
            });
        } else {
            $('input[name=gst_no]').css('border', '1px solid #ccc');
        }


		if(error == 0) {
            let hidden_base_url = $("#hidden_base_url").val();
			$.ajax({
				url:hidden_base_url+'addSupplierByAjax',
				method:"GET",
				dataType:'json',
				data: {
                    name:name,
                    // contact_person:contact_person,
					phone:phone,
                    emailAddress:emailAddress,
                    supAddress:supAddress,
                    gst_no:gst_no,
                    // credit_limit:credit_limit,
                    note:note,
                    // opening_balance:openingBalance,
                    // opening_balance_type:opening_balance_type
				},
				success:function(data){
					$("#supplier_id").html(data.html);
					$("#supplier_id").val(data.supplier_id).change();
					$("#supplierModal").modal('hide');
				}
			});
		}

	});
    let default_currency = $("#default_currency").val();
    $(document).on("change", "#supplier", function(){
        let p = $(this).find(":selected").val();
        let params = p.split("|");
        $("#supplier_id").val(params[0]);
        $(".due_balance_show").removeClass('d-none');
        let msg = 'Due Balance: ';
        msg += default_currency + Math.abs(params[1]);
        if (Math.abs(params[1]) !== 0) {
            msg += `(${params[1] < 0 ? "Debit" : "Credit"})`;
        }

        $(".due_balance_show").html(msg);
    });

});