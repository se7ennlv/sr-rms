$(function() {
    $('.datepicker').datepicker({
        todayHighlight: true,
        format: 'yyyy-m-d',
        autoclose: 'true'
    });
});

function GetRawData() {
    if ($('#frmexampted').smkValidate()) {
        $.ajax({
            method: 'POST',
            url: 'pages/raw_data.php',
            data: $('#frmexampted').serialize()
        }).done(function(data) {
            $('#dynamic-table').html(data);
        });
    }

    return false;
}

function GetRawData1() {
    if ($('#frmexampted').smkValidate()) {
        $.ajax({
            method: 'POST',
            url: 'pages/raw_data1.php',
            data: $('#frmexampted').serialize()
        }).done(function(data) {
            //  console.log(data);

            $('#dynamic-table1').html(data);
        });
    }

    return false;
}

$(document).ready(function() {
    var d = new Date();
    var strDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
    $('input[name=fromDate]').val(strDate);
    $('input[name=toDate]').val(strDate);
    GetRawData1();
    GetRawData();

});

var events;

function AddNewEX() {
    events = 'add';

    $('[name="ExemID"]').val('');
    $('[name="Exempted"]').val('');
    $('#ExemID').prop('disabled', false);
    $('#modalExp').modal('show');
    $('.modal-title').html('<i class="fa fa-plus-circle"></i> Add New Employee');
}

function UpdateEX(ExemID) {
    events = 'update';
    var ExemID = ExemID

    $.ajax({
        type: 'GET',
        url: 'controllers/json_get_data.php?/' + ExemID,
        data: {
            ExemID: ExemID,
            Exempted: 'D1'
        },
        dataType: 'JSON',
        success: function(data) {
            $('#modalExp').modal('show');
            $('.modal-title').html('<i class="fa fa-pencil"></i> Edit');
            $('[name="ExemID"]').val(ExemID);
            // $('[name="Exempted"]').val(Exempted);
            // console.log(Exempted);
        },

        error: function(jqXHR, textStatus, errorThrown) {
            $.smkAlert({
                text: 'Something went wrong, please contact developer',
                type: 'danger'
            });
        }
    });
    // // alert(ExemID);

}

function DeleteEX(ExemID) {
    var ExemID = $('#exemD').val();
    events = 'Del';
    url = 'controllers/delete_exempted.php';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            ExemID: ExemID
        },
        success: function(data) {
            $.smkAlert({
                type: data.status,
                text: data.message
            });
            GetRawData1();
            GetRawData();
            modalMessage
            $('#modalMessage').modal('hide');
            $('.modal-backdrop').remove();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.smkAlert({
                text: 'Something went wrong, please contact developer!',
                type: 'danger'
            });
        }
    });

    // //console.log($('#exemD').val());

}

function addUserExt() {
    if (events === 'add') {
        url = 'controllers/insert_exempted.php';
    } else {
        url = 'controllers/update_exempted.php';
    }

    if ($('#formExempted').smkValidate()) {
        var formData = $('#formExempted').serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function(data) {
                $.smkAlert({
                    type: data.status,
                    text: data.message
                });

                $('#modalExp').modal('hide');
                $('.modal-backdrop').remove();
                GetRawData1();
                GetRawData();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.smkAlert({
                    text: 'Something went wrong, please contact developer!',
                    type: 'danger'
                });
            }
        });
    }
}