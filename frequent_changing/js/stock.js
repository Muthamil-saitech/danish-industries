
(function ($) {
    ("use strict");
    let hidden_alert = $("#hidden_alert").val();
    let hidden_cancel = $("#hidden_cancel").val();
    let hidden_ok = $("#hidden_ok").val();
    $(document).on("click", "#add_product_to_cart", function () {
        let params = $("#productModal").val();
        let product_id = params.split("|")[0];
        let productName = params.split("|")[1];
        let quantity = $("#qty_modal_product").val();
        let checkExists = true;
        if (product_id == "") {
            $("#productModal").addClass("is-invalid");
            $(".productErr")
                .text("The Product field is required")
                .fadeIn()
                .delay(3000)
                .fadeOut();
        }

        if (quantity == "") {
            $("#qty_modal_product").addClass("is-invalid");
            $(".qtyErr")
                .text("The Quantity field is required")
                .fadeIn()
                .delay(3000)
                .fadeOut();
        }

        $(".rowCount").each(function () {
            let id = $(this).attr("data-id");
            if (Number(id) == Number(product_id)) {
                $("#productModal").addClass("is-invalid");
                $(".productErr")
                    .text("The Product Already added")
                    .fadeIn()
                    .delay(3000)
                    .fadeOut();
                checkExists = false;
            }
        });
        let rowCount = Number($(".rowCount").length);
        if (product_id != "" && quantity != "" && checkExists) {
            let html = "<tr class='rowCount' data-id='" + product_id + "'>";
            html += "<td>" + (rowCount + 1) + "</td>";
            //hidden product id
            html +=
                "<input type='hidden' name='product_id[]' value='" +
                product_id +
                "'>";
            //hidden quantity
            html +=
                "<input type='hidden' name='quantity[]' value='" +
                quantity +
                "'>";
            html += "<td>" + productName + "</td>";
            html += "<td>" + quantity + "</td>";
            html +=
                '<td class="text-end"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>';
            html += "</tr>";
            $("#stock_table").removeClass("d-none");
            $("#cart_data").append(html);
            $("#productModal").val("").trigger("change");
            $("#qty_modal_product").val("");
        }
    });

    /* $(document).on("change", "#mat_cat_id", function () {
        let mat_cat_id = $(this).find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val(); */
        /* if(mat_cat_id=="1") {
            $("#insert_mat_type_div").removeClass('d-none');
            $("#normal_mat_type_div").addClass('d-none');
            $("#mat_type").prop('disabled',true);
            $('#ins_type_div').show();
            $("#inp_mat_type").val("3");
            $("#inp_name_mat_type").val("Insert");
            $("#inp_name_mat_type").prop("disabled", true);
            $("#mat_type").removeAttr("name");
            $("#inp_mat_type").attr("name", "mat_type");
        } else {
            $("#insert_mat_type_div").addClass('d-none');
            $("#normal_mat_type_div").removeClass('d-none');
            $("#mat_type").prop('disabled',false);
            $('#ins_type_div').hide();
            $("#inp_mat_type").val("");
            $("#inp_name_mat_type").val("");
            $("#inp_name_mat_type").prop("disabled", false);
            $("#mat_type").attr("name", "mat_type");
            $("#inp_mat_type").removeAttr("name");
        } */
        /* $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialById",
            data: { id: mat_cat_id },
            dataType: "json",
            success: function (data) { 
                $(".add_tr").empty();
                $("#mat_id").val("").change();
                let raw_materials = data;
                let select = $("#mat_id");
                select.empty();
                select.append('<option value="">Please Select</option>');
                raw_materials.forEach(function (rm) {
                    if (rm) {
                        let id = rm.id;
                        let name = rm.name;
                        let code = rm.code;
                        select.append('<option value="' + id + '|'+ name +'|'+ code +'">' + name + ' ('+code+')'+'</option>');
                    }
                });
                $(".select2").select2();
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    }); */
    $(document).on("change", "#mat_id", function () {
        let mat_id = $(this).find(":selected").val();
        let parts = mat_id.split('|');
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialCatById",
            data: { mat_id: parts[0] },
            dataType: "json",
            success: function (data) {
                if(data) {
                    $("#mat_cat_id").val(data.id);
                    $("#mat_cat").val(data.name);
                }                
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
        let mat_cat_id = $("#mat_cat_id").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getInsertType",
            data: { mat_cat_id: mat_cat_id,mat_id: parts[0] },
            dataType: "json",
            success: function (data) {
                if(data) {
                    $("#old_mat_no").val(data.old_mat_no);
                    // $("#inp_ins_type").val(data.insert_type);
                    // $('#ins_type').val(data.insert_type).trigger('change');
                    // $('#ins_type').prop('disabled', true);
                    // if (data.insert_type == 1 || data.insert_type == 2) {
                    //     $('#ins_type_div').show();
                    // }
                    $("#old_mat_no_div").removeClass('d-none');
                }                
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
        $('#stock_type').val("").trigger('change.select2');
    });
    $(document).on("change", "#mat_type", function () {
        let mat_type = $(this).find(":selected").val();
        // console.log("mat_type",typeof(mat_type));
        if(mat_type === "1") {
            $("#cust_div").removeClass('d-none');
            $("#customer_id").val("").change();
        } else {
            $("#cust_div").addClass('d-none');
            $("#customer_id").val("");
        }  
        // $(".select2").select2();
        $('#stock_type').val("").trigger('change.select2');
    });
    $(document).on("change", "#stock_type", function (e) {
        let hidden_base_url = $("#hidden_base_url").val();
        let stock_type = $("#stock_type").val();
        var mat_id = $("#mat_id").val();
        var customer_id = $("#customer_id").val();    
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getStockReference",
            data: { stock_type: stock_type, mat_id: mat_id, customer_id: customer_id },
            dataType: "html",
            success: function (data) {
                if (typeof data === "string") {
                    data = JSON.parse(data);
                }
                if(data.type==="purchase") {
                    $("#reference_no").html(data.html);
                    $("#select_ref_no").removeClass("d-none");
                    $("#inp_ref_no_div").addClass("d-none");
                    $("#inp_ref_no").val("");
                    $("#current_stock").val("");
                } else {
                    $("#select_ref_no").addClass("d-none");
                    $("#inp_ref_no_div").removeClass("d-none");
                    $("#inp_ref_no").val(data.html);
                    $("#current_stock").val(data.qty);
                    $("#current_stock").attr("max", data.qty);
                }                
            },
            error: function () {
                console.log("error");
            },
        });
    });
    $(document).on("change", "#reference_no", function (e) {
        let selected = $(this).val();
        let split = selected.split('|');
        $("#current_stock").val(split[1]);
        $("#current_stock").attr("max", split[1]);
    });
    $("#current_stock").on("input", function () {
        let enteredQty = parseFloat($(this).val());
        let maxQty = parseFloat($(this).attr("max"));
        if (enteredQty > maxQty) {
            $(this).val(maxQty);
            showErrorMessage("current_stock", "Stock cannot exceed ordered quantity.");
        } else {
            $("#current_stock").removeClass("is-invalid");
            $("#current_stock").closest("div").find(".text-danger").addClass("d-none");
        }
    });
    $("#material_stock_form").submit(function () {
        let status = true;
        let mat_cat_id = $("#mat_cat_id").val();
        let mat_id = $("#mat_id").val();
        let unit_id = $("#unit_id").val();
        let stock_type = $("#stock_type").val();
        let dc_no = $("#dc_no").val();
        let heat_no = $("#heat_no").val();
        let dc_date = $("#dc_date").val();
        let reference_no = "";
        if (stock_type === "purchase") {
            reference_no = $("#reference_no").val().split('|')[0];
        } else if (stock_type === "customer") {
            reference_no = $("#inp_ref_no").val();
        }

        // Set final reference_no in hidden field
        $("#reference_no_hidden").val(reference_no);
         
        let mat_type = $("#mat_type").val();
        let customer_id = $('#customer_id').val();
        let current_stock = $('#current_stock').val();
        if(mat_cat_id == "") {
            status = false;
            showErrorMessage("mat_cat_id", "The Material Category field is required");
        }else{
            $("#mat_cat_id").removeClass("is-invalid");
            $("#mat_cat_id").closest("div").find(".text-danger").addClass("d-none");
        }

        if(dc_no == "") {
            status = false;
            showErrorMessage("dc_no", "The Customer DC No field is required");
        }else{
            $("#dc_no").removeClass("is-invalid");
            $("#dc_no").closest("div").find(".text-danger").addClass("d-none");
        }

        if(heat_no == "") {
            status = false;
            showErrorMessage("heat_no", "The Heat No field is required");
        }else{
            $("#heat_no").removeClass("is-invalid");
            $("#heat_no").closest("div").find(".text-danger").addClass("d-none");
        }

        if(dc_date == "") {
            status = false;
            showErrorMessage("dc_date", "The DC Date field is required");
        }else{
            $("#dc_date").removeClass("is-invalid");
            $("#dc_date").closest("div").find(".text-danger").addClass("d-none");
        }

        if(unit_id == "") {
            status = false;
            showErrorMessage("unit_id", "The Unit field is required");
        }else{
            $("#unit_id").removeClass("is-invalid");
            $("#unit_id").closest("div").find(".text-danger").addClass("d-none");
        }

        if(mat_id == "") {
            status = false;
            showErrorMessage("mat_id", "The Material field is required");
        }else{
            $("#mat_id").removeClass("is-invalid");
            $("#mat_id").closest("div").find(".text-danger").addClass("d-none");
        }

        if(mat_type == "") {
            status = false;
            showErrorMessage("mat_type", "The Material Type field is required");
        }else{
            $("#mat_type").removeClass("is-invalid");
            $("#mat_type").closest("div").find(".text-danger").addClass("d-none");
        }

        if(mat_type == "1" && customer_id == "") {
            status = false;
            showErrorMessage("customer_id", "The Customer field is required, if the Material Type is Material");
        }else{
            $("#customer_id").removeClass("is-invalid");
            $("#customer_id").closest("div").find(".text-danger").addClass("d-none");
        }

        if(stock_type == "") {
            status = false;
            showErrorMessage("stock_type", "The Stock Type field is required");
        }else{
            $("#stock_type").removeClass("is-invalid");
            $("#stock_type").closest("div").find(".text-danger").addClass("d-none");
        }

        if (reference_no === "") {
            status = false;
            if (stock_type === "purchase") {
                showErrorMessage("reference_no", "The PO Number field is required");
            } else {
                showErrorMessage("inp_ref_no", "The PO Number field is required");
            }
        } else {
            clearError("reference_no");
            clearError("inp_ref_no");
        }

        if(current_stock == "") {
            status = false;
            showErrorMessage("current_stock", "The Stock field is required");
        }else{
            $("#current_stock").removeClass("is-invalid");
            $("#current_stock").closest("div").find(".text-danger").addClass("d-none");
        }

        // if(close_qty == "") {
        //     status = false;
        //     showErrorMessage("close_qty", "The Alert Level field is required");
        // }else{
        //     $("#close_qty").removeClass("is-invalid");
        //     $("#close_qty").closest("div").find(".text-danger").addClass("d-none");
        // }

        if (status == false) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }
    });

    function showErrorMessage(id, message) {
        $("#" + id).addClass("is-invalid");
        const group = $("#" + id).closest(".form-group");
        const errorBox = group.find(".text-danger");
        errorBox.text(message);
        errorBox.removeClass("d-none");
    }

    function clearError(fieldId) {
        $("#" + fieldId).removeClass("is-invalid");
        $("#" + fieldId).closest("div").find(".text-danger").addClass("d-none");
    }

    // Delete dlt_button
    $(document).on("click", ".dlt_button", function () {
        $(this).closest("tr").remove();
    });

    
})(jQuery);
