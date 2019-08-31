$('.datepicker').datepicker({
    todayHighlight: true,
    format: 'yyyy-mm-dd',
    autoclose: 'true'
});

var dateInterval = function (date1, date2) {
    dt1 = new Date(date1);
    dt2 = new Date(date2);

    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24));
}

function Action1() {
    if ($("#frmPos").smkValidate()) {
        $.ajax({
            url: "./pages/itemized_sales_by_items.php",
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

function Action2() {
    if ($("#frmPos").smkValidate()) {
        $.ajax({
            url: "./pages/itemized_sale_by_meal_period.php",
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

function Action3() {
    var $posID = $("#posID").val();

    if ($("#frmPos").smkValidate()) {
        var $url = "";

        if ($posID == 1) {
            $url = "./pages/spa_detail_check_listing.php";
        } else if ($posID == 2) {
            $url = "./pages/retail_detail_check_listing.php";
        } else {
            $url = "./pages/daily_check_listing.php";
        }

        $.ajax({
            url: $url,
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

function Action4() {
    if ($("#frmPos").smkValidate()) {
        $.ajax({
            url: "./pages/kot_voided.php",
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

function Action5() {
    if ($("#frmPos").smkValidate()) {
        $.ajax({
            url: "./pages/house_check_oc.php",
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

function Action6() {
    if ($("#frmPos").smkValidate()) {
        $.ajax({
            url: "./pages/oc.php",
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

function Action7() {
    var $posID = $("#posID").val();

    if ($("#frmPos").smkValidate()) {
        var $url = "";

        if ($posID == 1) {
            $url = "./pages/spa_net_revenue.php";
        } else if ($posID == 2) {
            $url = "./pages/retail_net_revenue.php";
        } else {
            $url = "./pages/net_revenue_by_outlet.php";
        }

        $.ajax({
            url: $url,
            data: $("#frmPos").serialize(),
            type: "POST",
            success: function (data) {
                $("#tblRespone").html(data);
            }
        });
    }

    return;
}

$(document).ajaxStart(function () {
    $.blockUI({message: '\n\
                    <span style="font-size: 16px">Please wait, calculating...</span>\n\
                    <div class="progress" style="border-radius: 0px; margin-top: 5px;">\n\
                        <div class="progress-bar progress-bar-striped active" \n\
                            role="progressbar"\n\
                            style="width:100%;">\n\
                        </div>\n\
                    </div>'
    });
}).ajaxStop($.unblockUI);