<?php
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$station = $_POST['station'];
?>

<h4>Period: [ <?= $station; ?> ] [ <?= $fromDate; ?> ] - [ <?= $toDate; ?> ]</h4>
<div id="toolbar">
    <select class="form-control">
        <option value="">Export Only Page</option>
        <option value="all">Export All</option>
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_raw_data.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&station=<?= $station; ?>"
       data-pagination="true"
       data-page-size="25"
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
            <th colspan="8" data-align="left"><strong><?= $station; ?> (Raw Data)</strong></th>
        </tr>
        <tr>
            <th colspan="8" data-align="left"><strong><?= $fromDate; ?> - <?= $toDate; ?></strong></th>
        </tr>
        <tr>
            <th data-field="Station" data-sortable="true" class="text-center">Station</th>
            <th data-field="Dept" data-sortable="true" class="text-center">Department</th>
            <th data-field="EmpID" data-sortable="true" class="text-center">Emp ID</th>
            <th data-field="EmpName" data-sortable="true" class="text-center">Emp Name</th>
            <th data-field="Dates" data-sortable="true" class="text-center">Date</th>
            <th data-field="Times" data-sortable="true" class="text-center">Time</th>
            <th data-field="Periods" data-sortable="true" class="text-center">Periods</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'raw_data_report_' + today;
    }

    var $table = $('#table');
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
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>

