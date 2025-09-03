$(document).ready(function () {
    "use strict";
    let hidden_currency = $("#hidden_currency").val();
    let target = $(".sort_menu");
    target.sortable({
        handle: ".handle",
        placeholder: "highlight",
        axis: "y",
        update: function (e, ui) {
            reorderSerial();
        },
    });

    //reorder production stage serial number
    function reorderSerial() {
        let i = 1;
        $(".set_sn2").each(function () {
            $(this).html(i);
            i++;
        });
    }

    $("#supplierModal").on("hidden.bs.modal", function () {
        $(this).find("form").trigger("reset");
    });

    /**
     * Set Attribute
     */
    function setAttribute() {
        let i = 1;
        $(".set_sn").each(function () {
            $(this).html(i);
            i++;
        });
        i = 1;
        $(".set_sn1").each(function () {
            $(this).html(i);
            i++;
        });
        i = 1;
        $(".set_sn2").each(function () {
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
    }

    /**
     * Calculate Percentage
     * @param {*} total_amount 
     * @param {*} percentage 
     * @returns 
     */
    function calPercentage(total_amount, percentage) {
        let plan_amount = (total_amount * percentage) / 100;
        return plan_amount;
    }

    function cal_row() {
        let i = 1;
        let row_total = 0;
        let row_total_total = 0;
        let noniitem = 0;
        let total_percentage = 0;
        let profit_total = 0;

        let tax_type = $('#ftax_type').val();

        // Calculate row totals (unit_price * qty)
        $(".unit_price_c").each(function () {
            let unit_price = Number($("#unit_price_" + i).val());
            let qty = Number($("#qty_" + i).val());
            row_total = unit_price * qty;
            row_total_total += row_total;
            $("#total_" + i).val(row_total.toFixed(2));
            i++;
        });

        // Calculate total tax percentage from visible tax inputs
        // Only consider visible .get_percentage inputs inside the currently visible tax div
        if (tax_type === "Labor") {
            total_percentage = 0;
            $("#labor_div .get_percentage:visible").each(function () {
                let tmp_value = Number($(this).val());
                total_percentage += tmp_value;
            });
        } else if (tax_type === "Sales") {
            total_percentage = 0;
            $("#sale_div .get_percentage:visible").each(function () {
                let tmp_value = Number($(this).val());
                total_percentage += tmp_value;
            });
        }

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

        // Calculate GST amount on base price
        let gst_amount = (base_price * total_percentage) / 100;

        // Final sale price = base price + GST amount
        let final_sale_price = base_price;

        $("#sale_price").val(final_sale_price.toFixed(2));
    }

    $(document).on("change", "#rmaterial", function (e) {
        let params = $(this).find(":selected").val();
        let separate_params = params.split("|");
        let html =
            '<tr class="rowCount" data-id="' +
            separate_params[0] +
            '">\n' +
            '<td class="width_1_p"><p class="set_sn">1</p></td>\n' +
            "<td>" +
            '<input type="hidden" value="' +
            separate_params[0] +
            '" name="rm_id[]"> ' +
            "<span>" +
            separate_params[1] + "(" +separate_params[2] + ")" +
            "</span></td>\n" +            
            '<td class="text-end"><a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>\n' +
            "</tr>";
            
        let check_exist = true;
        $(".rowCount").each(function () {
            let id = $(this).attr("data-id");
            if (Number(id) == Number(separate_params[0])) {
                check_exist = false;
            }
        });

        if (check_exist == true) {
            if (separate_params[0]) {
                $(".rawmaterialsec tbody").find(".errorMsg").remove();
                $(".add_tr").append(html);
                setAttribute();
                // cal_row();
                $("#rmaterial").val("").change();
                return false;
            }
        } else {
            let hidden_alert = $("#hidden_alert").val();
            let hidden_cancel = $("#hidden_cancel").val();
            let hidden_ok = $("#hidden_ok").val();
            swal({
                title: hidden_alert + "!",
                text: "This Material already added",
                cancelButtonText: hidden_cancel,
                confirmButtonText: hidden_ok,
                confirmButtonColor: "#3c8dbc",
            });
            $("#rmaterial").val("").change();
            return false;
        }
    });
    $(document).on("change", "#productionstage", function (e) {
        let params = $(this).find(":selected").val();
        let separate_params = params.split("|");
        let html =
            '<tr class="rowCount2 align-middle ui-state-default" data-id="' +
            separate_params[0] +
            '">\n' +
            '<td><span class="handle me-2"><iconify-icon icon="radix-icons:move"></iconify-icon></span></td><td class="width_1_p"><p class="set_sn2 m-0">1</p></td>\n' +
            '<td class="stage_name" style="text-align: left;"><input type="hidden" value="' +
            separate_params[0] +
            '" name="producstage_id[]"><span>' +
            separate_params[1] +
            "</span></td>\n" +
            "<td>" +
            '<div class="row">' +
            /* '<div class="col-md-3"><div class="input-group"><input class="form-control stage_aligning" type="text" id="month_limit" name="stage_month[]" min="0" max="12" onfocus="select();" placeholder="Months"><span class="input-group-text">Months</span></div></div>' +
            '<div class="col-md-3"><div class="input-group"><input class="form-control stage_aligning" type="text" id="day_limit" name="stage_day[]" min="0" max="29" onfocus="select();" placeholder="Days"><span class="input-group-text">Days</span></div></div>' + */
            '<div class="col-md-6"><div class="input-group"><input class="form-control stage_aligning" type="text" id="hours_limit" name="stage_hours[]" min="0" max="23" onfocus="select();" placeholder="Hours"><span class="input-group-text">Hours</span></div></div>' +
            '<div class="col-md-6"><div class="input-group"><input class="form-control stage_aligning" type="text" id="minute_limit" name="stage_minute[]" min="0" max="59" onfocus="select();" placeholder="Minutes"><span class="input-group-text">Minutes</span></div></div>' +
            "</div>" +
            "</td>" +
            '<td class="ir_txt_center"><a class="btn btn-xs del_row_prostage dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a></td>\n' +
            "</tr>";

        let check_exist = true;

        $(".rowCount2").each(function () {
            let id = $(this).attr("data-id");
            if (Number(id) == Number(separate_params[0])) {
                check_exist = false;
            }
        });

        if (check_exist == true) {
            if (separate_params[0]) {
                $(".add_tr2").append(html);
                setAttribute();
                cal_row();
                $("#productionstage").val("").change();
                return false;
            }
        } else {
            let hidden_alert = $("#hidden_alert").val();
            let hidden_cancel = $("#hidden_cancel").val();
            let hidden_ok = $("#hidden_ok").val();
            swal({
                title: hidden_alert + "!",
                text: "This Production Stage already added",
                cancelButtonText: hidden_cancel,
                confirmButtonText: hidden_ok,
                confirmButtonColor: "#3c8dbc",
            });
            $("#rmaterial").val("").change();
            return false;
        }
    });

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
            let month = $(this)
                .closest("tr")
                .find("#month_limit")
                .val();
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
            let day = $(this)
                .closest("tr")
                .find("#day_limit")
                .val();
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
            let hours = $(this)
                .closest("tr")
                .find("#hours_limit")
                .val();
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
            let month = $(this).closest("tr").find("#month_limit").val();
            let day = $(this).closest("tr").find("#day_limit").val();
            let hour = $(this).closest("tr").find("#hours_limit").val();
            let minute = $(this).closest("tr").find("#minute_limit").val();

            totalMonth += month == "" ? 0 : parseInt(month);
            totalDays += day == "" ? 0 : parseInt(day);
            totalHours += hour == "" ? 0 : parseInt(hour);
            totalMinutes += minute == "" ? 0 : parseInt(minute);
        });

        $("#t_month").val(totalMonth);
        $("#t_day").val(totalDays);
        $("#t_hours").val(totalHours);
        $("#t_minute").val(totalMinutes);

        // Call recalculateTotals after setting the initial values
        recalculateTotals();
    }
    function recalculateTotals() {
        let totalMonths = parseInt($("#t_month").val()) || 0;
        let totalDays = parseInt($("#t_day").val()) || 0;
        let totalHours = parseInt($("#t_hours").val()) || 0;
        let totalMinutes = parseInt($("#t_minute").val()) || 0;

        // Convert excess days to months
        if (totalDays >= 30) {
            totalMonths += Math.floor(totalDays / 30);
            totalDays = totalDays % 30;
        }

        // Convert excess hours to days
        if (totalHours >= 24) {
            totalDays += Math.floor(totalHours / 24);
            totalHours = totalHours % 24;
        }

        // Convert excess minutes to hours
        if (totalMinutes >= 60) {
            totalHours += Math.floor(totalMinutes / 60);
            totalMinutes = totalMinutes % 60;
        }

        // Recalculate days and months if hours or days changed
        if (totalHours >= 24) {
            totalDays += Math.floor(totalHours / 24);
            totalHours = totalHours % 24;
        }
        if (totalDays >= 30) {
            totalMonths += Math.floor(totalDays / 30);
            totalDays = totalDays % 30;
        }

        // Update the fields with new values
        $("#t_month").val(totalMonths);
        $("#t_day").val(totalDays);
        $("#t_hours").val(totalHours);
        $("#t_minute").val(totalMinutes);
    }

    // Attach the recalculation function to the change event of total fields
    $("#t_month, #t_day, #t_hours, #t_minute").on("change keyup", function() {
        recalculateTotals();
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
    });

    $(document).on("change", "#mat_cat_id", function () {
        let mat_cat_id = $(this).find(":selected").val();
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "getMaterialById",
            data: { id: mat_cat_id },
            dataType: "json",
            success: function (data) { 
                $(".add_tr").empty();
                $("#rmaterial").val("").change();
                let raw_materials = data;
                let select = $("#rmaterial");
                select.empty();
                select.append('<option value="">Please Select</option>');
                raw_materials.forEach(function (rm) {
                    if (rm) {
                        let id = rm.id;
                        let name = rm.name;
                        let code = rm.code;
                        select.append('<option value="' + id + '|'+ name +'|'+ code +'">' + name + ' ('+ code +')'+'</option>');
                    }
                });
                $(".select2").select2();
            },
            error: function () {
                console.error("Failed to fetch product details.");
            },
        });
    });

    $("#product_form").submit(function () {
        let status = true;
        let name = $("#name").val();
        let code = $("#code").val();
        let category = $("#category_id").val();
        let drawer_no = $("#drawer_no").val();
        // let hsn_sac_no = $('#hsn_sac_no').val();
        let description = $('#description').val();

        if(name == "") {
            status = false;
            showErrorMessage("name", "The Part Name field is required");
        }else{
            $("#name").removeClass("is-invalid");
            $("#name").closest("div").find(".text-danger").addClass("d-none");
        }

        if(code == "") {
            status = false;
            showErrorMessage("code", "The Part No field is required");
        }else{
            $("#code").removeClass("is-invalid");
            $("#code").closest("div").find(".text-danger").addClass("d-none");
        }

        /* if(hsn_sac_no == "") {
            status = false;
            showErrorMessage("hsn_sac_no", "The HSN / SAC No field is required");
        }else{
            $("#hsn_sac_no").removeClass("is-invalid");
            $("#hsn_sac_no").closest("div").find(".text-danger").addClass("d-none");
        } */

        if(category == "") {
            status = false;
            showErrorMessage("category_id", "The Category field is required");
        }else{
            $("#category_id").removeClass("is-invalid");
            $("#category_id").closest("div").find(".text-danger").addClass("d-none");
        }

        if(drawer_no == "") {
            status = false;
            showErrorMessage("drawer_no", "The Drawing No field is required");
        }else{
            $("#drawer_no").removeClass("is-invalid");
            $("#drawer_no").closest("div").find(".text-danger").addClass("d-none");
        }

        if(description == "") {
            status = false;
            showErrorMessage("description", "The Description field is required");
        }else{
            $("#description").removeClass("is-invalid");
            $("#description").closest("div").find(".text-danger").addClass("d-none");
        }       
        
        let rowCount = $(".rowCount").length;

        if (!Number(rowCount)) {
            status = false;
            $(".rawmaterialsec tbody").html(
                "<tr><td colspan='6' class='text-danger errorMsg'>Please add at least one Material</td></tr>"
            );
            //scroll to top
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }

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

    setAttribute();
    // cal_row();
});
