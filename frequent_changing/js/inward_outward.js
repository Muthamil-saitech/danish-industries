
function showErrorMessage(id, message) {
  $("#" + id + "").addClass("is-invalid");
  let closestDiv = $("#" + id + "")
    .closest("div")
    .find(".text-danger");
  closestDiv.text(message);
  closestDiv.removeClass("d-none");
}
function validateSelect2Field($select, fieldName) {
  let value = $select.val();
  let $select2Container = $select.next(".select2"); 
  if (!value) {
    $select2Container.find(".select2-selection").addClass("is-invalid");
    if (!$select2Container.next(".text-danger").length) {
      $select2Container.after(
        '<div class="text-danger">The ' + fieldName + " field is required</div>"
      );
    }
    return false;
  } else {
    $select2Container.find(".select2-selection").removeClass("is-invalid");
    $select2Container.next(".text-danger").remove();
    return true;
  }
}
/* For Customer IO */
let i = 0;
$(document).on("click", "#customer_io", function (e) {
  ++i;
  $(".errProduct").remove();
  let hidden_type = $("#hidden_type").html();
  let firstInterState = $(".add_cio").append(
    "<tr>" +
      '<td class="ir_txt_center"><p class="set_sn rowCount">' +
      i +
      "</p></td>" +
      '<td><select class="form-control type select2" name="type[]" id="type_' +
      i +
      '"><option value="">Please Select</option>\n' +
      hidden_type +
      "</select></td>" +
      '<td><select class="form-control ins_category select2" name="ins_category[]" id="ins_category_' +
      i +
      '"><option value="">Please Select</option>\n' +
      "</select></td>" +
      '<td><select class="form-control ins_name select2" name="ins_name[]" id="ins_name_' +
      i +
      '"><option value="">Please Select</option>\n' +
      "</select></td>" +
      '<td><input type="number" name="qty[]" class="check_required form-control integerchk qty_c" placeholder="Quantity" id="quantity_' +
      i +
      '"></td>' +
      '<td><textarea class="form-control" name="remarks[]" placeholder="Remarks" id="remarks"></textarea></td>' +
      '<td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
      "</tr>"
  );
    $(".select2").select2();
});

$(document).on("click", ".order_io_submit_button", function () {
  let status = true;
  let po_no = $("#po_no").val();
  let date = $("#io_date").val();
  let c_phn_no = $("#c_phn_no").val();
  let d_address = $("#d_address").val();
  // let type = $(".type").val();
  // let ins_category = $(".ins_category").val();
  // let instrument_name = $(".instrument_name").val();

  if (po_no == "") {
    showErrorMessage("po_no", "The PO Number field is required");
    status = false;
  } else {
    $("#po_no").removeClass("is-invalid");
    $("#po_no").closest("div").find(".text-danger").addClass("d-none");
  }
  if (date == "") {
    showErrorMessage("io_date", "The date field is required");
    status = false;
  } else {
    $("#io_date").removeClass("is-invalid");
    $("#io_date").closest("div").find(".text-danger").addClass("d-none");
  } 
  if (c_phn_no == "") {
    showErrorMessage("c_phn_no", "The phone number field is required");
    status = false;
  } else {
    $("#c_phn_no").removeClass("is-invalid");
    $("#c_phn_no").closest("div").find(".text-danger").addClass("d-none");
  } 
  if ($("#d_address").val() == "") {
    $("#d_address").addClass("is-invalid");
    if (!$("#d_address").next(".text-danger").length) {
      $("#d_address").after(
        '<div class="text-danger">The delivery address field is required</div>'
      );
    }
    status = false;
  } else {
    $("#d_address").removeClass("is-invalid");
    $("#d_address").next(".text-danger").remove();
  }

  let hasError = false;

  $("select[name='type[]']").each(function () {
    if (!validateSelect2Field($(this), "type")) {
      hasError = true;
    }
  });

  $("select[name='ins_category[]']").each(function () {
    if (!validateSelect2Field($(this), "category")) {
      hasError = true;
    }
  });

  $("select[name='ins_name[]']").each(function () {
    if (!validateSelect2Field($(this), "instrument name")) {
      hasError = true;
    }
  });


  if (hasError) {
    status = false;
  }

  let rowCount = $(".rowCount").length;
  if (!Number(rowCount)) {
    status = false;
    $("#ciofrm .add_cio").html(
      '<tr><td colspan="6" class="text-danger errProduct">Please add minimum one row</td></tr>'
    );
  } 

  if (status == true) {
    return true;
  } else {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  }
});

