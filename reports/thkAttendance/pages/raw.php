<?php
session_start();
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$orgCode = $_POST['orgCode'];

?>

<h4>Period: [ <?= $fromDate; ?> ] - [ <?= $toDate; ?> ][ All Stations ]</h4>
<div id="toolbar">
    <select class="form-control">
        <option value="">Export Only Page</option>
        <option value="all">Export All</option>
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_raw_data.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&orgCode=<?= $orgCode; ?>"
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
            <th colspan="7" data-align="left"><strong>Savan Legend Resorts sole  Company Limited.(Thakhek Clube)</strong></th>
        </tr>
        <tr>
            <th colspan="7" data-align="left"><strong>[Raw Data]-[All Stations]</strong></th>
        </tr>
        <tr>
            <th colspan="7" data-align="left"><strong><?= $fromDate; ?> - <?= $toDate; ?></strong></th>
        </tr>
        <tr>
            <th data-field="Dept" data-sortable="true" class="text-nowrap">Department</th>
            <th data-field="EmpID" data-sortable="true" class="text-nowrap">Emp ID</th>
            <th data-field="EmpName" data-sortable="true" class="text-nowrap">Emp Name</th>
            <th data-field="WorkDate" data-sortable="true" class="text-nowrap">Date</th>
            <th data-field="ScanTime" data-sortable="true" class="text-nowrap">Time</th>
            <th data-field="Station" data-sortable="true" class="text-nowrap">Device Name</th>
            <!-- <th data-field="DeviceZone" data-sortable="true" class="text-nowrap">Device Zone</th> -->
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'RawData_' + today;
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
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>

