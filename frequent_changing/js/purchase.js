$(document).ready(function () {
    "use strict";
    let baseUrl = $("#hidden_base_url").val();
    $(document).on("click", ".print_invoice", function () {
        viewChallan($(this).attr("data-id"));
    });

    function viewChallan(id) {
        open(
            baseUrl + "print_purchase_invoice/" + id,
            "Print Quotation",
            "width=1600,height=550"
        );
        newWindow.focus();
        newWindow.onload = function () {
            newWindow.document.body.insertAdjacentHTML("afterbegin");
        };
    }
    $(document).on("change", ".purchase-status", function (e) {
        let $this = $(this);
        let status = $this.val();
        let purchase_id = $this.data("id");
        let $statusMsg = $this.closest('td').find('.purchase-status-msg');
        $.ajax({
            type: "POST",
            url: $("#hidden_base_url").val() + "updatePurchaseStatus",
            data: { purchase_id: purchase_id, status: status },
            dataType: "json",
            success: function (data) {
                $this.prop("disabled", true);
                $statusMsg.html('<span class="text-success">' + data.message + '</span>');
                setTimeout(() => {
                    $statusMsg.fadeOut(() => {
                        location.reload();
                    });
                }, 3000);
            },
            error: function () {
                $statusMsg.html('<span class="text-danger">Something went wrong.</span>')
                    .delay(2000)
                    .fadeOut();
            }
        });
    });
});
