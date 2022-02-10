/*=====================================================================*/
$('.datepicker').datepicker({
    todayHighlight: true,
    format: 'yyyy-mm-dd',
    autoclose: 'true'
});



/*============================================================================*/
$('#btnRawReport').on("click", function (e) {
    if ($('#formFingerScan').smkValidate()) {
        $.post("./pages/raw_data.php", $("#formFingerScan").serialize(), function (response) {
            $("#tableRespone").html(response);
        });
    }
    e.preventDefault();
});

$('#btnCountByPeriodReport').on("click", function (e) {
    if ($('#formFingerScan').smkValidate()) {
        $.post("./pages/count_by_period.php", $("#formFingerScan").serialize(), function (response) {
            $("#tableRespone").html(response);
        });
    }
    e.preventDefault();
});

$('#btnSumaryReport').on("click", function (e) {
    if ($('#formFingerScan').smkValidate()) {
        $.post("./pages/dept_sum_by_period.php", $("#formFingerScan").serialize(), function (response) {
            $("#tableRespone").html(response);
        });
    }
    e.preventDefault();
});


function summaryByPerson() {
    if ($('#formFingerScan').smkValidate()) {
        var formDatas = $($('#formFingerScan')).serialize();

        $.post("./pages/over_summary.php", formDatas, function (response) {
            $("#tableRespone").html(response);
        });
    }

    return false;
}


/*=====================================================================*/
$(document).ajaxStart(function () {
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
