$("#calibration_due")
    .datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
    })
.datepicker("update", new Date());

$(document).on("change", "#owner_type", function () {
  let owner_type = $(this).find(":selected").val();
  if (owner_type === "1") {
      $("#cust_div").addClass("d-none");
      $("#customer_id").val("");
    } else {
      $("#cust_div").removeClass("d-none");
      $("#customer_id").val("").change();
  }
  // $(".select2").select2();
  // $("#owner_type").val("").trigger("change.select2");
});

$(document).on("change", "#instrument_type", function () {
  let instrument_type_id = $(this).val();
  let hidden_base_url = $("#hidden_base_url").val();

  $.ajax({
    type: "POST",
    url: hidden_base_url + "getInstrumentCategory",
    data: {
      id: instrument_type_id,
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (data) {
      let select = $("#category");
      select.empty().append(data); 
      select.val("").change();
      $(".select2").select2();
    },
    error: function () {
      console.error("Failed to fetch categories.");
    },
  });
});

