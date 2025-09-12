let i = 0;
$(document).on("click", "#customer_io", function (e) {
  ++i;
  let firstInterState =
    $(".add_cio").append(
      "<tr>" +
        '<td class="ir_txt_center"><p class="set_sn rowCount">' +
        i +
        "</p></td>" +
        '<td><select class="form-control type select2" name="type[]" id="type_' +
        i +
        '"><option value="">Please Select</option>\n' +
        '<option value="Gauges/Checking Instruments">Gauges/Checking Instruments</option>\n' +
        '<option value="Measuring Instruments">Measuring Instruments</option>\n' +
        "</select></td>" +
        '<td><select class="form-control type select2" name="category[]" id="category_' +
        i +
        '"><option value="">Please Select</option>\n' +
        '<option value="Plug Gauge">Plug Gauge</option>\n' +
        '<option value="Vernier Caliper">Vernier Caliper</option>\n' +
        "</select></td>" +
        '<td><select class="form-control type select2" name="instrument_name[]" id="instrument_name_' +
        i +
        '"><option value="">Please Select</option>\n' +
        '<option value="Material 123">Material(100)</option>\n' +
        '<option value="Bore Gauges 123">Bore Gauges(101)</option>\n' +
        "</select></td>" +
        '<td><input type="number" name="qty[]" class="check_required form-control integerchk qty_c" placeholder="Quantity" id="quantity_' +
        i +
        '"></td>' +
        '<td><textarea class="form-control" name="remarks[]" placeholder="Remarks" id="remarks"></textarea></td>' +
        '<td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
        "</tr>"
    );
    $(".add_cio").find("select.select2").select2({
      width: "100%",
    });
});

let j = 0;

$(document).on("click", "#partner", function (e) {
  ++j;
  $(".add_partner").append(
    "<tr>" +
      '<td class="ir_txt_center"><p class="set_sn rowCount">' +
      j +
      "</p></td>" +
      '<td><select class="form-control type select2" name="type[]" id="type_' +
      j +
      '"><option value="">Please Select</option>\n' +
      '<option value="Gauges/Checking Instruments">Gauges/Checking Instruments</option>\n' +
      '<option value="Measuring Instruments">Measuring Instruments</option>\n' +
      "</select></td>" +
      '<td><select class="form-control type select2" name="category[]" id="category_' +
      j +
      '"><option value="">Please Select</option>\n' +
      '<option value="Plug Gauge">Plug Gauge</option>\n' +
      '<option value="Vernier Caliper">Vernier Caliper</option>\n' +
      "</select></td>" +
      '<td><select class="form-control type select2" name="instrument_name[]" id="instrument_name_' +
      j +
      '"><option value="">Please Select</option>\n' +
      '<option value="Material 123">Material(100)</option>\n' +
      '<option value="Bore Gauges 123">Bore Gauges(101)</option>\n' +
      "</select></td>" +
      '<td><input type="number" name="qty[]" class="check_required form-control integerchk qty_c" placeholder="Quantity" id="quantity_' +
      j +
      '"></td>' +
      '<td><textarea class="form-control" name="remarks[]" placeholder="Remarks" id="remarks_' +
      j +
      '"></textarea></td>' +
      '<td><input type="text" name="line_item_no[]" class="form-control" placeholder="PO Line Item No" /></td>' +
      '<td class="ir_txt_center"><a class="btn btn-xs del_row remove-tr dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>' +
      "</tr>"
  );
  $(".add_partner").find("select.select2").select2({ width: "100%" });
});


$(document).on("click", ".del_row", function (e) {
  $(this).parent().parent().remove();
});
