$(document).ready(function () {
  "use strict";
  const $customerSelect = $("#customer_id");
  if ($customerSelect.length && !$customerSelect.prop("disabled")) {
    $customerSelect.select2();
  }
  function parseDMYtoDate(dmy) {
    const [day, month, year] = dmy.split("-");
    return new Date(`${year}-${month}-${day}`);
  }
  $("#order_start_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
    })
    .on("changeDate", function (e) {
      const startDate = e.date;
      $("#order_complete_date").datepicker("setStartDate", startDate);
      const completeDateVal = $("#order_complete_date").val();
      if (completeDateVal) {
        const completeDate = parseDMYtoDate(completeDateVal);
        if (completeDate < startDate) {
          $("#order_complete_date").datepicker("update", startDate);
        }
      }
    });
  $("#order_complete_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
    })
    .on("changeDate", function (e) {
      const completeDate = e.date;
      const startDateVal = $("#order_start_date").val();
      if (startDateVal) {
        const startDate = parseDMYtoDate(startDateVal);
        if (completeDate < startDate) {
          $("#order_complete_date").datepicker("update", startDate);
        }
      }
    });
  /* PO date */
  $("#po_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    })
    .datepicker("update", new Date());
  $("#stockCheck").on("hidden.bs.modal", function () {
    // $('#chk_mat_type').val('').trigger('change');
    // $('#chk_customer_id').val('').trigger('change');
    // $('#chk_mat_cust_div').addClass('d-none');
    $(".stock_check_table").addClass("d-none").html("");
    $(".download_button").addClass("disabled");
  });
  $("#stockCheck").on("shown.bs.modal", function () {
    // $('#chk_mat_type').select2({
    //     dropdownParent: $('#stockCheck')
    // });
    // $('#chk_customer_id').select2({
    //     dropdownParent: $('#stockCheck')
    // });
    $(".download_button").removeClass("disabled");
    let rows = $("tr:has(.rm_id)");
    let rmQuantities = {};

    rows.each(function () {
      let rm_id = $(this).find(".rm_id").val();
      let quantity = parseFloat($(this).find(".rquantity_c").val()) || 0;
      // if (!rm_id || quantity === 0) return;
      if (rmQuantities[rm_id]) {
        rmQuantities[rm_id] += quantity;
      } else {
        rmQuantities[rm_id] = quantity;
      }
    });

    if (Object.keys(rmQuantities).length === 0) {
      $(".stock_check_table")
        .removeClass("d-none")
        .html(
          "<p class='text-center my-2 text-danger'>Please add material first</p>"
        );
      $(".download_button").addClass("disabled");
      return;
    }
    let sn = 1;
    let productName = [];
    let productCode = [];
    let currentStock = [];
    let needed = [];
    let customerName = [];
    let unitName = [];
    let customer_id = $("#customer_id").val() || "";
    let requestData = {
      // mat_type: mat_type,
      rm_ids: Object.keys(rmQuantities),
    };
    if (customer_id) {
      requestData.customer_id = customer_id;
    }
    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "getStockMaterialsByCustomer",
      data: requestData,
      dataType: "json",
      success: function (data) {
        if (data && data.length > 0) {
          data.forEach(function (item) {
            let rm_id = item.raw_materials.id;
            let customer_name = item.customer
              ? item.customer.name + " (" + item.customer.customer_id + ")"
              : "";
            let unit = item.unit;
            let code = item.raw_materials.code;
            let product_name = item.raw_materials.name;
            let stock = parseFloat(item.current_stock) || 0;
            let required = rmQuantities[rm_id] || 0;
            let neededForManufacture = required - stock;
            // let neededForManufacture = 0;
            neededForManufacture =
              neededForManufacture < 0 ? 0 : neededForManufacture;
            customerName.push(customer_name);
            productName.push(product_name);
            productCode.push(code);
            currentStock.push(stock);
            unitName.push(unit);
            needed.push(neededForManufacture);
            $(".stock_check_table").removeClass("d-none");
            generateTable(
              productName,
              customerName,
              productCode,
              currentStock,
              needed,
              unitName
            );
          });
        } else {
          $(".stock_check_table")
            .removeClass("d-none")
            .html(
              '<p class="text-center my-2 text-danger">No Stock Materials Available!</p>'
            );
        }
      },
      error: function () {
        $(".stock_check_table").removeClass("d-none");
        generateTable(
          productName,
          customerName,
          productCode,
          currentStock,
          needed,
          unitName
        );
      },
    });
  });
  let default_currency = $("#default_currency").val();
  let base_url = $("#hidden_base_url").val();
  $(document).on("click", ".print_invoice", function () {
    viewChallan($(this).attr("data-id"));
  });
  function viewChallan(id) {
    open(
      base_url + "customer-order-print/" + id,
      "Print Customer Order",
      "width=1600,height=550"
    );
    newWindow.focus();
    newWindow.onload = function () {
      newWindow.document.body.insertAdjacentHTML("afterbegin");
    };
  }
  modalIssueFix();
  function modalIssueFix() {
    $("#product_id").select2({
      dropdownParent: $("#deliveryModal"),
    });
    $("#delivery_status").select2({
      dropdownParent: $("#deliveryModal"),
    });
    $("#invoice_type").select2({
      dropdownParent: $("#invoiceModal"),
    });
  }

  /**
   * @description This function is used to Calculate the Row
   */
  function cal_row(row) {
    let sale_price = parseFloat(row.find(".sale_price_c").val()) || 0;
    let prod_qty = parseFloat(row.find(".pquantity_c").val()) || 0;
    let discount_percent = 0;
    let discount_amount = sale_price * (discount_percent / 100);
    let sub_tot_bf = sale_price * prod_qty;
    console.log("sub_tot_bf", sub_tot_bf);
    row.find(".price_c").val(sub_tot_bf.toFixed(2));
    let subtotal_after_discount = sub_tot_bf - discount_amount;
    let cgst = parseFloat(row.find(".cgst_input").val()) || 0;
    let sgst = parseFloat(row.find(".sgst_input").val()) || 0;
    let igst = parseFloat(row.find(".igst_input").val()) || 0;
    let gst_percent = cgst + sgst + igst;
    let gst_amount = subtotal_after_discount * (gst_percent / 100);
    let subtotal_with_gst = subtotal_after_discount + gst_amount;
    // console.log("GST Amount", gst_amount);
    row.find(".tax_amount_c").val(gst_amount.toFixed(2));
    row.find(".sub_total_c").val(subtotal_with_gst.toFixed(2));
  }
  $(document).on("change", "#customer_id", function () {
    let hidden_base_url = $("#hidden_base_url").val();
    let customer_id = $("#customer_id").val();
    $.ajax({
      type: "GET",
      dataType: "json",
      url: hidden_base_url + "getCustomerDetail",
      data: {
        id: customer_id,
      },
      success: function (data) {
        $("#delivery_address").val(data.address);
        $(".select2").select2();
      },
    });
  });
  // $(document).on("change", "#order_quote_status", function (e) {
  //     let order_status = $(this).find(":selected").val();
  //     let order_id = $("#order_quote_status").data("order_id");
  //     $.ajax({
  //         type: "POST",
  //         url: $("#hidden_base_url").val() + "updateOrderStatus",
  //         data: { order_id: order_id, order_status:order_status },
  //         dataType: "json",
  //         success: function (data) {
  //             $('<span class="text-success">' + data.message + '</span>')
  //             .insertAfter('#status-msg')
  //             .delay(5000)
  //             .fadeOut();
  //             $("#order_quote_status").prop("disabled", true);
  //         },
  //         error: function () {},
  //     });
  // });
  $(document).on("change", ".order-quote-status", function (e) {
    let $this = $(this);
    let order_status = $this.val();
    let order_id = $this.data("order_id");
    let $statusMsg = $this.closest("td").find(".status-msg");
    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "updateOrderStatus",
      data: { order_id: order_id, order_status: order_status },
      dataType: "json",
      success: function (data) {
        $this.prop("disabled", true);
        $statusMsg
          .html('<span class="text-success">' + data.message + "</span>")
          .delay(2000)
          .fadeOut();
        location.reload();
      },
      error: function () {
        $statusMsg
          .html('<span class="text-danger">Something went wrong.</span>')
          .delay(2000)
          .fadeOut();
      },
    });
  });
  $(document).on(
    "change",
    'input[type=radio][name^="inter_state"]',
    function () {
      let row = $(this).closest("tr");
      let hidden_base_url = $("#hidden_base_url").val();
      let isYes = $(this).val() === "Y";
      let selected_tax = $("#order_type option:selected").text().trim();
      let tax_type;
      if (selected_tax == "Labor") {
        tax_type = 1;
      } else {
        tax_type = 2;
      }
      // let tax_type = row.find('.tax_type_id').val() || 12;
      $.ajax({
        type: "POST",
        url: hidden_base_url + "getTaxRate",
        data: { tax_type: tax_type },
        dataType: "json",
        success: function (data) {
          console.log("data", data);
          let tax_rate = data || 0;
          let interStateVal =
            row.find('input[type=radio][name^="inter_state"]:checked').val() ||
            "N";
          let isYes = interStateVal === "Y";
          applyGSTLogic(row, isYes, tax_rate);
          // update_invoice_totals();
        },
        error: function () {
          console.error("Failed to fetch product details.");
        },
      });
      // let tax_rate = 12;
      // applyGSTLogic(row, isYes, tax_rate);
    }
  );
  $(document).on("change", "#order_type", function () {
    let hidden_base_url = $("#hidden_base_url").val();
    let selected_tax = $("#order_type option:selected").text().trim();
    let tax_type;
    if (selected_tax == "Labor") {
      tax_type = 1;
    } else {
      tax_type = 2;
    }
    console.log("Selected Tax Type:", selected_tax);

    /* let row = $(this).closest('tr');
        let tax_type = row.find('[id^="tax_type_id_"]').val(); */
    $.ajax({
      type: "POST",
      url: hidden_base_url + "getTaxRate",
      data: { tax_type: tax_type },
      dataType: "json",
      success: function (data) {
        console.log("data", data);
        let tax_rate = data || 0;
        let interStateVal =
          $('input[type=radio][name^="inter_state"]:checked').val() || "N";
        let isYes = interStateVal === "Y";
        applyGSTLogic(null, isYes, tax_rate);
        // update_invoice_totals();
      },
      error: function () {
        console.error("Failed to fetch product details.");
      },
    });
    // let interStateVal = row.find('input[type=radio][name^="inter_state"]:checked').val() || 'N';
    // let isYes = interStateVal === 'Y';
    // applyGSTLogic(row, isYes);
    // update_invoice_totals();
  });
  $(document).on(
    "change",
    ".pquantity_c, .sale_price_c, .cgst_input, .sgst_input, .igst_input",
    function () {
      let row = $(this).closest("tr");
      let hidden_base_url = $("#hidden_base_url").val();
      // let interStateVal = row.find('input[type=radio][name^="inter_state"]:checked').val() || 'N';
      // let isYes = interStateVal === 'Y';
      // let tax_type = row.find('.tax_type_id').val() || 12;
      let selected_tax = $("#order_type option:selected").text().trim();
      let tax_type;
      if (selected_tax == "Labor") {
        tax_type = 1;
      } else {
        tax_type = 2;
      }
      $.ajax({
        type: "POST",
        url: hidden_base_url + "getTaxRate",
        data: { tax_type: tax_type },
        dataType: "json",
        success: function (data) {
          console.log("data", data);
          let tax_rate = data || 0;
          let interStateVal =
            row.find('input[type=radio][name^="inter_state"]:checked').val() ||
            "N";
          let isYes = interStateVal === "Y";
          applyGSTLogic(row, isYes, tax_rate);
          // update_invoice_totals();
        },
        error: function () {
          console.error("Failed to fetch product details.");
        },
      });
      // applyGSTLogic(row, isYes, tax_rate);
      // update_invoice_totals();
    }
  );
  function applyGSTLogic(row, isYes, tax_rate) {
    if (!row) {
      $("table tbody tr").each(function () {
        applyGSTLogic($(this), isYes, tax_rate);
      });
      return;
    }
    if (isYes) {
      console.log("Applying IGST logic");
      row.find(".cgst_cell, .sgst_cell").hide();
      row.find(".igst_cell").show();
      row.find(".igst_input").val(tax_rate);
      row.find(".cgst_input, .sgst_input").val("");
    } else {
      console.log("Applying CGST logic");
      row.find(".cgst_cell, .sgst_cell").show();
      row.find(".igst_cell").hide();

      let half_rate = Math.round(tax_rate / 2);
      row.find(".cgst_input").val(half_rate);
      row.find(".sgst_input").val(half_rate);
      row.find(".igst_input").val("");
    }

    updateGSTHeaders(!isYes);
    cal_row(row);
    update_invoice_totals();
  }
  function update_invoice_totals() {
    let total_sub_total = 0;
    $(".sub_total_c").each(function () {
      total_sub_total += parseFloat($(this).val()) || 0;
    });
    console.log("total_sub_total", total_sub_total);

    $("#total_subtotal").val(total_sub_total.toFixed(2));
    $(".invoice_amount_c, .due_amount_c, .order_due_amount_c").val(
      total_sub_total.toFixed(2)
    );
    modalIssueFix();
  }
  function updateGSTHeaders(showIGST) {
    if (showIGST) {
      $("#igst_th").hide();
      $("#cgst_th, #sgst_th").show();
    } else {
      $("#cgst_th, #sgst_th").hide();
      $("#igst_th").show();
    }
  }
  let i = 0;
  $(document).on("click", "#finishProduct", function (e) {
    ++i;
    let hidden_product = $("#hidden_product").html();
    let hidden_tax_type = $("#hidden_tax_type").html();
    let hidden_base_url = $("#hidden_base_url").val();
    let selectedOrderType = $("#order_type option:selected").text().trim();
    let tax_type_id;
    if (selectedOrderType === "Labor") {
      tax_type_id = 1;
    } else {
      tax_type_id = 2;
    }
    $(".errProduct").remove();
    let firstInterState =
      $('input[name^="inter_state["]:checked').first().val() || "N";
    $(".add_trm").append(
      "<tr>" +
        '<td class="ir_txt_center"><p class="set_sn rowCount">' +
        i +
        "</p></td>" +
        '<td><select class="form-control fproduct_id select2" name="product[]" id="fproduct_id_' +
        i +
        '"><option value="">Please Select</option>\n' +
        hidden_product +
        "</select></td>" +
        '<td><select class="form-control rm_id select2" name="raw_material[]" id="rm_id_' +
        i +
        '"><option value="">Please Select</option></select></td>' +
        '<td><input type="number" name="raw_quantity[]" onfocus="this.select();" class="check_required form-control integerchk rquantity_c" placeholder="Raw Quantity" id="rquantity_' +
        i +
        '"></td>' +
        '<td><input type="number" name="prod_quantity[]" onfocus="this.select();" class="check_required form-control integerchk pquantity_c" placeholder="Quantity" id="pquantity_' +
        i +
        '"></td>' +
        '<td><div class="input-group"><input type="text" name="sale_price[]" onfocus="this.select();" class="check_required form-control integerchk sale_price_c" placeholder="Unit Price" id="sale_price_' +
        i +
        '" ><span class="input-group-text rmcurrency">' +
        default_currency +
        '</span></div><span class="text-success" id="up_' +
        i +
        '"></span></td>' +
        '<td><div class="input-group"><input type="text" name="price[]" onfocus="this.select();" class="check_required form-control integerchk price_c" readonly="" placeholder="Price" id="price_' +
        i +
        '" ><span class="input-group-text rmcurrency">' +
        default_currency +
        '</span></div><span class="text-success" id="up_' +
        i +
        '"></span></td>' +
        '<td><input type="hidden" class="form-control tax_type_id" name="tax_type[]" id="tax_type_id_' +
        i +
        '" value="' +
        tax_type_id +
        '" readonly placeholder="Tax Type"><span class="selected_taxtype">' +
        selectedOrderType +
        "</span></td>" +
        '<td><div class="form-group radio_button_problem"><div class="radio">' +
        '<label><input type="radio" name="inter_state[' +
        i +
        ']" id="inter_state_yes_' +
        i +
        '" value="Y" ' +
        (i === 1
          ? "checked"
          : firstInterState === "Y"
          ? "checked disabled"
          : "disabled") +
        "> Yes</label>&nbsp;" +
        '<label><input type="radio" name="inter_state[' +
        i +
        ']" id="inter_state_no_' +
        i +
        '" value="N" ' +
        (i === 1
          ? "checked"
          : firstInterState === "N"
          ? "checked disabled"
          : "disabled") +
        "> No</label>" +
        (i !== 1
          ? '<input type="hidden" name="inter_state[' +
            i +
            ']" value="' +
            firstInterState +
            '">'
          : "") +
        "</div></div></td>" +
        '<td class="cgst_cell" style="display:none;"><input type="text" name="cgst[]" class="form-control cgst_input" id="cgst_' +
        i +
        '" readonly></td>' +
        '<td class="sgst_cell" style="display:none;"><input type="text" name="sgst[]" class="form-control sgst_input" id="sgst_' +
        i +
        '" readonly></td>' +
        '<td class="igst_cell" style="display:none;"><input type="text" name="igst[]" class="form-control igst_input" id="igst_' +
        i +
        '" readonly></td>' +
        '<td><input type="text" id="delivery_date_' +
        i +
        '" name="delivery_date_product[]" class="form-control order_delivery_date" placeholder="Delivery Date"></td>' +
        '<td><div class="input-group"><input type="number" id="tax_amount_' +
        i +
        '" name="tax_amount[]" class="form-control tax_amount_c" placeholder="Tax Amount" readonly=""><span class="input-group-text rmcurrency">' +
        default_currency +
        "</span></div></td>" +
        '<td><div class="input-group"><input type="number" id="sub_total_' +
        i +
        '" name="sub_total[]" class="form-control sub_total_c" placeholder="Subtotal" readonly=""><span class="input-group-text rmcurrency">' +
        default_currency +
        "</span></div></td>" +
        '<td><span id="production_status_' +
        i +
        '">NIL</span></td>' +
        '<td><span id="deliveries_qty_' +
        i +
        '">0</span></td>' +
        '<td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
        "</tr>"
    );
    let newRow = $(".add_trm").find("tr").last();
    let taxInput = newRow.find(".tax_type_id");
    if (!taxInput.val()) {
      taxInput.val("");
    }
    // let isYes = firstInterState === 'Y';
    // let tax_type = taxInput.val() || 12;
    let selected_tax = $("#order_type option:selected").text().trim();
    let tax_type;
    if (selected_tax == "Labor") {
      tax_type = 1;
    } else {
      tax_type = 2;
    }
    $.ajax({
      type: "POST",
      url: hidden_base_url + "getTaxRate",
      data: { tax_type: tax_type },
      dataType: "json",
      success: function (data) {
        console.log("data", data);
        let tax_rate = data || 0;
        let interStateVal =
          newRow.find('input[type=radio][name^="inter_state"]:checked').val() ||
          "N";
        let isYes = interStateVal === "Y";
        applyGSTLogic(newRow, isYes, tax_rate);
        // update_invoice_totals();
      },
      error: function () {
        console.error("Failed to fetch product details.");
      },
    });
    // let tax_rate = 12;
    // applyGSTLogic(newRow, isYes, tax_rate);
    $(".select2").select2();
    $(".customDatepicker").datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
    });
    $(".order_delivery_date").datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    });
  });
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr("content"),
    },
  });
  $(document).on("change", 'input[name="inter_state[1]"]', function () {
    let newVal = $(this).val();
    let hidden_base_url = $("#hidden_base_url").val();
    $('input[name^="inter_state["]').each(function () {
      let name = $(this).attr("name");
      if (name !== "inter_state[1]") {
        let index = name.match(/\d+/)[0];
        $(
          'input[name="inter_state[' + index + ']"][value="' + newVal + '"]'
        ).prop("checked", true);
        let row = $(this).closest("tr");
        let selected_tax = $("#order_type option:selected").text().trim();
        let tax_type;
        if (selected_tax == "Labor") {
          tax_type = 1;
        } else {
          tax_type = 2;
        }
        // let tax_type = row.find('.tax_type_id').val() || 12;
        $.ajax({
          type: "POST",
          url: hidden_base_url + "getTaxRate",
          data: { tax_type: tax_type },
          dataType: "json",
          success: function (data) {
            console.log("data", data);
            let tax_rate = data || 0;
            let interStateVal =
              row
                .find('input[type=radio][name^="inter_state"]:checked')
                .val() || "N";
            let isYes = interStateVal === "Y";
            applyGSTLogic(row, isYes, tax_rate);
            // update_invoice_totals();
          },
          error: function () {
            console.error("Failed to fetch product details.");
          },
        });
        // let tax_rate = 12;
        // applyGSTLogic(row, newVal === 'Y', tax_rate);
      }
    });
  });
  $(document).on("change", ".fproduct_id", function () {
    let hidden_alert = $("#hidden_alert").val();
    let hidden_cancel = $("#hidden_cancel").val();
    let hidden_ok = $("#hidden_ok").val();
    let selectedVal = $(this).val();
    let current = $(this);
    let isDuplicate = false;
    // Check for duplicate product
    $(".fproduct_id").each(function () {
      if ($(this).val() === selectedVal && this !== current[0]) {
        swal({
          title: hidden_alert + "!",
          text: "This product has already been selected.",
          cancelButtonText: hidden_cancel,
          confirmButtonText: hidden_ok,
          confirmButtonColor: "#3c8dbc",
        });
        current.val(""); // Reset selection
        current.trigger("change"); // Refresh select2 if used
        isDuplicate = true;
        return false; // break loop
      }
    });
    if (isDuplicate) return;
    // Proceed with setting unit price, tax_type, and GST logic
    let fproduct_id = current.find(":selected").val();
    let hidden_base_url = $("#hidden_base_url").val();
    let product_field_id = this.id;
    let product_field_array = product_field_id.split("_");
    let c_id = product_field_array[2];
    let default_currency = $("#default_currency").val();
    let row = current.closest("tr");
    $.ajax({
      type: "POST",
      url: hidden_base_url + "getFinishProductDetails",
      data: { id: fproduct_id },
      dataType: "json",
      success: function (data) {
        let raw_materials = data.rmaterials;
        $(".rmcurrency").html(default_currency);
        let select = row.find(".rm_id");
        select.empty();
        select.append('<option value="">Please Select</option>');
        raw_materials.forEach(function (rm) {
          if (rm.raw_materials) {
            let id = rm.raw_materials.id;
            let name = rm.raw_materials.name;
            let code = rm.raw_materials.code;
            select.append(
              '<option value="' +
                id +
                '">' +
                name +
                " (" +
                code +
                ")" +
                "</option>"
            );
          }
        });
        $(".select2").select2();
      },
      error: function () {
        console.error("Failed to fetch product details.");
      },
    });
  });
  $(document).on("keydown", ".quantity_c", function (e) {
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
  $(document).on("input", ".quantity_c", function (e) {
    let quantity = Number($(this).val());
    let product_field_id = this.id;
    let product_field_array = product_field_id.split("_");
    let c_id = product_field_array[1];
    let unit_price = Number($("#unit_price_" + c_id).val());
    let sub_total = quantity * unit_price;
    $("#sub_total_" + c_id).val(sub_total);
    cal_row();
  });
  /* $(document).on("keyup", ".discount_percent_c", function (e) {
        let row = $(this).closest('tr');
        cal_row(row);
    }); */
  $(document).on("keyup", ".sale_price_c", function (e) {
    let row = $(this).closest("tr");
    cal_row(row);
  });
  $(document).on("keyup", ".pquantity_c", function (e) {
    let row = $(this).closest("tr");
    cal_row(row);
  });
  $(document).on("keyup", ".paid_amount_c", function (e) {
    let paid_amount = Number($(this).val());
    let product_field_id = this.id;
    let product_field_array = product_field_id.split("_");
    let c_id = product_field_array[2];
    let inv_amount = Number($("#invoice_amount_" + c_id).val());
    if (inv_amount < paid_amount) {
      $("#paid_amount_" + c_id).val(inv_amount);
    }
    let due_amount = inv_amount - paid_amount;
    $("#due_amount_" + c_id).val(due_amount);
    $("#order_due_amount_" + c_id).val(due_amount);
  });
  $(document).on("click", ".del_row", function (e) {
    $(this).parent().parent().remove();
    setAttribute();
    cal_row();
  });
  $(document).on("change", "#order_type", function () {
    let order_type = $(this).val();
    console.log("Order Type:", order_type);
    let order_type_text = $("#order_type option:selected").text().trim();
    console.log("Order Type Text:", order_type_text);
    if (order_type == "Work Order") {
      $(".tax_type_id").val(2);
      $(".selected_taxtype").text(order_type_text);
      $("#deliveries_section").removeClass("d-none");
      $("#invoice_quotations_sections").removeClass("d-none");
      addDefaultQuotations();
      modalIssueFix();
    } else {
      $(".tax_type_id").val(1);
      $(".selected_taxtype").text(order_type_text);
      $("#deliveries_section").addClass("d-none");
      $("#invoice_quotations_sections").addClass("d-none");
    }
  });
  let today = new Date()
    .toISOString()
    .slice(0, 10)
    .split("-")
    .reverse()
    .join("-");
  /**
   * @description This function is used to add default Quotations
   */
  function addDefaultQuotations() {
    console.log(today);
    $(".add_order_inv").html(
      '<tr class="rowCount"><td class="width_1_p ir_txt_center">1</td><td><input type="text" name="invoice_type[]" class="form-control" value="Quotation" readonly></td><td><input type="text" name="invoice_date[]" class="form-control" value="' +
        today +
        '" readonly></td> <td><input type="text" name="invoice_amount[]" class="form-control invoice_amount_c" value="0" readonly></td><td><input type="text" name="invoice_paid[]" class="form-control" value="0" readonly></td><td><input type="text" name="invoice_due[]" class="form-control due_amount_c" value="0" readonly></td></tr>'
    );
  }
  /**
   * Invoice Add Row
   */
  $(document).on("click", ".invoice_submit", function (e) {
    e.preventDefault();
    let invoice_type = $("#invoice_type").val();
    let invoice_date = today;
    let invoice_amount = $("#paid_amount").val();
    let invoice_due = $("#due_amount").val();
    let invoice_order_due = $("#order_due_amount").val();
    let rowCount = $(".add_order_inv tr").length;
    rowCount = rowCount + 1;

    if (invoice_amount == "") {
      $("#paid_amount").addClass("is-invalid");
      $("#paid_amount").focus();
      $(".paid_amount_err_msg").html("Please enter paid amount").fadeOut(5000);
      return false;
    }

    $(".add_order_inv").append(
      '<tr class="rowCount"><td class="width_1_p ir_txt_center">1</td><td><input type="text" name="invoice_type[]" class="form-control" value="' +
        invoice_type +
        '" readonly></td><td><input type="text" name="invoice_date[]" class="form-control" value="' +
        invoice_date +
        '" readonly></td> <td><input type="text" name="invoice_amount[]" class="form-control invoice_amount_c" value="' +
        invoice_amount +
        '" readonly></td><td><input type="text" name="invoice_paid[]" class="form-control" value="' +
        invoice_amount +
        '" readonly></td><td><input type="text" name="invoice_due[]" class="form-control due_amount_c" value="' +
        invoice_due +
        '" readonly></td><td class="ir_txt_center"><a class="btn btn-xs del_inv_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td></tr>'
    );
    $("#invoiceModal").modal("hide");
  });
  /**
   * Delileties Add Row
   */
  $(document).on("click", ".delivaries_button", function (e) {
    e.preventDefault();
    $(".table-responsive").removeClass("d-none");
    let product = $("#product_id").val();
    let quantity = $("#delivary_quantity").val();
    let delivery_date = $("#ddelivery_date").val();
    let delivery_status = $("#delivery_status").val();
    let delivery_note = $("#delivery_note").val() ?? "";
    let rowCount = $(".add_deliveries tr").length;
    rowCount = rowCount + 1;

    if (product == "") {
      $("#product_id").addClass("is-invalid");
      $("#product_id").focus();
      $(".product_error").html("Please select product").fadeOut(5000);
      return false;
    }

    if (quantity == "") {
      $("#delivary_quantity").addClass("is-invalid");
      $("#delivary_quantity").focus();
      $(".quantity_error").html("Please enter quantity").fadeOut(5000);
      return false;
    }

    if (delivery_date == "") {
      $("#ddelivery_date").addClass("is-invalid");
      $("#ddelivery_date").focus();
      $(".delivery_date_error")
        .html("Please select delivery date")
        .fadeOut(5000);
      return false;
    }

    if (delivery_status == "") {
      $("#delivery_status").addClass("is-invalid");
      $("#delivery_status").focus();
      $(".delivery_status_error")
        .html("Please select delivery status")
        .fadeOut(5000);
      return false;
    }

    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "getFinishProductDetails",
      data: { id: product },
      dataType: "json",
      success: function (data) {
        $(".add_deliveries").append(
          '<tr class="rowCount"><td class="width_1_p ir_txt_center">' +
            rowCount +
            '</td><td><input type="hidden" name="delivaries_product[]" value="' +
            product +
            '" /><input type="text" class="form-control" value="' +
            data.name +
            '" readonly></td><td><input type="text" name="delivaries_quantity[]" class="form-control" value="' +
            quantity +
            '"></td><td><input type="text" name="delivaries_date[]" class="form-control customDatepicker" value="' +
            delivery_date +
            '"></td><td><input type="text" name="delivaries_status[]" class="form-control" value="' +
            delivery_status +
            '"></td><td><input type="text" name="delivaries_note[]" class="form-control" value="' +
            delivery_note +
            '"></td><td class="ir_txt_center"><a class="btn btn-xs del_del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td></tr>'
        );
        $("#deliveryModal").modal("hide");
      },
    });
  });
  /**
   * Check Stock
   */
  // $(document).on("change", "#chk_customer_id,#chk_mat_type", function (e) {
  //     e.preventDefault();
  //     let mat_type = $("#chk_mat_type").val();
  //     if(mat_type == "1") {
  //         $("#chk_mat_cust_div").removeClass("d-none");
  //     } else {
  //         $("#chk_mat_cust_div").addClass("d-none");
  //     }

  // });
  /**
   * @description This function is used to generate the table
   * @param {Array} productName
   * @param {Array} productCode
   * @param {Array} currentStock
   * @param {Array} needed
   */
  function generateTable(
    productName,
    customerName,
    productCode,
    currentStock,
    needed,
    unitName
  ) {
    let sn = 1;
    let table = "";
    for (let i = 0; i < productName.length; i++) {
      let custName = customerName[i] ? customerName[i] : "Danish";
      table +=
        "<tr><td>" +
        sn +
        "</td><td>" +
        productName[i] +
        " (" +
        productCode[i] +
        ")" +
        "<br><small class='text-muted'>" +
        custName +
        "</small>" +
        "</td><td>" +
        currentStock[i] +
        " " +
        unitName[i] +
        "</td><td>" +
        needed[i] +
        " " +
        unitName[i] +
        "</td></tr>";
      sn++;
    }

    $(".stock_check_table").html(table);
  }

  /**
   * Estimated Cost
   */

  $(document).on("click", ".estimateCost", function (e) {
    e.preventDefault();
    let totalProducts = $(".fproduct_id").length;
    $(".download_button_cost").removeClass("disabled");
    if (totalProducts == 0) {
      let message =
        "<p class='text-center my-2 text-danger'>Please add products first</p>";
      $(".estimate_cost_table").html(message);
      $(".download_button_cost").addClass("disabled");
      return false;
    }

    let productName = [];
    let productCode = [];
    let quantity = [];
    let rawMaterialCost = [];
    let nonInventoryCost = [];
    let totalRawMaterialCost = [];
    let totalNonInventoryCost = [];
    let grandTotal = [];

    let requiredTime = [];

    $(".fproduct_id").each(function () {
      let id = $(this).val();
      let product_name = $(this).find("option:selected").text();
      let quantity_p = $(this).closest("tr").find(".quantity_c").val();

      $.ajax({
        type: "POST",
        url: $("#hidden_base_url").val() + "getFinishProductDetails",
        data: { id: id },
        dataType: "json",
        success: function (data) {
          console.log(data);
          let code = data.code;

          // Push the data into arrays inside the success callback
          productName.push(product_name);
          productCode.push(code);
          quantity.push(quantity_p);
          rawMaterialCost.push(data.rmaterials);
          nonInventoryCost.push(data.non_inventory);
          totalRawMaterialCost.push(data.rmcost_total);
          totalNonInventoryCost.push(data.noninitem_total);
          requiredTime.push(data.required_time);

          grandTotal.push(data.total_cost);

          generateCostTable(
            productName,
            productCode,
            quantity,
            rawMaterialCost,
            nonInventoryCost,
            totalRawMaterialCost,
            totalNonInventoryCost,
            grandTotal,
            requiredTime
          );
        },
      });
    });
  });

  /**
   * @description This function is used to generate the cost table
   * @param {*} productName
   * @param {*} productCode
   * @param {*} quantity
   * @param {*} rawMaterialCost
   * @param {*} nonInventoryCost
   * @param {*} totalRawMaterialCost
   * @param {*} totalNonInventoryCost
   * @param {*} grandTotal
   * @param {*} requiredTime
   */
  function generateCostTable(
    productName,
    productCode,
    quantity,
    rawMaterialCost,
    nonInventoryCost,
    totalRawMaterialCost,
    totalNonInventoryCost,
    grandTotal,
    requiredTime
  ) {
    let sn = 1;
    let table = "";
    console.log(nonInventoryCost);
    for (let i = 0; i < productName.length; i++) {
      let rawMaterials = `<div id="stockInnerTable"><ul><li><div>Raw Materials</div></li><li><div class="w-40">Name</div><div class="w-40">Value x Quantity</div><div class="w-20 text-end">Total</div></li>`;

      for (let j = 0; j < rawMaterialCost[i].length; j++) {
        rawMaterials += `<li>
                    <div class="w-40">${rawMaterialCost[i][j].raw_materials.name}</div>
                    <div class="w-40">
                        ${default_currency}${rawMaterialCost[i][j].unit_price} x ${rawMaterialCost[i][j].consumption}
                    </div>
                    <div class="w-20 text-end">${default_currency}${rawMaterialCost[i][j].total_cost}</div>
                </li>`;
      }

      rawMaterials += `<li><div class="fw-medium">Total</div><div>${default_currency}${totalRawMaterialCost[i]}</div></li>`;

      rawMaterials += `<li><div class="fw-bold">Non Inventory Cost</div></li><li><div class="w-50">Name</div><div class="w-50 text-end">Total</div></li>`;

      for (let j = 0; j < nonInventoryCost[i].length; j++) {
        rawMaterials += `<li>
                    <div class="w-50">${nonInventoryCost[i][j].non_inventory_item.name}</div>
                    <div class="w-50 text-end">${default_currency}${nonInventoryCost[i][j].nin_cost}</div>
                </li>`;
      }
      rawMaterials += `<li><div class="fw-medium">Total</div><div>${default_currency}${totalNonInventoryCost[i]}</div></li>`;
      rawMaterials += `<li><div class="fw-bold">Grand Total</div><div>${default_currency}${grandTotal[i]}</div></li>`;

      rawMaterials += "</ul></div>";

      let requiredTimes = requiredTime[i] + " x " + quantity[i] + " =<br>";
      requiredTimes += calculateTotalRequiredTime(requiredTime[i], quantity[i]);

      table +=
        "<tr><td>" +
        sn +
        "</td><td>" +
        productName[i] +
        "(" +
        productCode[i] +
        ")</td><td>" +
        quantity[i] +
        "</td><td>" +
        rawMaterials +
        "</td><td>" +
        requiredTimes +
        "</td></tr>";
      sn++;
    }

    $(".estimate_cost_table").html(table);
  }

  /**
   * @description This function is used to calculate the total required time
   * @param {*} timeString
   * @param {*} quantity
   * @returns
   */
  function calculateTotalRequiredTime(timeString, quantity) {
    const timeRegex =
      /(\d+)\s*month[s]?\s*(\d+)\s*day[s]?\s*(\d+)\s*hour[s]?\s*(\d+)\s*minute[s]?/;
    const timeMatch = timeString.match(timeRegex);

    const timeForOneProduct = {
      months: parseInt(timeMatch[1]),
      days: parseInt(timeMatch[2]),
      hours: parseInt(timeMatch[3]),
      minutes: parseInt(timeMatch[4]),
    };

    const daysInMonth = 30; // Assuming 30 days in a month for simplicity
    const hoursInDay = 24;
    const minutesInHour = 60;

    // Calculate total time for one product in hours
    let totalHoursOneProduct =
      timeForOneProduct.months * daysInMonth * hoursInDay +
      timeForOneProduct.days * hoursInDay +
      timeForOneProduct.hours +
      timeForOneProduct.minutes / minutesInHour;

    let totalHoursAllProducts = totalHoursOneProduct * quantity;

    // Convert total hours back into months, days, hours, and minutes
    let totalMonths = Math.floor(
      totalHoursAllProducts / (daysInMonth * hoursInDay)
    );
    totalHoursAllProducts %= daysInMonth * hoursInDay;

    let totalDays = Math.floor(totalHoursAllProducts / hoursInDay);
    totalHoursAllProducts %= hoursInDay;

    let totalHours = Math.floor(totalHoursAllProducts);
    let totalMinutes = Math.floor(
      (totalHoursAllProducts - totalHours) * minutesInHour
    );

    return `${totalMonths} months, ${totalDays} days, ${totalHours} hours, ${totalMinutes} minutes`;
  }
  $("#invoiceModal").on("hidden.bs.modal", function () {
    $(this).find("form").trigger("reset");
  });

  $("#deliveryModal").on("hidden.bs.modal", function () {
    $(this).find("form").trigger("reset");
  });

  $(document).on("click", ".del_inv_row", function (e) {
    $(this).parent().parent().remove();
  });

  $(document).on("click", ".del_del_row", function (e) {
    $(this).parent().parent().remove();
  });

  /**
   * download_button
   */

  $(document).on("click", ".download_button", function (e) {
    e.preventDefault();
    let reference_no = $("#code").val();
    let order_type = $("#order_type").val();
    let customer = $("#customer_id").val();
    let productData = [];
    $(".stock_check_table tr").each(function () {
      let row = $(this)
        .find("td")
        .map(function () {
          return $(this).text();
        })
        .get();
      productData.push({
        id: row[0],
        name: row[1],
        quantity: row[2],
        price: row[3],
      });
    });
    if (reference_no == "") {
      let message =
        "<p class='text-center my-2 text-danger'>Please enter po number</p>";
      $(".stock_check_table").html(message);
      $(".download_button").addClass("disabled");
      return false;
    } else {
      $(".download_button").removeClass("disabled");
    }
    if (order_type == "") {
      let message =
        "<p class='text-center my-2 text-danger'>Please select Nature of Business</p>";
      $(".stock_check_table").html(message);
      $(".download_button").addClass("disabled");
      return false;
    } else {
      $(".download_button").removeClass("disabled");
    }
    if (customer == "") {
      let message =
        "<p class='text-center my-2 text-danger'>Please select customer</p>";
      $(".stock_check_table").html(message);
      $(".download_button").addClass("disabled");
      return false;
    } else {
      $(".download_button").removeClass("disabled");
    }

    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "downloadStockCheck",
      data: {
        reference_no: reference_no,
        order_type: order_type,
        customer: customer,
        productData: productData,
      },
      xhrFields: {
        responseType: "blob",
      },
      success: function (blob) {
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "stock.pdf";
        link.click();

        $("#stockCheck").modal("hide");
      },
      error: function () {
        console.log("error");
      },
    });
  });

  /**
   * Estimate Cost
   */
  $(document).on("click", ".download_button_cost", function (e) {
    e.preventDefault();
    let reference_no = $("#code").val();
    let order_type = $("#order_type").val();
    let customer = $("#customer_id").val();
    let productData = [];
    $(".estimate_cost_table tr").each(function () {
      let row = $(this)
        .find("td")
        .map(function () {
          return $(this).html();
        })
        .get();
      productData.push({
        id: row[0],
        name: row[1],
        quantity: row[2],
        cost: encodeURIComponent(row[3]),
        required_time: row[4],
      });
    });
    console.log(productData);
    if (reference_no == "") {
      let message =
        "<p class='text-center my-2 text-danger'>Please enter po number</p>";
      $(".estimate_cost_table").html(message);
      $(".download_button_cost").addClass("disabled");
      return false;
    } else {
      $(".download_button_cost").removeClass("disabled");
    }
    if (order_type == "") {
      let message =
        "<p class='text-center my-2 text-danger'>Please select Nature of Business</p>";
      $(".estimate_cost_table").html(message);
      $(".download_button_cost").addClass("disabled");
      return false;
    } else {
      $(".download_button_cost").removeClass("disabled");
    }
    if (customer == "") {
      let message =
        "<p class='text-center my-2 text-danger'>Please select customer</p>";
      $(".estimate_cost_table").html(message);
      $(".download_button_cost").addClass("disabled");
      return false;
    } else {
      $(".download_button_cost").removeClass("disabled");
    }

    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "downloadEstimateCost",
      data: {
        reference_no: reference_no,
        order_type: order_type,
        customer: customer,
        productData: productData,
      },
      xhrFields: {
        responseType: "blob",
      },
      success: function (blob) {
        // console.log(blob);
        // return;
        if (blob.size > 0) {
          // Check if the blob is not empty
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(blob);
          link.download = "estimate_cost.pdf";
          link.click();

          $("#estimateCost").modal("hide");
        } else {
          console.error("The blob is empty");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error: ", error);
        console.log(xhr.responseText);
      },
    });
  });

  $(document).on("click", ".order_submit_button", function () {
    let status = true;

    let code = $("#code").val();
    let customer_id = $("#customer_id").val();
    let order_type = $("#order_type").val();
    let po_date = $("#po_date").val();
    let delivery_date = $("#delivery_date").val();
    let delivery_address = $("#delivery_address").val();

    if (code == "") {
      showErrorMessage("code", "The PO Number field is required");
      status = false;
    } else {
      $("#code").removeClass("is-invalid");
      $("#code").closest("div").find(".text-danger").addClass("d-none");
    }

    if (customer_id == "") {
      showErrorMessage("customer_id", "The Customer field is required");
      status = false;
    } else {
      $("#customer_id").removeClass("is-invalid");
      $("#customer_id").closest("div").find(".text-danger").addClass("d-none");
    }

    if (order_type == "") {
      showErrorMessage(
        "order_type",
        "The Nature of Business field is required"
      );
      status = false;
    } else {
      $("#order_type").removeClass("is-invalid");
      $("#order_type").closest("div").find(".text-danger").addClass("d-none");
    }

    if (po_date == "") {
      showErrorMessage("po_date", "The PO date is required");
      status = false;
    } else {
      $("#po_date").removeClass("is-invalid");
      $("#po_date").closest("div").find(".text-danger").addClass("d-none");
    }

    if (delivery_address == "") {
      showErrorMessage(
        "delivery_address",
        "The delivery address field is required"
      );
      status = false;
    } else {
      $("#delivery_address").removeClass("is-invalid");
      $("#delivery_address")
        .closest("div")
        .find(".text-danger")
        .addClass("d-none");
    }

    // if (order_type == "Work Order" && delivery_date == "") {
    //     showErrorMessage(
    //         "delivery_date",
    //         "The delivery date field is required"
    //     );
    //     status = false;
    // } else {
    //     $("#delivery_date").removeClass("is-invalid");
    //     $("#delivery_date")
    //         .closest("div")
    //         .find(".text-danger")
    //         .addClass("d-none");
    // }

    let hasError = false;

    if (order_type === "Work Order") {
      $("input[name='delivery_date_product[]']").each(function () {
        let deliveryDate = $(this).val();
        if (deliveryDate === "") {
          $(this).addClass("is-invalid");
          if (!$(this).next(".text-danger").length) {
            $(this).after(
              '<div class="text-danger">Delivery date is required</div>'
            );
          }
          hasError = true;
        } else {
          $(this).removeClass("is-invalid");
          $(this).next(".text-danger").remove();
        }
      });
    }
    /* let hasError = false;
        $("select[name='tax_type[]']").each(function () {
            let taxType = $(this).val();
            let $select = $(this);
            let $container = $select.next('.select2')
            if (taxType === "") {
                $select.addClass("is-invalid");
                $container.next(".text-danger").remove();
                $container.after('<div class="text-danger">Tax Type is required</div>');
                hasError = true;
            } else {
                $select.removeClass("is-invalid");
                $container.next(".text-danger").remove();
            }
        }); */

    if (hasError) {
      status = false;
    }

    let rowCount = $(".rowCount").length;
    if (!Number(rowCount)) {
      status = false;
      $("#fprm .add_trm").html(
        '<tr><td colspan="6" class="text-danger errProduct">Please add minimum one part name</td></tr>'
      );
    } else {
      $(".errProduct").remove();
    }

    if (status == true) {
      return true;
    } else {
      $("html, body").animate({ scrollTop: 0 }, "slow");
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
  let input = document.getElementById("file_button");
  input.addEventListener("change", function () {
    let file = this.files[0];
    let img = new Image();
    //extension check jpg/jpeg/png/pdf/doc/docx only
    let ext = file.name.split(".").pop().toLowerCase();
    if ($.inArray(ext, ["jpg", "jpeg", "png", "pdf", "doc", "docx"]) == -1) {
      $("#file_button").val("");
      $("#file_button").addClass("is-invalid");
      $(".errorFile").text(
        "Invalid file type. File type must be jpg, jpeg, png, pdf, doc or docx."
      );
    }

    //calculate image size
    let size = Math.round(Number(file.size) / 1024);
    //get width
    let width = Number(this.width);
    //get height
    let height = Number(this.height);
    if (Number(size) > 5120) {
      $("#file_button").val("");
      $("#file_button").addClass("is-invalid");
      $(".errorFile").text(
        "File size is too large. File size must be less than 5 MB."
      );
    }
    //call on load
    img.onload = function () {
      URL.revokeObjectURL(this.src);
      //calculate image size
      let size = Math.round(Number(file.size) / 1024);
      //get width
      let width = Number(this.width);
      //get height
      let height = Number(this.height);
      if (Number(size) > 5120) {
        $("#file_button").val("");
        $("#file_button").addClass("is-invalid");
        $(".errorFile").text(
          "File size is too large. File size must be less than 5 MB."
        );
      }
    };

    let objectURL = URL.createObjectURL(file);
    img.src = objectURL;
  });
});
