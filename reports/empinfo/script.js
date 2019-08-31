$('.datepicker').datepicker({
    todayHighlight: true,
    format: 'yyyy-m-d',
    autoclose: 'true'
});

var $deptName = $("#deptName").text().trim();


function SuccessAction() {
  
    if ($deptName != "") {
        if ($('#frmAttd').smkValidate()) {
            $.post("./pages/org_hremp.php", $("#frmAttd").serialize()
                , function (response) {                        
                    $("#tblRespone").html(response);
                });
        }
    } else {
        alert("Please input department name into your account info!");
    }

    return false;
}

$('#btnRemoveDupData').on("click", function (e) {
    if ($('#frmAttd').smkValidate()) {
        $.post("./pages/remove_dups.php", $("#frmAttd").serialize()
            , function (response) {
                $("#tblRespone").html(response);
            });
    }
    e.preventDefault();
});

$('#btnActiveStaff').on("click", function (e) {
    $.post("./pages/active_staff.php", $("#frmAttd").serialize()
        , function (response) {
            $("#tblRespone").html(response);
        });

    e.preventDefault();
});

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