$(document).ready(function () {
    "use strict";
    $('#challan_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date()
    }).datepicker('update', new Date());
    $('#sale_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date()
    }).datepicker('update', new Date());
    let hidden_alert = $("#hidden_alert").val();
    let hidden_cancel = $("#hidden_cancel").val();
    let hidden_ok = $("#hidden_ok").val();
    $(document).on("keydown", ".discount", function (e) {
        let keys = e.charCode || e.keyCode || 0;
        return (
            keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105)
        );
    });

    $(document).on("keyup", ".discount", function (e) {
        let input = $(this).val();
        let ponto = input.split(".").length;
        let slash = input.split("-").length;
        if (ponto > 2) $(this).val(input.substr(0, input.length - 1));
        $(this).val(input.replace(/[^0-9.%]/, ""));
        if (slash > 2) $(this).val(input.substr(0, input.length - 1));
        if (ponto == 2) $(this).val(input.substr(0, input.indexOf(".") + 4));
        if (input == ".") $(this).val("");
    });

    $("#customerModal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    /**
     * @description This function is used to set the attribute of the element
     */
    function setAttribute() {
        let i = 1;
        $(".set_sn").each(function () {
            $(this).html(i);
            i++;
        });
        i = 1;
        $(".unit_price_c").each(function () {
            $(this).attr("id", "unit_price_" + i);
            i++;
        });
        i = 1;
        $(".qty_c").each(function () {
            $(this).attr("id", "qty_" + i);
            i++;
        });
        i = 1;
        $(".total_c").each(function () {
            $(this).attr("id", "total_" + i);
            i++;
        });
    }

    /**
     * @description This function is used to calculate the row
     */
    function cal_sale_row() {
        let row_total_total = 0;
        $(".sale_price_c").each(function () {
            let price = parseFloat($(this).val());
            if (!isNaN(price)) {
                row_total_total += price;
            }
        });
        let paid = parseFloat($("#paid").val()) || 0;
        let other_amount = parseFloat($("#other").val()) || 0;
        let disc = $.trim($("#discount").val());
        let totalDiscount = 0;
        if (disc !== "") {
            if (disc.includes("%")) {
                let percent = parseFloat(disc.replace("%", ""));
                if (!isNaN(percent)) {
                    totalDiscount = row_total_total * (percent / 100);
                }
            } else {
                let flatDisc = parseFloat(disc);
                if (!isNaN(flatDisc)) {
                    totalDiscount = flatDisc;
                }
            }
        }
        let grand_total = row_total_total + other_amount - totalDiscount;
        if (isNaN(grand_total)) grand_total = 0;
        $("#subtotal").val(row_total_total.toFixed(2));
        $("#sgrand_total").val(grand_total.toFixed(2));
        let due = grand_total - paid;
        $("#due").val(due.toFixed(2));
    }
    /* dc cal row */
    function cal_row() {
        let i = 1;
        let row_tatal_total = 0;
        let other_amount = Number($("#other").val());
        let subtotal = Number($("#subtotal").val());

        //foraddDiscount
        let disc = $("#discount").val();
        let totalDiscount = 0;
        if (
            $.trim(disc) == "" ||
            $.trim(disc) == "%" ||
            $.trim(disc) == "%%" ||
            $.trim(disc) == "%%%" ||
            $.trim(disc) == "%%%%"
        ) {
            totalDiscount = 0;
        } else {
            let Disc_fields = disc.split("%");
            let discAmount = Disc_fields[0];
            let discP = Disc_fields[1];

            if (discP == "") {
                totalDiscount =
                    row_tatal_total * (parseFloat($.trim(discAmount)) / 100);
            } else {
                if (!disc) {
                    discAmount = 0;
                }
                totalDiscount = parseFloat(discAmount);
            }
        }
        $("#grand_total").val(
            (subtotal + other_amount - totalDiscount).toFixed(2)
        );
    }

    /**
     * @description This function is used to invoice print
     */
    function invoicePrint() {
        window.print();
    }

    $(document).on("keyup", ".invoicePrint", function (e) {
        invoicePrint();
    });

    $(document).on("click", ".invoicePrint", function (e) {
        invoicePrint();
    });

    $(document).on("focus", ".invoicePrint", function (e) {
        invoicePrint();
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr("content"),
        },
    });

    // Update qty_modal when sale_qty inputs change
    $(document).on("input", ".sale_qty", function () {
        let totalQty = 0;
        $(".sale_qty").each(function () {
            let qty = parseFloat($(this).val()) || 0;
            let currentStock = parseFloat(
                $(this).closest("tr").find(".current_stock").val()
            );

            // Ensure qty doesn't exceed current stock
            if (qty > currentStock) {
                qty = currentStock;
                $(this).val(currentStock);
            }

            totalQty += qty;
        });

        // Update qty_modal with the total quantity
        $("#qty_modal").val(totalQty);
    });

    // Prevent manual editing of qty_modal when using batch control
    $("#qty_modal").on("focus", function () {
        if ($("#item_st_method").val() === "batchcontrol") {
            $(this).blur();
        }
    });

    $(document).on("click", "#addToCart", function (e) {
        e.preventDefault();
        let unit_price = $(".unit_price_modal").val();
        let qty_modal = $("#qty_modal").val();
        let item_unit_modal = $("#item_unit_modal").val();
        let item_id_modal = $("#item_id_modal").val();
        let item_currency_modal = $("#item_currency_modal").val();
        let params = $("#item_params").val();

        let st_method = $("#item_st_method").val();

        let item_details_array = params.split("|");
        let product_id = item_details_array[0];
        let current_stock = item_details_array[7];
        let item_name_modal = item_details_array[1];
        let batch_number = [];
        let batch_qty = [];
        let manufacture_id = [];
        if (st_method == "batchcontrol") {
            $(".batch_no").each(function () {
                batch_number.push($(this).val());
            });
            $(".sale_qty").each(function () {
                batch_qty.push($(this).val());
            });
            $(".manufacture_id").each(function () {
                manufacture_id.push($(this).val());
            });
        } else {
            batch_number = "";
        }
        if (st_method == "fifo" || st_method == "fefo") {
            let q = Number(qty_modal);
            let s = Number(current_stock);
            if (q > s) {
                let hidden_alert = $("#hidden_alert").val();
                let hidden_cancel = $("#hidden_cancel").val();
                let hidden_ok = $("#hidden_ok").val();
                swal({
                    title: hidden_alert + "!",
                    text:
                        "Quantity Not grater than Stock. This product current stock is " +
                        current_stock,
                    cancelButtonText: hidden_cancel,
                    confirmButtonText: hidden_ok,
                    confirmButtonColor: "#3c8dbc",
                });
                $("#product_id").val("").change();
                $("#cartPreviewModal").modal("hide");
                return;
            }

            let hidden_base_url = $("#hidden_base_url").val();

            let method_base_url = "";

            if (st_method == "fifo")
                method_base_url = hidden_base_url + "getFifoFProduct";

            if (st_method == "fefo")
                method_base_url = hidden_base_url + "getFefoFProduct";

            $.ajax({
                type: "POST",
                url: method_base_url,
                data: {
                    id: product_id,
                    unit_price: unit_price,
                    quantity: qty_modal,
                    item_id_modal: item_id_modal,
                    item_currency_modal: item_currency_modal,
                    item_unit_modal: item_unit_modal,
                },
                success: function (html) {
                    console.log(html);

                    let check_exist = true;

                    $(".rowCount").each(function () {
                        let id = $(this).attr("data-id");
                        if (Number(id) == Number(item_id_modal)) {
                            check_exist = false;
                        }
                    });

                    if (check_exist == true) {
                        if (item_id_modal) {
                            $(".add_tr").append(html);
                            setAttribute();
                            cal_row();
                            $("#product_id").val("").change();
                            $("#cartPreviewModal").modal("hide");
                            $("#fifoPreviewModal").modal("hide");
                            return false;
                        }
                    } else {
                        let hidden_alert = $("#hidden_alert").val();
                        let hidden_cancel = $("#hidden_cancel").val();
                        let hidden_ok = $("#hidden_ok").val();
                        swal({
                            title: hidden_alert + "!",
                            text: "This Finish Product already added",
                            cancelButtonText: hidden_cancel,
                            confirmButtonText: hidden_ok,
                            confirmButtonColor: "#3c8dbc",
                        });
                        $("#product_id").val("").change();
                        return false;
                    }
                },
                error: function () {},
            });
        } else {
            if (st_method == "batchcontrol") {
                batch_number.forEach((batch, index) => {
                    if (
                        batch_qty[index] != "" &&
                        !isNaN(batch_qty[index]) &&
                        batch_qty[index] != 0
                    ) {
                        appendCart(
                            item_id_modal,
                            item_name_modal,
                            item_currency_modal,
                            item_unit_modal,
                            unit_price,
                            batch_qty[index],
                            product_id,
                            current_stock,
                            batch,
                            st_method,
                            manufacture_id[index]
                        );
                    }
                });
            } else {
                appendCart(
                    item_id_modal,
                    item_name_modal,
                    item_currency_modal,
                    item_unit_modal,
                    unit_price,
                    qty_modal,
                    product_id,
                    current_stock,
                    batch_number,
                    st_method,
                );
            }
        }
    });
    /**
     * @description This function is used to append the cart
     * @param {*} item_id_modal
     * @param {*} item_name_modal
     * @param {*} item_currency_modal
     * @param {*} item_unit_modal
     * @param {*} unit_price
     * @param {*} qty_modal
     * @param {*} product_id
     * @returns
     */
    function appendCart(
        item_id_modal,
        item_name_modal,
        item_currency_modal,
        item_unit_modal,
        unit_price,
        qty_modal,
        product_id,
        current_stock,
        batch_no,
        st_method,
        manufacture_id = null
    ) {
        let q = Number(qty_modal);
        let s = Number(current_stock);
        if (q > s) {
            let hidden_alert = $("#hidden_alert").val();
            let hidden_cancel = $("#hidden_cancel").val();
            let hidden_ok = $("#hidden_ok").val();
            swal({
                title: hidden_alert + "!",
                text:
                    "Quantity Not grater than Stock. This product current stock is " +
                    current_stock,
                cancelButtonText: hidden_cancel,
                confirmButtonText: hidden_ok,
                confirmButtonColor: "#3c8dbc",
            });
            $("#product_id").val("").change();
            $("#cartPreviewModal").modal("hide");
            return;
        }
        let html = `<tr class="rowCount" data-id="${item_id_modal}" data-batch="${batch_no}">
                <td class="width_1_p text-start"><p class="set_sn">1</p></td>
                <td>
                    <input type="hidden" class="current_stock" value="${current_stock}" name="current_stock[]">
                    <input type="hidden" value="${product_id}" name="selected_product_id[]">
                    <input type="hidden" value="${manufacture_id}" name="rm_id[]">
                    <input type="hidden" value="${manufacture_id}" name="manufacture_id[]">
                    <span>${item_name_modal}${
            batch_no ? `<br><small>Batch No: ${batch_no}</small>` : ""
        }</span>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" tabindex="5" name="unit_price[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning unit_price_c cal_row" placeholder="Unit Price" value="${unit_price}">
                        <span class="input-group-text">${item_currency_modal}</span>
                    </div>
                    <span class='text-danger'></span>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" data-countid="1" tabindex="51" id="quantity_amount_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning qty_c cal_row" value="${qty_modal}" placeholder="Qty/Amount">
                        <span class="input-group-text">${item_unit_modal}</span>
                    </div>
                    <span class='text-danger'></span>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" id="total_1" name="total[]" class="form-control input_aligning total_c" placeholder="Total" readonly="">
                        <span class="input-group-text">${item_currency_modal}</span>
                    </div>
                </td>
                <td class="ir_txt_center">
                    <a class="btn btn-xs del_row dlt_button">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                    </a>
                </td>
            </tr>`;

        let check_exist = true;

        $(".rowCount").each(function () {
            let id = $(this).attr("data-id");
            let batch = $(this).attr("data-batch");
            if (st_method == "batchcontrol") {
                if (Number(id) == Number(item_id_modal) && batch == batch_no) {
                    check_exist = false;
                }
            } else {
                if (Number(id) == Number(item_id_modal)) {
                    check_exist = false;
                }
            }
        });

        if (check_exist == true) {
            if (item_id_modal) {
                $(".add_tr").append(html);
                setAttribute();
                cal_row();
                $("#product_id").val("").change();
                $("#cartPreviewModal").modal("hide");
                $("#fifoPreviewModal").modal("hide");
                return false;
            }
        } else {
            let hidden_alert = $("#hidden_alert").val();
            let hidden_cancel = $("#hidden_cancel").val();
            let hidden_ok = $("#hidden_ok").val();
            swal({
                title: hidden_alert + "!",
                text: "This Finish Product already added",
                cancelButtonText: hidden_cancel,
                confirmButtonText: hidden_ok,
                confirmButtonColor: "#3c8dbc",
            });
            $("#product_id").val("").change();
            return false;
        }
    }

    $(document).on("keyup", ".qty_c", function () {
        let current_stock = Number(
            $(this).closest("tr").find(".current_stock").val()
        );
        let qty = Number($(this).val());
        console.log(current_stock, qty);
        if (qty > current_stock) {
            let hidden_alert = $("#hidden_alert").val();
            let hidden_cancel = $("#hidden_cancel").val();
            let hidden_ok = $("#hidden_ok").val();
            swal({
                title: hidden_alert + "!",
                text:
                    "Quantity Not grater than Stock. This product current stock is " +
                    current_stock,
                cancelButtonText: hidden_cancel,
                confirmButtonText: hidden_ok,
                confirmButtonColor: "#3c8dbc",
            });
            $(this).val(current_stock);
        }
        cal_row();
    });

    $(document).on("click", ".del_row", function (e) {
        $(this).parent().parent().remove();
        setAttribute();        
        cal_row();
    });

    $(document).on("keyup", ".cal_row", function (e) {
        cal_row();
    });

    $(document).on("click", ".cal_row", function (e) {
        cal_row();
    });

    $(document).on("focus", ".cal_row", function (e) {
        cal_row();
    });

    $(document).on("keyup", ".cal_sale_row", function (e) {
        cal_sale_row();
    });

    $(document).on("click", ".cal_sale_row", function (e) {
        cal_sale_row();
    });

    $(document).on("focus", ".cal_sale_row", function (e) {
        cal_sale_row();
    });

    $(document).on("change", "#challan_id", function () {
        let current = $(this);
        let challan_id = current.find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getChallanDetails",
            data: { id: challan_id },
            dataType: "json",
            success: function (data) {  
                let main = data[0];
                let products = main.products;
                let customer_id = main.customer_id;
                $("#customer_id").val(customer_id);
                let customer_data = main.customer_name+'('+main.customer_code+')';
                $("#customer_data").val(customer_data);
                $(".add_tr").empty();
                let select = $("#product_id");
                select.empty();
                select.append('<option value="">Select</option>');
                products.forEach(function (pr) {
                    if (pr.product_id) {
                        let product_id = pr.product_id;
                        let product_name = pr.product_name;
                        let product_code = pr.product_code;
                        let quantity = pr.quantity;
                        let sale_price = pr.sale_price;
                        let order_id = pr.order_id;
                        let unit = pr.unit;
                        let manufacture_id = pr.manufacture_id;
                        select.append('<option value="' + product_id + '|' + order_id + '|' + product_name + '|' + sale_price + '|' + quantity+ '|' + product_code + '|' + unit + '|' + manufacture_id + '">' + product_name + '(' + product_code + ')'+'</option>');
                    }
                });
                $(".select2").select2();
            },
            error: function (xhr, status, error) {
                console.log("XHR:", xhr.responseText);
                console.log("Status:", status);
                console.log("Error:", error);
            },
        });
    });
    $(document).on("change", "#product_id", function () {
        let selected = $(this).find(":selected");
        if (!selected.val()) return;
        let product = selected.val();
        if(product!=""){
            let product_arr = product.split("|");
            let product_id = product_arr[0];
            let order_id = product_arr[1];
            let product_name = product_arr[2];
            let sale_price = product_arr[3];
            let quantity = product_arr[4];
            let product_code = product_arr[5];
            let unit = product_arr[6];
            let manufacture_id = product_arr[7];
            let is_duplicate = false;
            $(".rowCount").each(function () {
                let existing_product_id = $(this).find('input[name="selected_product_id[]"]').val();
                if (Number(existing_product_id) === Number(product_id)) {
                    is_duplicate = true;
                    return false; // break
                }
            });

            if (is_duplicate) {
                swal({
                    title: "Alert!",
                    text: "This product is already added.",
                    icon: "warning",
                    button: "OK",
                });
                $(this).val("").trigger("change");
                return;
            }
            let hidden_base_url = $("#hidden_base_url").val();
            $.ajax({
                type: "POST",
                url: hidden_base_url + "getPaidAmount",
                data: { order_id: order_id },
                dataType: "json",
                success: function (data) {
                    let pay_amount = data[0].pay_amount;
                    let balance_amount = data[0].balance_amount;
                    $("#paid").val(pay_amount);
                    $("#due").val(balance_amount);
                },
                error: function (xhr, status, error) {
                    console.log("XHR:", xhr.responseText);
                    console.log("Status:", status);
                    console.log("Error:", error);
                },
            });
            let html = `<tr class="rowCount" data-id="${item_id_modal}">
                <td class="width_1_p text-start"><p class="set_sn">1</p></td>
                <td>
                    <input type="hidden" value="${order_id}" name="order_id[]" data-id="${order_id}">
                    <input type="hidden" value="${product_id}" name="selected_product_id[]" data-id="${product_id}">
                    <input type="hidden" value="${manufacture_id}" name="manufacture_id[]" data-id="${manufacture_id}">
                    <span>${product_name}(${product_code})</span>
                </td>
                <td>
                    <input type="text" name="srn[]" class="check_required form-control" placeholder="SRN">
                </td>
                <td>
                    <div class="input-group">
                        <input type="hidden" name="sale_price[]" class="check_required form-control integerchk input_aligning sale_price_c cal_sale_row" value="${sale_price}" placeholder="Unit Price">
                        <p>₹${sale_price}</p>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="hidden" name="quantity[]" class="check_required form-control integerchk input_aligning qty_c cal_sale_row" value="${quantity}" placeholder="Qty">
                        <p>${quantity}${unit}</p>
                    </div>
                </td>
                <td class="ir_txt_center">
                    <a class="btn btn-xs del_row dlt_button">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                    </a>
                </td>
            </tr>`;
            $(".add_tr").append(html);
            setAttribute();
            cal_sale_row();
            $(this).val("").trigger("change");
        }
    });
    // $(document).on("change", "#product_id", function (e) {
    //     let params = $(this).find(":selected").val();
    //     if (params != "") {
    //         let separate_params = params.split("|");
    //         let hidden_base_url = $("#hidden_base_url").val();
    //         let st_method = separate_params[6];
    //         $("#batch_sec").addClass("d-none");
    //         $("#qty_modal").val("");
    //         $("#batch_no").val("");
    //         let item_details_array = params.split("|");
    //         console.log("item_details_array",item_details_array);
            
    //         $("#item_id_modal").val(item_details_array[0]);
    //         let stock_with_unit =
    //             item_details_array[7] + " " + item_details_array[4];
    //         $("#item_stock_modal").text(stock_with_unit);
    //         $("#item_name_modal").text(item_details_array[1]);
    //         $("#item_currency_modal").val(item_details_array[5]);
    //         $("#item_unit_modal").val(item_details_array[4]);
    //         $(".modal_unit_name").html(item_details_array[4]);
    //         $(".unit_price_modal").val(item_details_array[3]);
    //         $("#item_st_method").val(st_method);
    //         $("#item_params").val(params);
    //         if (st_method == "batchcontrol") {
    //             $("#batch_sec").removeClass("d-none");
    //             $.ajax({
    //                 url: hidden_base_url + "getBatchControlProduct",
    //                 method: "GET",
    //                 data: {
    //                     product_id: item_details_array[0],
    //                 },
    //                 success: function (response) {
    //                     let data = JSON.parse(response);
    //                     let html = "";
    //                     for (let i = 0; i < data.length; i++) {
    //                         html += `<tr>
    //                             <td>${data[i].batch_no} </td>
    //                             <td>${data[i].product_quantity} ${item_details_array[4]}</td>
    //                             <input type="hidden" class="current_stock" value="${data[i].product_quantity}">
    //                             <input type="hidden" class="batch_no" value="${data[i].batch_no}">
    //                             <input type="hidden" class="manufacture_id" value="${data[i].id}">
    //                             <td>
    //                                 <div class="input-group">
    //                                     <input type="number" class="form-control sale_qty" name="sale_qty[]" placeholder="Sale Qty">
    //                                     <span class="input-group-text">${item_details_array[4]}</span>
    //                                 </div>
    //                             </td>
    //                         </tr>`;
    //                     }
    //                     $("#batch_table_body").html(html);
    //                 },
    //             });
    //         }
    //         $("#cartPreviewModal").modal("show");
    //     }
    // });

    $("#sale_form").submit(function (e) {
        let status = true;
        let focus = 1;
        // let code = $("#code").val();
        let customer_id = $("#customer_id").val();
        let challan_id = $("#challan_id").val();
        let customDatepicker = $(".customDatepicker").val();
        let statusField = $("#status").val();
        let product_id = $("#product_id").val();
        let paid = $("#paid").val();
        let accounts = $("#accounts").val();
        let date = $("#sale_date").val();

        if (date == "") {
            status = false;
            showErrorMessage("date", "The Sale Date field is required");
        } else {
            $("#date").removeClass("is-invalid");
            $("#date").closest("div").find(".text-danger").addClass("d-none");
        }

        /* if (code == "") {
            status = false;
            showErrorMessage("code", "The Reference No field is required");
        } else {
            $("#code").removeClass("is-invalid");
            $("#code").closest("div").find(".text-danger").addClass("d-none");
        } */

        if (customer_id == "") {
            status = false;
            $("#customer_id").addClass("is-invalid");
            $(".customerErr").text("The Customer field is required");
            $(".customerErr").removeClass("d-none");
        } else {
            $("#customer_id").removeClass("is-invalid");
            $(".customerErr").addClass("d-none");
        }

        if (challan_id == "") {
            status = false;
            $("#challan_id").addClass("is-invalid");
            $(".chlnoErr").text("The DC No field is required");
            $(".chlnoErr").removeClass("d-none");
        } else {
            $("#challan_id").removeClass("is-invalid");
            $(".chlnoErr").addClass("d-none");
        }

        /* if (paid == "") {
            status = false;
            $("#paid").addClass("is-invalid");
            let closestDiv = $(".paidErr");
            closestDiv.text("The Paid field is required");
            closestDiv.removeClass("d-none");
        } else {
            $("#paid").removeClass("is-invalid");
            $(".paidErr").addClass("d-none");
        } */
        

        let rowCount = $(".rowCount").length;
        if (!Number(rowCount)) {
            status = false;
            $("#purchase_cart .add_tr").html(
                '<tr><td colspan="6" class="text-danger errProduct">Add minimum one part name</td></tr>'
            );
        } else {
            $("#purchase_cart .add_tr").removeClass("errProduct");
        }

        if (status == true) {
            /* let customer_credit_limit = $(".customer_credit_limit").val();
            let customer_prevoius_due = $(".customer_previous_due").val();
            let customer_current_due = $(".customer_current_due").val();
            let total_due =
                Number(customer_prevoius_due) + Number(customer_current_due);
            if(isNaN(total_due)){
                total_due = 0;
            }
            console.log(customer_current_due,customer_credit_limit,customer_prevoius_due,total_due);
            let quotation_page = $("#quotation_page").val();
            if(quotation_page == 0){
                if (total_due <= customer_credit_limit) {
                    return true;
                } else {
                    swal({
                        title: hidden_alert + "!",
                        text: "Customer Credit Limit Exceeds",
                        cancelButtonText: hidden_cancel,
                        confirmButtonText: hidden_ok,
                        confirmButtonColor: "#3c8dbc",
                    });
                    return false;
                }
            }else{
                return true;
            } */
           return true;
        } else {
            return false;
        }
    });

    $("#dc_form").submit(function (e) {
        let status = true;
        let challan_no = $("#challan_no").val();
        let material_doc_no = $("#material_doc_no").val();
        let customer_id = $("#dccustomer_id").val();
        let customer_address = $("#customer_address").val();
        let customDatepicker = $(".customDatepicker").val();
        let date = $("#challan_date").val();

        if (date == "") {
            status = false;
            showErrorMessage("date", "The Date field is required");
        } else {
            $("#date").removeClass("is-invalid");
            $("#date").closest("div").find(".text-danger").addClass("d-none");
        }

        if (challan_no == "") {
            status = false;
            showErrorMessage("challan_no", "The Challan No field is required");
        } else {
            $("#challan_no").removeClass("is-invalid");
            $("#challan_no").closest("div").find(".text-danger").addClass("d-none");
        }

        if (material_doc_no == "") {
            status = false;
            showErrorMessage("material_doc_no", "The Material Document No field is required");
        } else {
            $("#material_doc_no").removeClass("is-invalid");
            $("#material_doc_no").closest("div").find(".text-danger").addClass("d-none");
        }

        if (customer_address == "") {
            status = false;
            showErrorMessage("customer_address", "The Delivery Address field is required");
        } else {
            $("#customer_address").removeClass("is-invalid");
            $("#customer_address").closest("div").find(".text-danger").addClass("d-none");
        }

        if (customer_id == "") {
            status = false;
            $("#dccustomer_id").addClass("is-invalid");
            $(".customerErr").text("The Customer field is required");
            $(".customerErr").removeClass("d-none");
        } else {
            $("#dccustomer_id").removeClass("is-invalid");
            $(".customerErr").addClass("d-none");
        }

        if (customDatepicker == "") {
            status = false;
            showErrorMessage("customDatepicker", "The Date field is required");
        } else {
            $("#customDatepicker").removeClass("is-invalid");
            $("#customDatepicker")
                .closest("div")
                .find(".text-danger")
                .addClass("d-none");
        }
        // $("input[name='price[]']").each(function () {
        //     let finalPrice = $(this).val();
        //     if (finalPrice === "") {
        //          status = false;
        //         showErrorMessage("finalPrice", "The Rate field is required");
        //     } else {
        //         $("#finalPrice").removeClass("is-invalid");
        //         $("#finalPrice")
        //             .closest("div")
        //             .find(".text-danger")
        //             .addClass("d-none");
        //     }
        // });

        let rowCount = $(".rowCount").length;
        if (!Number(rowCount)) {
            status = false;
            $("#purchase_cart .add_tr").html(
                '<tr><td colspan="6" class="text-danger errProduct">Add minimum one product</td></tr>'
            );
        } else {
            $("#purchase_cart .add_tr").removeClass("errProduct");
        }
        if (status == true) {
            return true;
        } else {
            return false;
        }
    });

    function showErrorMessage(id, message) {
        $("#" + id + "").addClass("is-invalid");
        let closestDiv = $("#" + id + "")
            .closest("div")
            .find(".text-danger");
        closestDiv.text(message);
        closestDiv.removeClass("d-none");
    }

    setAttribute();
    cal_row();

    $("#pull_low_stock_products").on("click", function () {
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            url: hidden_base_url + "getLowRMStock",
            method: "GET",
            success: function (response) {
                $(".add_tr").empty();
                $(".add_tr").append(response);
                $("#populate_click").val("clicked");
                setAttribute();
                cal_row();
            },
            error: function () {
                alert("error");
            },
        });
    });
    $(document).on("change","#dccustomer_id", function () {
        let hidden_base_url = $("#hidden_base_url").val();
        let customer_id = $("#dccustomer_id").val();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: hidden_base_url + "getCustomerDetail",
            data: {
                id: customer_id,
            },
            success: function (data) {
                $("#customer_gst").val(data.gst_no);
                $("#customer_address").val(data.address);
                $(".select2").select2();
            },
        });
        $.ajax({
            type: "POST",
            dataType: "html",
            url: hidden_base_url + "getCustomerProductionProducts",
            data: {
                id: customer_id,
            },
            success: function (data) {
                $(".add_tr").empty();
                $("#dcproduct_id").html(data);
                $(".select2").select2();
            },
        });
    });

    $(document).on("change", "#dcproduct_id", function (e) {
        let selectedOptions = $(this).find(":selected");
        let hidden_base_url = $("#hidden_base_url").val();

        // Step 1: Get selected product IDs
        let selectedProductIds = [];
        selectedOptions.each(function () {
            let val = $(this).val();
            if (val) {
                let parts = val.split("|");
                selectedProductIds.push(parts[0]); // only product_id
            }
        });

        // Step 2: Remove unselected rows
        $(".add_tr .rowCount").each(function () {
            let rowProductId = $(this).data("id").toString();
            if (!selectedProductIds.includes(rowProductId)) {
                $(this).remove();
            }
        });

        // Step 3: Add only missing selected rows
        selectedOptions.each(function () {
            let params = $(this).val();
            if (params !== "") {
                let item_details_array = params.split("|");
                let productId = item_details_array[0];

                if ($(`.rowCount[data-id='${productId}']`).length > 0) {
                    return; // already added
                }

                $.ajax({
                    url: hidden_base_url + "getProductDetails",
                    method: "GET",
                    data: {
                        product_id: item_details_array[0],
                        customer_order_id: item_details_array[1],
                    },
                    success: function (response) {
                        let data = JSON.parse(response);
                        const product = data.product;
                        let tax_amount = data.tax_value;
                        let rowCount = $(".add_tr .rowCount").length + 1;
                        let finalPrice;
                        let taxHtml = '';
                        if (product.inter_state === 'Y') {
                            taxHtml = `
                                <td class="w-30">-</td>
                                <td class="w-30">-</td>
                                <td class="w-30">-</td>
                                <td class="w-30">-</td>
                                <td class="w-30">${data.tax_rate / 2}</td>
                                <td class="w-30">${tax_amount / 2}</td>
                            `;
                        } else {
                            taxHtml = `
                                <td class="w-30">${data.tax_rate / 2}</td>
                                <td class="w-30">${tax_amount / 2}</td>
                                <td class="w-30">${data.tax_rate / 2}</td>
                                <td class="w-30">${tax_amount / 2}</td>
                                <td class="w-30">-</td>
                                <td class="w-30">-</td>
                            `;
                        }
                        // if(data.nob === 1) {
                        //     finalPrice = '';
                        //     // disabled = '';
                        // } else {
                        //     finalPrice = data.sale_price;
                        //     // disabled = 'readonly';
                        // }

                        let html = `
                            <tr class="rowCount" data-id="${product.id}">
                                <td class="w-5 text-start">${rowCount}</td>
                                <td class="w-30">${product.code}<input type="hidden" name="part_no[]" value="${data.code}"></td>                                
                                <td class="w-50">${product.name} (${product.code})</td>                                
                                <td class="w-15">${data.product_quantity} ${data.unit_name}<input type="hidden" name="product_quantity[]" value="${data.product_quantity}"><input type="hidden" name="unit_id[]" value="${data.unit_id}"><input type="hidden" name="po_no[]" value="${data.reference_no}"><input type="hidden" name="po_date[]" value="${data.po_date}"></td>
                                <td class="w-15">${product.hsn_sac_no}</td>
                                <td class="w-15"><textarea class="form-control" name="dc_ref[]" placeholder="DC Reference" rows="3" cols="50" maxlength="50"></textarea></td>
                                <td class="w-15"><input type="text" name="dc_ref_date[]" class="form-control dc-ref-date" placeholder="Delivery Challan Reference Date"></td>
                                <td class="w-15"><textarea class="form-control" name="challan_ref[]" placeholder="Challan Reference" rows="3" cols="50" maxlength="50"></textarea></td>
                                <td class="w-15"><textarea class="form-control" name="description[]" placeholder="Description" rows="3" cols="50" maxlength="50"></textarea></td>
                                <td class="width_3_p text-end"><a class="btn btn-xs del_dc_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>
                            </tr>
                        `;
                        $(".add_tr").append(html);
                        $('.dc-ref-date').datepicker({
                            format: "dd-mm-yyyy",
                            autoclose: true,
                            todayHighlight: true,
                            startDate: new Date()
                        });
                        let total = 0;
                        $(".add_tr .rowCount").each(function () {
                            let val = $(this).find("td").eq(16).text().replace("₹", "").trim();                            
                            total += parseFloat(val) || 0;
                        });
                        $("#subtotal").val(total.toFixed(2));
                        $("#grand_total").val(total.toFixed(2));
                    },
                });
            }
        });
    });
    $(document).on("click", ".del_dc_row", function () {
        $(this).closest("tr").remove();
        $("#dcproduct_id").html('<option value="">Select</option>');
        $(".select2").select2();
    });
    // Currency Change
    $(document).on("change", "#change_currency", function () {
        if ($(this).is(":checked")) {
            $("#currency_section").removeClass("d-none");
        } else {
            $("#currency_section").addClass("d-none");
        }

        $(".select2-container").css('width', '100%');
    });

    $(document).on("change", "#currency", function(){
        let data = $(this).val();
        let conversion_rate = data.split("|")[1];
        let amount = $("#paid").val();
        $("#converted_amount").val(currencyConversion(amount, conversion_rate));
        $(".converted_amount_currency").text(data.split("|")[2]);
        $("#currency_id").val(data.split("|")[0]);
    })

    function currencyConversion(amount, conversion_rate) {
        const convertedAmount = amount * conversion_rate;
    return convertedAmount.toFixed(2);
    }
});
