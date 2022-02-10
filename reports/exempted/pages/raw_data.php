<?php
session_start();

try {
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<h4><strong>Norming Extension</strong></h4>
<hr>
<table id="myTable" data-toggle="table" data-url="controllers/json_raw_data_nor.php?" data-page-size="All"
    data-page-list="[10, 25, 50, 100, ALL]" data-pagination="true" data-search="true" data-height="650"
    data-toolbar="#toolbar" data-show-export="true" data-show-refresh="true" data-show-columns="true">
    <thead>
        <tr>
            <!-- <th data-field="state" data-checkbox="true"></th> -->
            <th data-field="ExemID" data-sortable="true" class="text-nowrap text-center">EMP ID</th>
            <th data-field="HREMP_NAME" data-sortable="true" class="text-nowrap">EMP Name</th>
            <th data-field="HRJOB_JOBNAME" data-sortable="true">Position</th>
            <th data-field="ASORG_ORGNAME" data-sortable="true">DEPT</th>
            <th data-field="ExemTiker" data-sortable="true">Tier</th>
            <th data-field="ExemID1" data-align="center" id="exid" data-events="operateEvents" data-formatter="operateFormatter" class="nr">Options</th>

        </tr>
    </thead>
<script type="text/javascript">
function getCurDate() {
    var now = new Date();
    var today = now.format("isoDateTime");
    return 'EXamtReport_' + today;
}

var $table = $('#myTable');

$(function() {
    $('#toolbar').find('select').change(function() {
        $table.bootstrapTable('destroy').bootstrapTable({
            exportDataType: $(this).val(),
            exportTypes: ['excel'],
            exportOptions: {
                fileName: getCurDate()
            }
        });
    });
});

$table = $('#myTable').bootstrapTable({
    showExport: true,
    exportTypes: ['excel'],
    exportOptions: {
        fileName: getCurDate()
    }
});

function operateFormatter(value, row, index) {
//console.log(row);

    return [
    // '<a class="edit" href="javascript:void(0)" title="Update" data-unique-id="', row.id, '">', '<i class="fa fa-edit"></i>', '</a>  ',
     '<a class="btn btn-default btn-xs edit" href="javascript:void(0)" title="Update" data-unique-id"', row.id, '" onclick="UpdateEX(' + row.ExemID +')">', '<i class="fa fa-edit"></i>', '</a>  ',
    //  '<a class="delete" href="javascript:void(0)" title="Delete" data-unique-id="', row.id, '" onclick="DeleteEX(' + row.ExemID + ')">', '<i class="fa fa-minus-circle"></i>', '</a>  '
     '<a class="btn btn-default btn-xs deletedata"  title="Delete" data-unique-id="', row.id, '" data-toggle="modal" data-target="#modalMessage">', '<i class="fa fa-times"></i>', '</a>  '
    ].join('');

}
</script>