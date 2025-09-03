$(document).ready(function () {
  "use strict";
  if ($("#move_next_task").is(":checked")) {
    $("#move_next_task").prop("disabled", true);
    $("#scheduling_add").prop("disabled", false);
  }
  function parseDMYtoDate(dmy) {
    const [day, month, year] = dmy.split("-");
    return new Date(`${year}-${month}-${day}`);
  }
  $("#start_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    })
    .on("changeDate", function (e) {
      const startDate = e.date;
      $("#complete_date").datepicker("setStartDate", startDate);

      const completeDateVal = $("#complete_date").val();
      if (completeDateVal) {
        const completeDate = parseDMYtoDate(completeDateVal);
        if (completeDate < startDate) {
          $("#complete_date").datepicker("update", startDate);
        }
      }
    });

  $("#complete_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    })
    .on("changeDate", function (e) {
      const completeDate = e.date;
      const startDateVal = $("#start_date").val();

      if (startDateVal) {
        const startDate = parseDMYtoDate(startDateVal);
        if (completeDate < startDate) {
          $("#complete_date").datepicker("update", startDate);
        }
      }
    });

  const existingStartDate = $("#start_date").val();
  if (existingStartDate) {
    const startDate = parseDMYtoDate(existingStartDate);
    $("#complete_date").datepicker("setStartDate", startDate);

    const completeDateVal = $("#complete_date").val();
    if (completeDateVal && parseDMYtoDate(completeDateVal) < startDate) {
      $("#complete_date").datepicker("update", startDate);
    }
  }
  /* product scheduling modal*/
  $("#ps_start_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    })
    .on("changeDate", function (e) {
      const startDate = e.date;
      $("#ps_complete_date").datepicker("setStartDate", startDate);

      const completeDateVal = $("#ps_complete_date").val();
      if (completeDateVal) {
        const completeDate = parseDMYtoDate(completeDateVal);
        if (completeDate < startDate) {
          $("#ps_complete_date").datepicker("update", startDate);
        }
      }
    });

  $("#ps_complete_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    })
    .on("changeDate", function (e) {
      const completeDate = e.date;
      const startDateVal = $("#ps_start_date").val();

      if (startDateVal) {
        const startDate = parseDMYtoDate(startDateVal);
        if (completeDate < startDate) {
          $("#ps_complete_date").datepicker("update", startDate);
        }
      }
    });

  const existingPSStartDate = $("#ps_start_date").val();
  if (existingPSStartDate) {
    const startDate = parseDMYtoDate(existingPSStartDate);
    $("#ps_complete_date").datepicker("setStartDate", startDate);

    const completeDateVal = $("#ps_complete_date").val();
    if (completeDateVal && parseDMYtoDate(completeDateVal) < startDate) {
      $("#ps_complete_date").datepicker("update", startDate);
    }
  }
  /* quality check modal*/
  $("#qc_start_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      // startDate: new Date()
    })
    .on("changeDate", function (e) {
      const startDate = e.date;
      $("#qc_complete_date").datepicker("setStartDate", startDate);

      const completeDateVal = $("#qc_complete_date").val();
      if (completeDateVal) {
        const completeDate = parseDMYtoDate(completeDateVal);
        if (completeDate < startDate) {
          $("#qc_complete_date").datepicker("update", startDate);
        }
      }
    });

  $("#qc_complete_date")
    .datepicker({
      format: "dd-mm-yyyy",
      autoclose: true,
      todayHighlight: true,
      startDate: new Date(),
    })
    .on("changeDate", function (e) {
      const completeDate = e.date;
      const startDateVal = $("#qc_start_date").val();

      if (startDateVal) {
        const startDate = parseDMYtoDate(startDateVal);
        if (completeDate < startDate) {
          $("#qc_complete_date").datepicker("update", startDate);
        }
      }
    });

  const existingQCStartDate = $("#qc_start_date").val();
  if (existingQCStartDate) {
    const startDate = parseDMYtoDate(existingQCStartDate);
    $("#qc_complete_date").datepicker("setStartDate", startDate);

    const completeDateVal = $("#qc_complete_date").val();
    if (completeDateVal && parseDMYtoDate(completeDateVal) < startDate) {
      $("#qc_complete_date").datepicker("update", startDate);
    }
  }
  /* product scheduling row */
  $(".pstart_date").each(function () {
    const $startInput = $(this);
    const $endInput = $startInput.closest("tr").find(".pcomplete_date");

    $startInput
      .datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
      })
      .on("changeDate", function (e) {
        const startDate = e.date;
        $endInput.datepicker("setStartDate", startDate);

        const completeDateVal = $endInput.val();
        if (completeDateVal) {
          const completeDate = parseDMYtoDate(completeDateVal);
          if (completeDate < startDate) {
            $endInput.datepicker("update", startDate);
          }
        }
      });

    $endInput
      .datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
      })
      .on("changeDate", function (e) {
        const completeDate = e.date;
        const startDateVal = $startInput.val();
        if (startDateVal) {
          const startDate = parseDMYtoDate(startDateVal);
          if (completeDate < startDate) {
            $endInput.datepicker("update", startDate);
          }
        }
      });

    // Initial check
    const existingStartDate = $startInput.val();
    if (existingStartDate) {
      const startDate = parseDMYtoDate(existingStartDate);
      $endInput.datepicker("setStartDate", startDate);

      const completeDateVal = $endInput.val();
      if (completeDateVal && parseDMYtoDate(completeDateVal) < startDate) {
        $endInput.datepicker("update", startDate);
      }
    }
  });
  let product_id = $("#fproduct_id").val();
  let customer_order_id = $("#customer_order_id").val();
  let hidden_base_url = $("#hidden_base_url").val();
  cal_row();
  $.ajax({
    type: "POST",
    url: hidden_base_url + "getProductQty",
    data: { product_id: product_id, customer_order_id: customer_order_id },
    success: function (data) {
      let response = typeof data === "string" ? JSON.parse(data) : data;
      $("#product_quantity").val(response.quantity);
      $("#profit_margin").val(response.profit);
      $("#mtax_type").val(response.tax_type);
      $("#mtax_value").val(response.tax_value.toFixed(2));
    },
    error: function () {},
  });
  /* $.ajax({
        type: "POST",
        url: hidden_base_url + "getCustomerOrderProducts",
        data: { id: customer_order_id },
        success: function (data) {
            $("#fproduct_id option").remove();
            $("#fproduct_id").append(data);
            $(".select2").select2();
            $("#productionstage_id").select2({
                dropdownParent: $("#productScheduling"),
            });
            $("#user_id").select2({
                dropdownParent: $("#productScheduling"),
            });
        },
        error: function () {},
    }); */
  let tax_type = $(".tax_type").val();
  let input = document.getElementById("file_button");
  let default_currency = $("#default_currency").val();
  let target = $(".sort_menu");
  target.sortable({
    handle: ".handle",
    placeholder: "highlight",
    axis: "y",
    update: function (e, ui) {
      reorderSerial();
    },
  });
  function reorderSerial() {
    let i = 1;
    $(".set_sn4").each(function () {
      $(this).html(i);
      i++;
    });
  }
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
  checkBoxSingle();
  function checkBoxSingle() {
    $(".custom_checkbox").change(function (e) {
      e.preventDefault();
      $(".custom_checkbox").not(this).prop("checked", false);
      $(this).prop("checked", true);
    });
  }

  $("#productionstage_id").select2({
    dropdownParent: $("#productScheduling"),
  });
  $("#user_id").select2({
    dropdownParent: $("#productScheduling"),
  });
  $("#productScheduling").on("shown.bs.modal", function (e) {
    $(".daterangepicker").css("z-index", "1600");
  });
  $("#supplierModal").on("hidden.bs.modal", function () {
    $(this).find("form").trigger("reset");
  });
  $("#qc_user_id").select2({
    dropdownParent: $("#qcScheduling"),
  });
  $("#qc_status").select2({
    dropdownParent: $("#qcScheduling"),
  });

  /**
   * @description: Set Attribute
   * @returns: {void}
   */
  function setAttribute() {
    let i = 1;
    $(".set_sn").each(function () {
      $(this).html(i);
      i++;
    });
    i = 1;
    $(".set_sn").click(function () {
      $(this).html(i);
      i++;
    });
    i = 1;
    $(".set_sn1").each(function () {
      $(this).html(i);
      i++;
    });
    i = 1;
    $(".set_sn1").click(function () {
      $(this).html(i);
      i++;
    });
    i = 1;
    $(".set_sn2").each(function () {
      $(this).html(i);
      i++;
    });
    i = 1;
    $(".set_sn2").click(function () {
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
    i = 1;
    $(".total_c1").each(function () {
      $(this).attr("id", "total_1" + i);
      i++;
    });
    i = 1;
    $(".account_id_c1").each(function () {
      $(this).attr("id", "account_id" + i);
      i++;
    });
  }
  /**
   * @description Calculate Percentage
   * @param {*} total_amount
   * @param {*} percentage
   * @returns
   */
  function calPercentage(total_amount, percentage) {
    let plan_amount = (total_amount * percentage) / 100;
    return plan_amount;
  }

  /**
   * @description Calculate Row
   */
  function cal_row() {
    let i = 1;
    let row_total = 0;
    let row_total_total = 0;
    let noniitem = 0;
    let profit_total = 0;

    // Calculate row totals (unit_price * qty)
    $(".unit_price_c").each(function () {
      let unit_price = Number($("#unit_price_" + i).val());
      let qty = Number($("#qty_" + i).val());
      row_total = unit_price * qty;
      row_total_total += row_total;
      $("#total_" + i).val(row_total.toFixed(2));
      i++;
    });

    i = 1;
    $(".total_c1").each(function () {
      let total = Number($("#total_1" + i).val());
      noniitem += total;
      i++;
    });

    $("#rmcost_total").val(row_total_total.toFixed(2));
    $("#noninitem_total").val(noniitem.toFixed(2));
    $("#total_cost").val((noniitem + row_total_total).toFixed(2));

    // Calculate profit margin amount
    $(".margin_cal").each(function () {
      let profit_margin = Number($(".profit_margin").val());
      let total_cos = Number($("#total_cost").val());
      profit_total = (total_cos * profit_margin) / 100;
    });

    // Calculate base price before tax
    let base_price = noniitem + row_total_total + profit_total;
    let tax_value = Number($("#mtax_value").val());
    let final_sale_price = base_price + tax_value;
    $("#sale_price").val(final_sale_price.toFixed(2));
  }

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr("content"),
    },
  });
  $(document).on("click", "#pr_go", function (e) {
    e.preventDefault();
    $(".submit_btn").removeClass("disabled");
    $("#checkStockButton").addClass("d-none");
    if (!Number($(".product_quantity").val())) {
      let hidden_alert = $("#hidden_alert").val();
      let hidden_cancel = $("#hidden_cancel").val();
      let hidden_ok = $("#hidden_ok").val();
      swal({
        title: hidden_alert + "!",
        text: "Quantity Field is Empty",
        cancelButtonText: hidden_cancel,
        confirmButtonText: hidden_ok,
        confirmButtonColor: "#3c8dbc",
      });
    } else {
      let hidden_base_url = $("#hidden_base_url").val();
      let product_quantity = $(".product_quantity").val();
      let selected_customer_id = $("#customer_id").val();
      let customer_order_id = $("#customer_order_id").val();
      let stk_mat_type = $("#stk_mat_type").val();
      let params = $(".fproduct_id").val();
      let separate_params = params.split("|");
      let fproduct_id = separate_params[0];
      $(".hidden_sec").removeClass("hidden_sec");
      $.ajax({
        type: "POST",
        url: hidden_base_url + "getProductById",
        data: { id: fproduct_id },
        dataType: "json",
        success: function (data) {
          $("#rev").val(data.rev);
          $("#operation").val(data.operation);
          $("#drawer_no").val(data.drawer_no);
        },
        error: function () {},
      });
      $.ajax({
        type: "POST",
        url: hidden_base_url + "getFinishProductRManufacture",
        data: {
          id: fproduct_id,
          value: product_quantity,
          stk_mat_type: stk_mat_type,
          selected_customer_id: selected_customer_id,
          customer_order_id: customer_order_id,
        },
        dataType: "json",
        success: function (data) {
          if (data.result == true) {
            $(".submit_btn").removeClass("disabled");
            $("#checkStockButton").addClass("d-none");
          } else {
            $(".submit_btn").addClass("disabled");
            $("#checkStockButton").removeClass("d-none");
          }
          $(".add_trm").empty();
          $(".add_trm").html(data.html);
          setAttribute();
          cal_row();
          $(".add_trm .rowCount").each(function () {
            let material_id = $(this).find(".rm_id").val();
            let quantity = $(this).find(".qty_c").val();
            checkSingleMaterialStock(material_id, quantity);
          });
        },
        error: function () {},
      });
      /* $.ajax({
                type: "POST",
                url: hidden_base_url + "getFinishProductNONI",
                data: { id: fproduct_id, value: product_quantity },
                dataType: "json",
                success: function (data) {
                    $(".add_tnoni").html(data);
                    setAttribute();
                    cal_row();
                    $(".select2").select2();
                    $("#productionstage_id").select2({
                        dropdownParent: $("#productScheduling"),
                    });
                },
                error: function () {},
            }); */
      $.ajax({
        type: "POST",
        url: hidden_base_url + "getFinishProductStages",
        data: { id: fproduct_id, value: product_quantity },
        dataType: "json",
        success: function (data) {
          $(".add_tstage").html(data.html);
          $("#t_month").val(data.total_month);
          $("#t_day").val(data.total_day);
          $("#t_hours").val(data.total_hour);
          $("#t_minute").val(data.total_minute);
          setAttribute();
          cal_row();
          checkBoxSingle();
        },
        error: function () {},
      });
      $.ajax({
        type: "POST",
        url: hidden_base_url + "getProductionStages",
        data: { id: fproduct_id },
        dataType: "json",
        success: function (data) {
          $("#productionstage_id").empty();
          $("#productionstage_id").html(data.html);
        },
        error: function () {},
      });
    }
  });
  /**
   * @description Raw Material Stock Check
   * @param {*} product_quantity
   * @param {*} fproduct_id
   */
  function rawMaterialStockCheck(product_quantity, fproduct_id) {
    let hidden_base_url = $("#hidden_base_url").val();
    $.ajax({
      type: "POST",
      url: hidden_base_url + "rawMaterialStockCheck",
      data: { product_id: fproduct_id, quantity: product_quantity },
      dataType: "json",
      success: function (data) {
        let need_purchase = false;
        for (let i = 0; i < data.length; i++) {
          if (data[i].status == "need_purchase") {
            need_purchase = true;
            break;
          }
        }
        if (need_purchase == true) {
          let hidden_alert =
            "Your Stock is not enough. Check the stock and purchase the raw materials.";
          let hidden_cancel = $("#hidden_cancel").val();
          let hidden_ok = $("#hidden_ok").val();
          swal({
            title: hidden_alert + "!",
            text: data.message,
            cancelButtonText: hidden_cancel,
            confirmButtonText: hidden_ok,
            confirmButtonColor: "#3c8dbc",
          });

          $(".submit_btn").addClass("disabled");
          $("#checkStockButton").removeClass("d-none");
        }
      },
      error: function () {},
    });
  }

  $(document).on("click", "#checkStockButton", function (e) {
    e.preventDefault();
    let hidden_base_url = $("#hidden_base_url").val();
    let stk_mat_type = $("#stk_mat_type").val();
    let selected_customer_id = $("#customer_id").val();

    //all class rm id
    let rm_id = $(".rm_id")
      .map(function () {
        return $(this).val();
      })
      .get();
    //all class qty
    let quantity = $(".qty_c")
      .map(function () {
        return $(this).val();
      })
      .get();
    let requestData = {
      rm_id: rm_id ?? "",
      quantity: quantity ?? "",
      stk_mat_type: stk_mat_type ?? "",
      selected_customer_id: selected_customer_id ?? "",
    };
    $.ajax({
      type: "POST",
      url: hidden_base_url + "rawMaterialStockCheckByMaterial",
      data: requestData,
      dataType: "json",
      success: function (data) {
        let table =
          '<table class="table table-bordered table-striped"><thead><tr><th>Raw Material</th><th>Stock</th><th>Required Quantity</th><th>Shortage</th></tr></thead><tbody>';
        if (data.length === 0) {
          table +=
            '<tr><td colspan="4" class="text-center text-danger">No Stock Material Available.</td></tr>';
        } else {
          for (let i = 0; i < data.length; i++) {
            let shortage = data[i].required - data[i].stock;
            shortage = shortage < 0 ? 0 : shortage;
            table +=
              "<tr><td>" +
              data[i].name +
              "</td><td>" +
              data[i].stock_final +
              data[i].unit +
              "</td><td>" +
              data[i].required +
              data[i].unit +
              "</td><td>" +
              shortage +
              data[i].unit +
              "</td></tr>";

            //Hidden Field Form for Purchase
            table +=
              '<input type="hidden" name="rm_id[]" value="' + data[i].id + '">';
            table +=
              '<input type="hidden" name="shortage[]" value="' +
              shortage +
              '">';
            table +=
              '<input type="hidden" name="status[]" value="' +
              data[i].status +
              '">';
          }
        }
        table += "</tbody></table>";
        $("#check_stock_modal_body").html(table);
      },
      error: function () {},
    });
  });

  let i = 0;
  $(document).on("change", ".rmaterials_id", function (e) {
    let params = $(this).find(":selected").val();
    let separate_params = params.split("|");
    //cloasest parent td rm_id value set not parent use
    $(this).closest("td").find(".rm_id").val(separate_params[0]);
    $(this).parent().parent().parent().find(".pfrmup").val(separate_params[5]);
    $(this)
      .parent()
      .parent()
      .parent()
      .find(".rmhunit")
      .html(separate_params[6]);
    $(this)
      .parent()
      .parent()
      .parent()
      .find(".rmcurrency")
      .html(separate_params[3]);
  });

  $(document).on("click", "#fprmaterial", function (e) {
    ++i;
    let ram_hidden = $("#ram_hidden").html();
    $(".add_trm").append(
      "<tr>" +
        ' <td class="width_1_p text-start"><p class="set_sn rowCount"></p></td>' +
        '<td><input type="hidden" class="rm_id" /><select class="form-control rmaterials_id" name="rm_id[]">\n' +
        ram_hidden +
        "</select></td>" +
        '<td><div class="input-group"><input type="text" data-countid="1" tabindex="51" id="qty_1" name="quantity_amount[]" onfocus="this.select();" class="check_required form-control integerchk input_aligning qty_c cal_row" value="" placeholder="Consumption"><span class="input-group-text rmhunit">Piece</span></div></td>' +
        '<td class="text-end"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
        "</tr>"
    );
    $(".select2").select2();
    $("#productionstage_id").select2({
      dropdownParent: $("#productScheduling"),
    });
    $("#user_id").select2({
      dropdownParent: $("#productScheduling"),
    });
    setAttribute();
    cal_row();
  });

  $(document).on("change", ".noninvemtory_id", function (e) {
    let params = $(this).find(":selected").val();
    let separate_params = params.split("|");
    $(this)
      .parent()
      .parent()
      .parent()
      .find(".nicurrency")
      .html(separate_params[2]);
  });

  i = 0;
  $(document).on("click", "#fpnonitem", function (e) {
    ++i;
    let noni_hidden = $("#noni_hidden").html();
    let account_hidden = $("#account_hidden").html();
    $(".add_tnoni").append(
      "<tr>" +
        ' <td class="width_1_p"><p class="set_sn1 rowCount1"></p></td>' +
        '<td><select class="form-control noninvemtory_id" name="noniitem_id[]" id="noninvemtory_id">\n' +
        noni_hidden +
        "</select></td><td></td>" +
        '<td><div class="input-group"><input type="text" id="total_1" name="total_1[]" class="cal_row check_required  form-control aligning total_c1" onfocus="select();" value="" placeholder="Non Inventory Cost"><span class="input-group-text nicurrency">$</span></div></td>' +
        '<td><div><select class="form-control account_id_c1" name="account_id[]" id="account_id">\n' +
        account_hidden +
        "</select></td></div>" +
        '<td class="text-end"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
        "</tr>"
    );
    $(".select2").select2();
    $("#productionstage_id").select2({
      dropdownParent: $("#productScheduling"),
    });
    $("#user_id").select2({
      dropdownParent: $("#productScheduling"),
    });
    setAttribute();
    cal_row();
  });

  $(document).on("click", ".del_row", function (e) {
    $(this).parent().parent().remove();
    setAttribute();
    cal_row();
  });

  $(document).on("click", ".del_row_noni", function (e) {
    $(this).parent().parent().remove();
    setAttribute();
    cal_row();
  });

  $(document).on("click", ".del_row_prostage", function (e) {
    $(this).parent().parent().remove();
    setAttribute();
    cal_row();
  });

  $(document).on("keyup", ".margin_cal", function (e) {
    cal_row();
  });

  $(document).on("keyup", ".cal_row", function (e) {
    cal_row();
    let material_id = $(this).parent().parent().parent().find(".rm_id").val();
    let quantity = $(this).val();
    checkSingleMaterialStock(material_id, quantity);
  });

  $(document).on("keyup", ".qty_c", function (e) {
    let quantity = $(this).val();
    let material_id = $(this).parent().parent().parent().find(".rm_id").val();
    checkSingleMaterialStock(material_id, quantity);
  });

  /**
   * @description Check Single Material Stock
   * @param {*} material_id
   * @param {*} quantity
   * @returns
   */
  function checkSingleMaterialStock(material_id, quantity) {
    let hidden_base_url = $("#hidden_base_url").val();
    let stk_mat_type = $("#stk_mat_type").val();
    let params = $(".fproduct_id").val();
    let separate_params = params.split("|");
    let fproduct_id = separate_params[0];
    let customer_order_id = $("#customer_order_id").val();
    let selected_customer_id = $("#customer_id").val();
    let status = false;
    $.ajax({
      type: "POST",
      url: hidden_base_url + "checkSingleMaterialStock",
      data: {
        material_id: material_id,
        quantity: quantity,
        stk_mat_type: stk_mat_type,
        fproduct_id: fproduct_id,
        customer_order_id: customer_order_id,
        selected_customer_id: selected_customer_id,
      },
      dataType: "json",
      async: false,
      success: function (data) {
        if (data.status == "need_purchase") {
          status = true;
        }
        if (status == true) {
          $(".submit_btn").addClass("disabled");
          $("#checkStockButton").removeClass("d-none");
        } else {
          $(".submit_btn").removeClass("disabled");
          $("#checkStockButton").addClass("d-none");
        }
      },
      error: function () {},
    });
    return status;
  }

  $(document).on("click", ".set_class", function (e) {
    let this_value = $(this).val();
    let stage_name = $(this).attr("data-stage_name");
    console.log("counter => " + this_value);
    console.log("stage_name =>" + stage_name);
    $("#stage_counter").val(this_value);
    $("#stage_name").val(stage_name);
  });

  $(document).on("submit", "#manufacture_form", function (e) {
    let status = true;
    let focus = 1;
    let ref_no = $("#code").val();
    let customer_id = $("#customer_id").val();
    let customer_order_id = $("#customer_order_id").val();
    let stk_mat_type = $("#stk_mat_type").val();
    let drawer_no = $("#drawer_no").val();
    let statusField = $("#m_status").val();
    let start_date = $("#start_date").val();
    let completeDate = $("#complete_date").val();
    let quantity = $("#product_quantity").val();
    let batch_no = $("#batch_no").val();
    let expiry_days = $("#expiry_days").val();
    let st_method = $("#st_method").val();
    let stageCheckValue =
      $("input[name='stage_check']:checked").val() ||
      $("input[name='stage_check_hidden[]']").val();
    let todayObj = new Date();
    let today =
      String(todayObj.getDate()).padStart(2, "0") +
      "-" +
      String(todayObj.getMonth() + 1).padStart(2, "0") +
      "-" +
      todayObj.getFullYear();

    if (ref_no == "") {
      status = false;
      showErrorMessage("code", "The PPCRC Number field is Required");
    } else {
      $("#code").removeClass("is-invalid");
      $("#code").closest("div").find(".text-danger").addClass("d-none");
    }

    if (customer_id == "") {
      status = false;
      showErrorMessage("customer_id", "The Customer Name field is Required");
    } else {
      $("#customer_id").removeClass("is-invalid");
      $("#customer_id").closest("div").find(".text-danger").addClass("d-none");
    }

    if (customer_order_id == "") {
      status = false;
      showErrorMessage("customer_order_id", "The PO Number field is Required");
    } else {
      $("#customer_order_id").removeClass("is-invalid");
      $("#customer_order_id")
        .closest("div")
        .find(".text-danger")
        .addClass("d-none");
    }

    if (stk_mat_type == "") {
      status = false;
      showErrorMessage("stk_mat_type", "The Material Type field is Required");
    } else {
      $("#stk_mat_type").removeClass("is-invalid");
      $("#stk_mat_type").closest("div").find(".text-danger").addClass("d-none");
    }

    if (statusField == "") {
      status = false;
      showErrorMessage("m_status", "The Status field is Required");
    } else if (statusField === "draft" && start_date === today) {
      status = false;
      showErrorMessage(
        "m_status",
        "You cannot save as draft if the start date is today."
      );
    } else {
      $("#m_status").removeClass("is-invalid");
      $("#m_status").closest("div").find(".text-danger").addClass("d-none");
    }

    if (start_date == "") {
      status = false;
      showErrorMessage("start_date", "The Start Date field is Required");
    } else {
      $("#start_date").removeClass("is-invalid");
      $("#start_date").closest("div").find(".text-danger").addClass("d-none");
    }

    /* if (drawer_no == "") {
            status = false;
            showErrorMessage("drawer_no", "The Drawer No field is Required");
        } else {
            $("#drawer_no").removeClass("is-invalid");
            $("#drawer_no").closest("div").find(".text-danger").addClass("d-none");
        } */

    if (quantity == "") {
      status = false;
      showErrorMessage("product_quantity", "The Quantity field is Required");
    } else {
      $("#product_quantity").removeClass("is-invalid");
      $("#product_quantity")
        .closest("div")
        .find(".text-danger")
        .addClass("d-none");
    }
    if (statusField == "done" && completeDate == "") {
      status = false;
      showErrorMessage("complete_date", "The Delivery Date field is Required");
    } else {
      $("#complete_date").removeClass("is-invalid");
      $("#complete_date")
        .closest("div")
        .find(".text-danger")
        .addClass("d-none");
    }
    if (statusField == "inProgress" && !stageCheckValue) {
      status = false;
      $(".stage_check_error").removeClass("d-none");
      $(".stage_check_error").text("Please select minimum one stage");
    } else {
      $(".stage_check_error").addClass("d-none");
    }
    // check complete date not less than start date
    if (start_date != "" && completeDate != "") {
      let sd = new Date(start_date);
      let cd = new Date(completeDate);
      if (cd < sd) {
        status = false;
        showErrorMessage(
          "complete_date",
          "Delivery Date can't be before than Start Date"
        );
      } else {
        $("#complete_date").removeClass("is-invalid");
        $("#complete_date")
          .closest("div")
          .find(".text-danger")
          .addClass("d-none");
      }
    }
    // every quantity must be greater than 0
    $(".qty_c").each(function () {
      let quantity = Number($(this).val());
      if (quantity == "") {
        status = false;
        let message = "Quantity field is Required";
        $("#qty_1").addClass("is-invalid");
        let closestDiv = $(".quantityErr").text(message);
        closestDiv.removeClass("d-none");
      } else {
        $("#qty_1").removeClass("is-invalid");
        $(".quantityErr").addClass("d-none");
      }
      if (quantity <= 0) {
        status = false;
        let message = "Quantity must be greater than 0";
        $("#qty_1").addClass("is-invalid");
        let closestDiv = $(".quantityErr").text(message);
        closestDiv.removeClass("d-none");
      } else {
        $("#qty_1").removeClass("is-invalid");
        $(".quantityErr").addClass("d-none");
      }
    });

    let rowCount = $(".rowCount").length;

    if (!Number(rowCount)) {
      status = false;
      showErrorMessage("fproduct_id", "The Part Name field is Required");
    } else {
      $("#fproduct_id").removeClass("is-invalid");
      $("#fproduct_id").closest("div").find(".text-danger").addClass("d-none");
    }

    if (status == false) {
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

  $(document).on("change", ".fproduct_id", function (e) {
    let params = $(this).find(":selected").val();
    let separate_params = params.split("|");
    let st_method = separate_params[1];
    $("#st_method").val(st_method);
    if (st_method === "none") {
      $(".none_method").hide();
    } else {
      $(".none_method").show();
    }
    if (st_method === "fifo") {
      $(".none_method").hide();
    }
    if (st_method === "fefo") {
      $(".fefo_method").hide();
    }
    if (st_method === "batchcontrol") {
      $(".batch_method").hide();
    }
  });
  // function checkStatusOptions() {
  //     const startDateVal = $('#start_date').val();
  //     const $draftOption = $('#status_draft');
  //     const $statusSelect = $('#m_status');
  //     if (!startDateVal) return;
  //     const today = new Date().toISOString().split('T')[0];
  //     if (startDateVal === today) {
  //         if ($statusSelect.val() === 'draft') {
  //             $statusSelect.val('').trigger('change');
  //         }
  //         $draftOption.prop('disabled', true);
  //     } else {
  //         $draftOption.prop('disabled', false);
  //     }
  // }
  // $(document).on("change", "#start_date", function (e) {
  //     checkStatusOptions();
  // });
  $(document).on("change", "#manufactures", function (e) {
    let manufacture_type = $(this).find(":selected").val();

    if (manufacture_type == "fco") {
      let customers_hidden = $("#customers_hidden").html();

      $("#customer_order_area").html(
        '<div class="col-sm-12 col-md-6 mb-2 col-lg-4">' +
          '<div class="form-group"><label>Customer <span class="required_star">*</span></label>' +
          '<select class="form-control customer_id_c1 select2" name="customer_id" id="customer_id">\n' +
          customers_hidden +
          "</select></div></div>" +
          '<div class="col-sm-12 col-md-6 mb-2 col-lg-4"><div class="form-group"><div id="customer_order_list"></div></div></div>'
      );

      $(".select2").select2();
      $("#productionstage_id").select2({
        dropdownParent: $("#productScheduling"),
      });
      $("#user_id").select2({
        dropdownParent: $("#productScheduling"),
      });
    } else {
      $("#customer_order_area").html("");
    }
  });

  $(document).on("change", "#customer_id", function (e) {
    let customer_id = $(this).find(":selected").val();
    let hidden_base_url = $("#hidden_base_url").val();

    $.ajax({
      type: "POST",
      url: hidden_base_url + "getCustomerOrderList",
      data: { id: customer_id },
      success: function (data) {
        $("#customer_order_id option").remove();
        $("#customer_order_id").append(data);
        $(".select2").select2();
        $("#productionstage_id").select2({
          dropdownParent: $("#productScheduling"),
        });
        $("#user_id").select2({
          dropdownParent: $("#productScheduling"),
        });
      },
      error: function () {},
    });
  });

  $(document).on("change", "#customer_order_id", function (e) {
    let customer_order_id = $(this).find(":selected").val();
    let hidden_base_url = $("#hidden_base_url").val();

    $.ajax({
      type: "POST",
      url: hidden_base_url + "getCustomerOrderProducts",
      data: { id: customer_order_id },
      success: function (data) {
        $("#fproduct_id option").remove();
        $("#fproduct_id").append(data);
        $(".select2").select2();
        $("#productionstage_id").select2({
          dropdownParent: $("#productScheduling"),
        });
        $("#user_id").select2({
          dropdownParent: $("#productScheduling"),
        });
      },
      error: function () {},
    });
  });

  $(document).on("change", "#fproduct_id", function (e) {
    let product_id = $(this).find(":selected").val();
    let customer_order_id = $("#customer_order_id").val();
    let hidden_base_url = $("#hidden_base_url").val();
    $.ajax({
      type: "POST",
      url: hidden_base_url + "getProductQty",
      data: { product_id: product_id, customer_order_id: customer_order_id },
      success: function (data) {
        let response = typeof data === "string" ? JSON.parse(data) : data;
        $("#product_quantity").val(response.quantity);
        $("#profit_margin").val(response.profit);
        $("#mtax_type").val(response.tax_type);
        $("#mtax_value").val(response.tax_value.toFixed(2));
      },
      error: function () {},
    });
  });

  setAttribute();
  cal_row();
  $(document).on("click", ".print_class", function (e) {
    window.print();
  });

  // Date Month Calculate
  $(document).on("change", "#month_limit", function (e) {
    let max = parseInt($(this).attr("max"));
    let min = parseInt($(this).attr("min"));
    if ($(this).val() > max) {
      $(this).val(max);
    } else if ($(this).val() < min) {
      $(this).val(min);
    }
    totalMonthDaysHourMinuteCalculate();
  });
  $(document).on("change", "#day_limit", function (e) {
    let max = parseInt($(this).attr("max"));
    let min = parseInt($(this).attr("min"));
    if ($(this).val() > max) {
      let month = $(this).closest("tr").find("#month_limit").val();
      month = month == "" ? 0 : month;
      let countedValue = parseInt($(this).val() / 30);
      let countedValue1 = parseInt($(this).val()) % 30;
      month = parseInt(month) + countedValue;
      $(this).closest("tr").find("#month_limit").val(month);
      $(this).val(countedValue1);
    } else if ($(this).val() < min) {
      $(this).val(min);
    }
    totalMonthDaysHourMinuteCalculate();
  });
  $(document).on("change", "#hours_limit", function (e) {
    let max = parseInt($(this).attr("max"));
    let min = parseInt($(this).attr("min"));
    if ($(this).val() > max) {
      let day = $(this).closest("tr").find("#day_limit").val();
      day = day == "" ? 0 : day;
      let countedValue = parseInt($(this).val() / 24);
      let countedValue1 = parseInt($(this).val()) % 24;
      day = parseInt(day) + countedValue;
      $(this).closest("tr").find("#day_limit").val(day);
      $(this).val(countedValue1);
    } else if ($(this).val() < min) {
      $(this).val(min);
    }
    totalMonthDaysHourMinuteCalculate();
  });
  $(document).on("change", "#minute_limit", function (e) {
    let max = parseInt($(this).attr("max"));
    let min = parseInt($(this).attr("min"));
    if ($(this).val() > max) {
      let hours = $(this).closest("tr").find("#hours_limit").val();
      hours = hours == "" ? 0 : hours;
      let countedValue = parseInt($(this).val() / 60);
      let countedValue1 = parseInt($(this).val()) % 60;
      hours = parseInt(hours) + countedValue;
      $(this).closest("tr").find("#hours_limit").val(hours);
      $(this).val(countedValue1);
    } else if ($(this).val() < min) {
      $(this).val(min);
    }

    totalMonthDaysHourMinuteCalculate();
  });

  function totalMonthDaysHourMinuteCalculate() {
    let totalMonth = 0;
    let totalDays = 0;
    let totalHours = 0;
    let totalMinutes = 0;

    $(".stage_name").each(function () {
      let month =
        parseInt($(this).closest("tr").find("#month_limit").val()) || 0;
      let day = parseInt($(this).closest("tr").find("#day_limit").val()) || 0;
      let hour =
        parseInt($(this).closest("tr").find("#hours_limit").val()) || 0;
      let minute =
        parseInt($(this).closest("tr").find("#minute_limit").val()) || 0;

      totalMonth += month;
      totalDays += day;
      totalHours += hour;
      totalMinutes += minute;
    });

    console.log(totalMonth, totalDays, totalHours, totalMinutes);

    $("#t_month").val(totalMonth);
    $("#t_day").val(totalDays);
    $("#t_hours").val(totalHours);
    $("#t_minute").val(totalMinutes);
  }
  /* Qc Assign Log button click */
  $(document).on("click", "#qc_view", function (e) {
    e.preventDefault();
    let hidden_base_url = $("#hidden_base_url").val();
    let manufacture_id = $(this).data("manufacture_id");
    let scheduling_id = $(this).data("scheduling_id");
    let production_stage_id = $(this).data("production_stage_id");
    $("#qa_manufacture_id").val(manufacture_id);
    $("#qa_scheduling_id").val(scheduling_id);
    $("#qa_production_stage_id").val(production_stage_id);
    let qa_manufacture_id = $("#qa_manufacture_id").val();
    let qa_scheduling_id = $("#qa_scheduling_id").val();
    let qa_production_stage_id = $("#qa_production_stage_id").val();
    let requestData = {
      manufacture_id: qa_manufacture_id ?? "",
      production_stage_id: qa_production_stage_id ?? "",
      scheduling_id: qa_scheduling_id ?? "",
    };
    $.ajax({
      type: "POST",
      url: hidden_base_url + "getQCAssignLog",
      data: requestData,
      dataType: "json",
      success: function (data) {
        let table = "";
        if (data.length === 0) {
          table +=
            '<tr><td colspan="4" class="text-center text-danger">No QC Assigned.</td></tr>';
        } else {
          table +=
            '<div class="d-flex justify-content-between"><h5 class="modal-title ms-2">' +
            data[0].stage_name +
            '</h5><div id="move_next_task_wrapper" class="form-check mb-1 ' +
            (data[0].status == 0 ? "d-none" : "") +
            '"><input class="form-check-input move_next" type="checkbox" id="move_next_task"' +
            (data[0].move_to_next === "Y" ? "checked disabled" : "") +
            '><label class="form-check-label" for="move_next_task">Move Next Task</label><p class="text-success d-none" id="check-msg">Checked!</p></div></div><hr><table class="table table-bordered table-striped"><thead><tr><th>Employee Name</th><th>Start Date</th><th>Complete date</th><th>Status</th><th>Note</th></tr></thead><tbody>';
          for (let i = 0; i < data.length; i++) {
            let statusesOptions = "";
            let isStatusMatched = false;
            for (let j = 0; j < data[i].statuses.length; j++) {
              let status = data[i].statuses[j];
              let selected = "";
              if (status.id == data[i].status) {
                selected = "selected";
                isStatusMatched = true;
              }
              statusesOptions += `<option value="${status.id}" ${selected}>${status.name}</option>`;
            }
            let pendingSelected = isStatusMatched ? "" : "selected";
            let disabledAttr = data[i].status == "1" ? "disabled" : "";
            statusesOptions =
              `<option value="" ${pendingSelected}>Pending</option>` +
              statusesOptions;
            let statusSelect = `<select class="form-control select2 qc-status" data-id="${data[i].id}" ${disabledAttr}>${statusesOptions}</select><div class="qc-status-msg"></div>`;
            table +=
              "<tr><td>" +
              data[i].emp_name +
              "</td><td>" +
              data[i].start_date +
              "</td><td>" +
              data[i].complete_date +
              "</td><td>" +
              statusSelect +
              "</td><td>" +
              data[i].note +
              "</td></tr>";
            table +=
              '<input type="hidden" name="id[]" value="' + data[i].id + '">';
          }
        }
        table += "</tbody></table>";
        $("#qc_log_modal_body").html(table);
        // $("#qc_log_modal_body").html("");
      },
      error: function () {},
    });
  });
  $(document).on("change", ".qc-status", function (e) {
    let $this = $(this);
    let status = $this.val();
    let qc_id = $this.data("id");
    let $statusMsg = $this.closest("td").find(".qc-status-msg");
    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "updateQCStatus",
      data: { qc_id: qc_id, status: status },
      dataType: "json",
      success: function (data) {
        $statusMsg
          .html('<span class="text-success">' + data.message + "</span>")
          .delay(5000)
          .fadeOut();
        $("#move_next_task_wrapper").removeClass("d-none");
        if (status === "1") {
          $this.prop("disabled", true);
        }
      },
      error: function () {
        $statusMsg
          .html('<span class="text-danger">Something went wrong.</span>')
          .delay(5000)
          .fadeOut();
        $("#move_next_task_wrapper").addClass("d-none");
      },
    });
  });
  $(document).on("change", ".move_next", function (e) {
    const checkbox = this;
    let qa_scheduling_id = $("#qa_scheduling_id").val();
    const url = $("#hidden_base_url").val() + "updateMoveStatus";
    $.ajax({
      type: "POST",
      url: $("#hidden_base_url").val() + "updateMoveStatus",
      data: { qa_scheduling_id: qa_scheduling_id, move_to_next: "Y" },
      dataType: "json",
      success: function (data) {
        $(checkbox).prop("disabled", true).prop("checked", true);
        $("#scheduling_add").prop("disabled", false);
        $("#check-msg").removeClass("d-none").fadeIn();
        setTimeout(() => {
          $("#check-msg").fadeOut(() => {
            $("#check-msg").addClass("d-none");
          });
        }, 3000);
      },
      error: function () {
        // Optional: show error message
      },
    });
  });
});
