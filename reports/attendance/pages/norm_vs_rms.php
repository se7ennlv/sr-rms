<?php
session_start();

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
?>

<div id="toolbar">
    <select class="form-control">
        <option value="all">Export All</option>
        <option value="">Export Only Page</option>       
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_norm_vs_rms.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>"
       data-pagination="true"
       data-page-size="All"
       data-click-to-select="true"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-search="true"
       data-height="650"
       data-toolbar="#toolbar"
       data-show-export="true"
       data-show-refresh="true"
       data-show-columns="true">
    <thead>
        <tr>
            <th colspan="8" data-align="left"><strong>Savan Legend Resorts sole  Company Limited.</strong></th>
        </tr>
        <tr>
            <th colspan="8" data-align="left"><strong>[Norming VS RMS Exception] Period [<strong><?= $fromDate; ?> - <?= $toDate; ?></strong>]</strong></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th class="text-center">Norming Data</th>
            <th colspan="3" class="text-center">RMS Data</th>
        </tr>
        <tr>
            <th data-field="EmpID" data-sortable="true" class="text-nowrap">Emp ID</th>
            <th data-field="EmpName" data-sortable="true" class="text-nowrap">Emp Name</th>
            <th data-field="Dept" data-sortable="true" class="text-nowrap">Department</th>
            <th data-field="Currency" data-sortable="true" class="text-nowrap text-center">Currency</th>
            <th data-field="NormTotalMin" data-sortable="true" class="text-nowrap text-center">Total (Min)</th>
            <th data-field="RmsTotalMin" data-sortable="true" class="text-nowrap text-center">Total (Min)</th>
            <th data-field="LateMin" data-sortable="true" class="text-nowrap text-center">Late (Min)</th>
            <th data-field="EarlyMin" data-sortable="true" class="text-nowrap text-center">Early (Min)</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
     function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'NormigVsRms_' + today;
    }

    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val(),
                exportTypes: ['csv', 'excel'],
                exportOptions: {
                    fileName: getCurDate()
                }
            });
        });
    });

    $table = $('#myTable').bootstrapTable({
        undefinedText: '',
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>

