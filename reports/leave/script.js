/*=====================================================================*/
$(".datepicker").datepicker({
    todayHighlight: true,
    format: "yyyy-mm-dd",
    autoclose: "true"
});

/*============================================================================*/
$("#FrmEmpId").on("submit", function (e) {
    if ($("#FrmEmpId").smkValidate()) {
        $(".modal").modal("hide");

        $.post("./pages/by_emp_id.php", $("#FrmEmpId").serialize()
                , function (response) {
                    $("#tblRespone").html(response);
                });
    }

    e.preventDefault();
});


$("#FrmDept").on("submit", function (e) {
    if ($("#FrmDept").smkValidate()) {
        $(".modal").modal("hide");

        $.post("./pages/by_dept.php", $("#FrmDept").serialize()
                , function (response) {
                    $("#tblRespone").html(response);
                });
    }

    e.preventDefault();
});

$("#FrmSpl").on("submit", function (e) {
    if ($("#FrmSpl").smkValidate()) {
        $(".modal").modal("hide");

        $.post("./pages/sql_lv_account_update.php", $("#FrmSpl").serialize()
                , function (response) {
                    $("#tblRespone").html(response);
                });
    }

    e.preventDefault();
});

$("#FrmSearchLeave").on("submit", function (e) {

    if ($("#FrmSearchLeave").smkValidate()) {
        $(".modal").modal("hide");

        $.post("./pages/search_roster.php", $("#FrmSearchLeave").serialize(),
                function (response) {
                    $("#tblRespone").html(response);
                });
    }

    e.preventDefault();
});


/*=====================================================================*/
$(document).ajaxStart(function () {
    $.blockUI({message: '\n\
                    <span style="font-size: 16px">Please wait calculating...</span>\n\
                    <div class="progress" style="border-radius: 0px; margin-top: 5px;">\n\
                        <div class="progress-bar progress-bar-striped active" \n\
                            role="progressbar"\n\
                            style="width:100%;">\n\
                        </div>\n\
                    </div>'
    });
}).ajaxStop($.unblockUI);

/*=====================================================================*/
$(".modal").on("show.bs.modal", function () {
    $(".form-group").removeClass("has-error");
    $(".form-group").removeClass("has-feedback");
});

$(".modal").on("hidden.bs.modal", function () {
    $(this).find("form").trigger("reset");
    $(".form-group").removeClass("has-error");
    $(".form-group").removeClass("has-feedback");
});