/* For Partner IO */

let j = 0;

$(document).on("click", "#partner_io", function (e) {
  ++j;
  let hidden_type = $("#hidden_type").html();
  $(".add_partner").append(
    "<tr>" +
      '<td class="ir_txt_center"><p class="set_sn rowCount">' +
      j +
      "</p></td>" +
      '<td><select class="form-control type select2" name="type[]" id="type_' +
      j +
      '"><option value="">Please Select</option>\n' +
      hidden_type +
      "</select></td>" +
      '<td><select class="form-control ins_category select2" name="ins_category[]" id="ins_category_' +
      j +
      '"><option value="">Please Select</option>\n' +
      "</select></td>" +
      '<td><select class="form-control ins_name select2" name="ins_name[]" id="ins_name_' +
      j +
      '"><option value="">Please Select</option>\n' +
      "</select></td>" +
      '<td><input type="number" name="qty[]" class="check_required form-control integerchk qty_c" placeholder="Quantity" id="quantity_' +
      j +
      '"></td>' +
      '<td><textarea class="form-control" name="remarks[]" placeholder="Remarks" id="remarks_' +
      j +
      '"></textarea></td>' +
      '<td><input type="text" name="line_item_no[]" class="form-control" placeholder="Line Item No" /></td>' +
      '<td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
      "</tr>"
  );
  $(".select2").select2();
});

$(document).on("click",".partner_io_submit_button", function() {
  let status = true;
  let reference_no = $("#reference_no").val();
  let partner_id = $("#partner_id").val();
  let io_date = $("#io_date").val();
  let phn_no = $("#phn_no").val();
  let d_address = $("#d_address").val();

  if (reference_no == "") {
    showErrorMessage("reference_no", "The reference number field is required");
    status = false;
  } else {
    $("#reference_no").removeClass("is-invalid");
    $("#reference_no").closest("div").find(".text-danger").addClass("d-none");
  }
  if (partner_id == "") {
    showErrorMessage("partner_id", "The partners(code) field is required");
    status = false;
  } else {
    $("#partner_id").removeClass("is-invalid");
    $("#partner_id").closest("div").find(".text-danger").addClass("d-none");
  } 
  if (io_date == "") {
    showErrorMessage("io_date", "The date field is required");
    status = false;
  } else {
    $("#io_date").removeClass("is-invalid");
    $("#io_date").closest("div").find(".text-danger").addClass("d-none");
  } 
  if (phn_no == "") {
    showErrorMessage("phn_no", "The phone number field is required");
    status = false;
  } else {
    $("#phn_no").removeClass("is-invalid");
    $("#phn_no").closest("div").find(".text-danger").addClass("d-none");
  } 
  if ($("#d_address").val() == "") {
    $("#d_address").addClass("is-invalid");
    $("#d_address").closest(".form-group").find(".text-danger").removeClass("d-none").text("The delivery address field is required");
    status = false;
  } else {
    $("#d_address").removeClass("is-invalid");
    $("#d_address").closest(".form-group").find(".text-danger").addClass("d-none").text("");
  }

  let hasError = false;

  $("select[name='type[]']").each(function () {
    if (!validateSelect2Field($(this), "type")) {
      hasError = true;
    }
  });

  $("select[name='ins_category[]']").each(function () {
    if (!validateSelect2Field($(this), "category")) {
      hasError = true;
    }
  });

  $("select[name='ins_name[]']").each(function () {
    if (!validateSelect2Field($(this), "instrument name")) {
      hasError = true;
    }
  });

  $("input[name='line_item_no[]']").each(function () {
    let value = $(this).val();
    if (!value || value.trim() === "") {
      if (!$(this).next(".text-danger").length) {
        $(this).addClass("is-invalid");
        $(this).after(
          '<div class="text-danger">The line item number field is required</div>'
        );
      }
      hasError = true;
    } else {
      $(this).removeClass("is-invalid");
      $(this).next(".text-danger").remove();
    }
  });

  if (hasError) {
    status = false;
  }
  let rowCount = $(".rowCount").length;
  if (!Number(rowCount)) {
    status = false;
    $("#ciofrm .add_cio").html(
      '<tr><td colspan="6" class="text-danger errProduct">Please add minimum one row</td></tr>'
    );
  }

  if (status == true) {
    return true;
  } else {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  } 
});
$(document).on("change", ".type", function () {
  let current = $(this);
  let type = current.find(":selected").val();
  let hidden_base_url = $("#hidden_base_url").val();
  let row = current.closest("tr");
  $.ajax({
    type: "POST",
    url: hidden_base_url + "getInstrumentCategory",
    data: { id: type },
    success: function (data) {
      let select = row.find(".ins_category");
      select.html(data);
    },
    error: function () {},
  });
});
$(document).on("change", ".ins_category", function () {
  let current = $(this);
  let row = current.closest("tr");
  let type = row.find(".type").val();
  let ins_category = row.find(".ins_category").val();
  let hidden_base_url = $("#hidden_base_url").val();
  $.ajax({
    type: "POST",
    url: hidden_base_url + "getInstruments",
    data: {
      type: type,
      ins_category: ins_category,
    },
    success: function (data) {
      let select = row.find(".ins_name");
      select.html(data);
    },
    error: function () {},
  });
});

