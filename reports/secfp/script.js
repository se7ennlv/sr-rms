/*=====================================================================*/
$('.datepicker').datepicker({
    todayHighlight: true,
    format: 'yyyy-m-d',
    autoclose: 'true'
});

/*============================================================================*/

$('#btnRawReport').on("click", function(e) {
    if ($('#formFingerScan').smkValidate()) {
        $.post("./pages/raw.php", $("#formFingerScan").serialize(), function(response) {
            $("#tableRespone").html(response);
        });
    }
    e.preventDefault();
});

$('#btnTransactionReport').on("click", function(e) {
    if ($('#formFingerScan').smkValidate()) {
        $.post("./pages/transaction.php", $("#formFingerScan").serialize(), function(response) {
            $("#tableRespone").html(response);
        });
    }
    e.preventDefault();
});

$('#btnSumaryReport').on("click", function(e) {
    if ($('#formFingerScan').smkValidate()) {
        $.post("./pages/summary.php", $("#formFingerScan").serialize(), function(response) {
            $("#tableRespone").html(response);
        });
    }
    e.preventDefault();
});
/*=====================================================================*/
$(document).ajaxStart(function() {
    $.blockUI({
        message: '\n\
                    <span style="font-size: 16px">Please await...</span>\n\
                    <div class="progress" style="border-radius: 0px; margin-top: 5px;">\n\
                        <div class="progress-bar progress-bar-striped active" \n\
                            role="progressbar"\n\
                            style="width:100%;">\n\
                        </div>\n\
                    </div>'
    });
}).ajaxStop($.unblockUI);