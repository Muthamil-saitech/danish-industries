$(function () {
    "use strict";
    $(document).on("click", "#qc_add", function (e) {
        e.preventDefault();
        $('#qc_user_id').val("").trigger('change.select2');
        $("#qc_start_date").val("");
        $("#qc_complete_date").val("");
        $("#qc_note").val("");
        $(".qc_user_error").html("");
        $(".start_date_error").html("");
        $(".end_date_error").html("");
    });
    function parseDMYtoDate(dmy) {
        const [day, month, year] = dmy.split('-');
        return new Date(`${year}-${month}-${day}`); // Valid ISO format for JS
    }
    let hidden_base_url = $("#hidden_base_url").val();
    let source = [];
    chart(source);
    let edit_mode = $("#edit_mode").val();    
    //Ajax Call
    if (edit_mode != null) {
        let id = $("#edit_mode").val();
        $.ajax({
            url: hidden_base_url + "production/getProductionScheduling",
            type: "POST",
            data: { id: id },
            success: function (data) {
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    let res = {
                        name: data[i].production_stage_name,
                        desc: data[i].task,
                        values: [
                            {
                                from: data[i].start_date,
                                to: data[i].end_date,
                                label: data[i].task,
                                customClass: "ganttRed",
                            },
                        ],
                    };
                    source.push(res);
                }
                chart(source);
            },
        });
    }

    /**
     * Product Scheduling Button Click
     */
    $(document).on("click", ".product_scheduling_button", function () {
        let maxRow = 0;
        $(".add_production_scheduling tr").each(function () {
            const row = parseInt($(this).attr("data-row"));
            if (!isNaN(row) && row > maxRow) {
                maxRow = row;
            }
        });

        let j = maxRow + 1;
        console.log("j",j);
        
        let task = $("#task").val();
        let task_note = $("#task_note").val();
        let task_hours = $("#task_hours").val();
        let start_date = $("#ps_start_date").val();        
        let end_date = $("#ps_complete_date").val();
        let params = $("#productionstage_id").find(":selected").val();
        let user = $("#user_id").find(":selected").val();
        let separate_params = params.split("|");
        console.log("task_hours",task_hours);        
        let productionstage_id = $("#productionstage_id").html();
        let user_id = $("#user_id").html();
        let task_status = $("#task_status_select").html();
        let isValid = true;
        if (params == "") {
            $("#productionstage_id").focus();
            $("#productionstage_id").css("border-color", "red");
            $(".stage_error")
                .text("Production Stage is required")
                .fadeOut(5000);
            isValid = false;
        }

        if (user == "") {
            $("#user_id").focus();
            $("#user_id").css("border-color", "red");
            $(".user_error")
                .text("Assign to is required")
                .fadeOut(5000);
            isValid = false;
        }

        if (task == "") {
            $("#task").focus();
            $("#task").css("border-color", "red");
            $(".task_error").text("Task is required").fadeOut(5000);
            isValid = false;
        }

        if (task_hours == "") {
            $("#task_hours").focus();
            $("#task_hours").css("border-color", "red");
            $(".task_hrs_error").text("Task Hours is required").fadeOut(5000);
            isValid = false;
        }

        if (start_date == "") {
            // $("#ps_start_date").focus();
            $("#ps_start_date").css("border-color", "red");
            $(".start_date_error").text("Start Date is required").fadeOut(5000);
            isValid = false;
        }

        if (end_date == "") {
            // $("#ps_complete_date").focus();
            $("#ps_complete_date").css("border-color", "red");
            $(".end_date_error").text("End Date is required").fadeOut(5000);
            isValid = false;
        }

        // check if end date is past of start date
        if (parseDMYtoDate(start_date) > parseDMYtoDate(end_date)) {
            // $("#ps_complete_date").focus();
            $("#ps_complete_date").css("border-color", "red");
            $(".end_date_error").text("Complete Date should be greater than Start Date").fadeOut(5000);
            isValid = false;
        }

        if(!isValid) {
            return false;
        }

        //table row count
        let table = `<tr class="rowCount3" data-row="${j}">
                        <td><span class="handle me-2"><iconify-icon icon="radix-icons:move"></iconify-icon></span></td><td class="text-start set_sn4">${j}</td>
                        <td>
                            <select class="form-control" id="manufacture_stage_display_${j}" disabled>
                                <option selected>${separate_params[1]}</option>
                            </select>
                            <input type="hidden" name="productionstage_id_scheduling[]" 
                                class="form-control changeableInput manufacture_stage_id" 
                                id="manufacture_stage_id_${j}" 
                                value="${separate_params[0]}">
                        </td>
                        <td>
                            <input type="text" class="form-control changeableInput" name="task[]" value="${task}">
                        </td>
                        <td>
                            <select class="form-control changeableInput manufacture_user_id" id="manufacture_user_id_${j}" name="user_id_scheduling[]">
                                ${user_id}
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="task_hours[]" id="task_hours_${j}" value="${task_hours}">
                        </td>
                        <td>
                            <input type="hidden" name="task_status[]" class="add_task_status">
                            <select class="form-control add_more_task_status changeableInput" id="task_status_${j}">
                                ${task_status}
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control changeableInput pstart_date" name="start_date[]" id="pstart_date" value="${start_date}">
                        </td>
                        <td>
                            <input type="hidden" name="task_note[]" value="${task_note}">
                            <input type="text" class="form-control changeableInput pcomplete_date" name="complete_date[]" id="pcomplete_date" value="${end_date}">
                            <p class="text-danger end_date_error d-none"></p>
                        </td>
                        <td class="text-end">
                            <a class="btn btn-xs del_row dlt_button"><iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon></a>
                        </td>
                    </tr>`;
        //hidden form with stage_id, task, date with hidden and array
        table += `<input type="hidden" name="schedulingstage_id[]" value="${separate_params[0]}">
                    <input type="hidden" name="schedulingtask[]" value="${task}">
                    <input type="hidden" name="schedulingemp[]" value="${user}">
                    <input type="hidden" name="schedulinghrs[]" value="${task_hours}">
                    <input type="hidden" name="schedulingdate[]" value="${start_date}"> 
                    <input type="hidden" name="schedulingenddate[]" value="${end_date}">`;

        

        $(".add_production_scheduling").append(table);
        $("#productionstage_id").val("").trigger("change");
        $("#user_id").val("").trigger("change");
        $("#task_note").val("");
        $("#task").val("");
        $("#task_hours").val("");
        $("#ps_start_date").val("");
        $("#ps_complete_date").val("");
        let result = {
            name: separate_params[1],
            desc: task,
            values: [
                {
                    from: start_date,
                    to: end_date,
                    label: task,
                    customClass: "ganttRed",
                },
            ],
        };
        source.push(result);
        chart(source);
        $("#productScheduling").modal("hide");                
        $("#manufacture_stage_id_"+j+"")
            .val(`${separate_params[0]}|${separate_params[1]}`)
            .trigger("change");
        $("#manufacture_user_id_"+j+"")
            .val(`${user}`)
            .trigger("change");
        $(".pstart_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
        $(".pcomplete_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
    });

    /* Qc Scheduling button click */
    $(document).on("click", "#qc_add", function (e) {
        let manufacture_id =  $(this).data('manufacture_id');
        let scheduling_id =  $(this).data('scheduling_id');
        let production_stage_id =  $(this).data('production_stage_id');
        $("#manufacture_id").val(manufacture_id);
        $("#scheduling_id").val(scheduling_id);
        $("#production_stage_id").val(production_stage_id);
        $.ajax({
            type: "POST",
            url: $("#hidden_base_url").val() + "getQCEndDate",
            data: { manufacture_id: $("#manufacture_id").val(), scheduling_id: $("#scheduling_id").val() },
            dataType: "json",
            success: function (data) {                
                const parsedDate = parseDMYtoDate(data);
                $('#qc_start_date').datepicker('setStartDate', parsedDate);
            },
            error: function () {
            }
        });
    });
    function parseDMYtoDate(dateStr) {
        const parts = dateStr.split('-');
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }

    $('.qc_scheduling_btn').on('click', function (e) {
        e.preventDefault();
        $('.qc_user_error, .start_date_error, .end_date_error').text('');
        let qcUserId = $('#qc_user_id').val().trim();
        // let qcStatus = $('#qc_status').val().trim();
        let startDate = $('#qc_start_date').val().trim();
        let completeDate = $('#qc_complete_date').val().trim();
        let manufactureId = $('#manufacture_id').val().trim();
        let schedulingId = $('#scheduling_id').val().trim();
        let qc_note = $('#qc_note').val().trim();
        let productionStageId = $('#production_stage_id').val().trim();
        let isValid = true;
        if (!qcUserId) {
            $('.qc_user_error').text('Assign To is Required.');
            isValid = false;
        }
        // if (!qcStatus) {
        //     $('.qc_status_error').text('QC status is Required.');
        //     isValid = false;
        // }
        if (!startDate) {
            $('.start_date_error').text('Start date is Required.');
            isValid = false;
        }
        if (!completeDate) {
            $('.end_date_error').text('Complete date is Required.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        let hidden_base_url = $("#hidden_base_url").val();
        $.ajax({
            type: "POST",
            url: hidden_base_url + "updateQcScheduling",
            data: { "csrf-token": $("[name='csrf-token']").attr("content"), qc_user_id: qcUserId, start_date: startDate, complete_date: completeDate, manufacture_id: manufactureId, scheduling_id: schedulingId, production_stage_id: productionStageId, qc_note: qc_note },
            dataType: "json",
            success: function (response) {
                // $('#qc_response_msg').remove();
                $("#qcScheduling").modal("hide"); 
                $("#qc_msg").after('<p id="qc_response_msg" class="text-success mt-2">QC added successfully.</p>');
                // $("#move_next_task_wrapper").prop("disabled",false);
                // $('#move_next_task_wrapper').fadeIn();
                setTimeout(function () {
                    $('#qc_response_msg').fadeOut('slow', function () {
                        $(this).remove();
                    });
                }, 3000);
            },
            error: function () {},
        });
    });

    //delete row
    $(document).on("click", ".del_row", function () {
        let row = $(this).closest("tr");
        let index = row.index();
        source.splice(index, 1);
        row.remove();
        chart(source);
    });

    $(document).on("change", ".task_status", function (e) {
        let task_status =  $(this).val();
        // console.log("task_status",task_status);
        $(".edit_post_status").val(task_status);
    });

    $(document).on("change", ".add_more_task_status", function (e) {
        let add_more_task_status =  $(this).val();
        // console.log("task_status",task_status);
        $(".add_task_status").val(add_more_task_status);
    });

    //chnage input value in every row
    $(document).on("change", ".changeableInput", function () {
        let user = $(this).closest("tr").find(".manufacture_user_id").val();
        let params = $(this).closest("tr").find(".manufacture_stage_id").val();
        let separate_params = params.split("|");        
        let currentRow = $(this).closest("tr");

        let task = currentRow.find("input[name='task[]']").val();
        let start_date = currentRow.find("input[name='start_date[]']").val();
        let end_date = currentRow.find("input[name='complete_date[]']").val();

        //date validation
        if (parseDMYtoDate(start_date) > parseDMYtoDate(end_date)) {
            currentRow.find("input[name='complete_date[]']").focus();
            currentRow.find("input[name='complete_date[]']").css("border-color", "red");
            $(".end_date_error").removeClass("d-none");
            $(".end_date_error").text("Complete Date should be greater than Start Date").fadeOut(5000);
            $(".submit_btn").attr("disabled", true);
            return false;
        }else{
            currentRow
                .find("input[name='complete_date[]']")
                .css("border-color", "none");
            $(".end_date_error").addClass("d-none");
            $(".submit_btn").attr("disabled", false);
        }

        let index = Number(currentRow.attr("data-row")) - 1;
        console.log(index);
        source[index].name = separate_params[1];
        source[index].desc = task;
        source[index].values[0].from = start_date;
        source[index].values[0].to = end_date; 
        chart(source);
    });



    
    /**
     * @description This function is used to draw the chart
     * @param {*} source
     */
    function chart(source) {
        $(".gantt").gantt({
            source: source,
            navigate: "scroll",
            scale: "days",
            maxScale: "months",
            minScale: "hours",
            itemsPerPage: 10,
            scrollToToday: true,
            useCookie: true,
            onItemClick: function (data) {},
            onAddClick: function (dt, rowId) {},
            onRender: function () {
                if (window.console && typeof console.log === "function") {
                    console.log("chart rendered");
                }
            },
        });

        $(".gantt").popover({
            selector: ".bar",
            title: function _getItemText() {
                return this.textContent;
            },
            container: ".gantt",
            content: "",
            trigger: "hover",
            placement: "auto right",
        });
    }
});