$(document).on("change", ".ins_name", function () {
  let hidden_alert = $("#hidden_alert").val();
  let hidden_cancel = $("#hidden_cancel").val();
  let hidden_ok = $("#hidden_ok").val();

  let current = $(this);
  let row = current.closest("tr");

  let selected_type = row.find(".type").val();
  let selected_category = row.find(".ins_category").val();
  let selected_instrument = row.find(".ins_name").val();

  let isDuplicate = false;

  $(".add_cio tr").each(function () {
    if (this !== row[0]) {
      let other_type = $(this).find(".type").val();
      let other_category = $(this).find(".ins_category").val();
      let other_instrument = $(this).find(".ins_name").val();

      if (
        selected_type &&
        selected_category &&
        selected_instrument &&
        selected_type === other_type &&
        selected_category === other_category &&
        selected_instrument === other_instrument
      ) {
        swal({
          title: hidden_alert + "!",
          text: "This Instrument already exists.",
          cancelButtonText: hidden_cancel,
          confirmButtonText: hidden_ok,
          confirmButtonColor: "#3c8dbc",
        });
        current.val("").trigger("change");
        isDuplicate = true;
        return false;
      }
    }
  });

  if (isDuplicate) return;
});


$(document).on("click", ".del_row", function (e) {
  $(this).parent().parent().remove();
});

/* IO date */
$(document).ready(function () {
  $("#io_date")
  .datepicker({
    format: "dd-mm-yyyy",
    autoclose: true,
    todayHighlight: true,
    startDate: new Date(),
  })
  .datepicker("update", new Date());  
  });

  $(document).on("click", ".open-calendar", function () {
    let id = $(this).data("id");
    console.log("Selected ID:", id);
    $("#calendarModal").find('input[name="customer_io_id"]').val(id);
  });


/* To Get Customer name from po number */
$(document).on("change", "#po_no", function (e) {
 let lineItemNo = $(this).find(":selected").data("lineitem");
 $("#line_item_no").val(lineItemNo);
  let po_no = $(this).find(":selected").val();
  let hidden_base_url = $("#hidden_base_url").val();

  $.ajax({
    type: "POST",
    url: hidden_base_url + "getCustomerName",
    data: { po_no: po_no },
    dataType: "json",
    success: function (data) {
      if (data) {
        $('#customer_id').val(data.id)
        $("#customer_name").val(data.name + " (" + data.customer_id + ")");
        $("#c_phn_no").val(data.phone);
        $("#c_email").val(data.email);
        $("#d_address").val(data.address);
      }
    },
    error: function () {},
  });
});
/* To Get partner  */
$(document).on("change", "#partner_id", function (e) {
   let partner_id = $(this).val(); 
  let hidden_base_url = $("#hidden_base_url").val();

  $.ajax({
    type: "POST",
    url: hidden_base_url + "getPartner",
    data: { partner_id: partner_id },
    dataType: "json",
    success: function (data) {
      if (data) {
        $("#phn_no").val(data.phone);
        $("#email").val(data.email);
        $("#d_address").val(data.d_address);
      }
    },
    error: function () {},
  });
});


