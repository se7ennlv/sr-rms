function getCurDate() {
    var $now = new Date();
    var $today = $now.format("isoDateTime");
    return $today;
}

$(function() {
    $('#toolbar').find('select').change(function() {
        $table.bootstrapTable('destroy').bootstrapTable({
            exportDataType: $(this).val(),
            exportOptions: {
                fileName: 'SRPhoneNumber_' + getCurDate()
            }
        });
    });
});

$table = $('#myTable').bootstrapTable({
    exportTypes: ['excel', 'csv'],
    exportOptions: {
        type: 'excel',
        fileName: 'SRPhoneNumber_' + getCurDate()
    }
});

function OptionFormatter(value, row, index) {
    return [
        '<a class="edit" href="javascript:void(0)" title="Edit" data-unique-id="', row.id, '">', '<i class="fa fa-pencil-square-o"></i>', '</a>  '
    ].join('');
}

window.OptionEvents = {
    'click .edit': function(e, value, row, index) {
        var rowId = row.ExtID;

        $.ajax({
            method: 'GET',
            url: 'controllers/json_get_data.php',
            data: {
                extId: rowId
            },
            dataType: 'JSON',
            success: function(data) {
                $('#md-edit').modal('show');
                $('#extNumber').text(data.ExtNumber);
                $('#ExtNumber').val(data.ExtNumber);
                $('select option[value="' + data.ExtDeptID + '"]').prop('selected', true);
                $('#ExtLocation').val(data.ExtLocation);
                $('#ExtUsername').val(data.ExtUsername);
                $('#ExtID').val(data.ExtID);
            }
        });
    }
};

$(function() {
    $('#frmEdit').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: 'controllers/update_ext.php',
            data: formData,
            success: function(data) {
                location.reload(true);
            }
        });
    });
});