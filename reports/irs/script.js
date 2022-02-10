$('.datepicker').datepicker({
    todayHighlight: true,
    format: 'yyyy-m-d',
    autoclose: 'true'
});

var $deptName = $('#deptName').text().trim();

function RawAction() {
    if ($deptName != '') {
        if ($('#frmIrs').smkValidate()) {
            $.ajax({
                url: './pages/irs.php',
                data: $('#frmIrs').serialize(),
                type: 'POST',
                success: function(data) {
                    $('#tblRespone').html(data);
                }
            });
        }
    } else {
        alert('Please input department name into your account info!');
    }

    return false;
}

$(document)
    .ajaxStart(function() {
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
    })
    .ajaxStop($.unblockUI);