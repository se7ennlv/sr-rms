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

<table id="myTable" data-toggle="table" data-url="./controllers/json_sum_over.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&station=<?= $station; ?>" data-pagination="true" data-page-size="25" data-click-to-select="true" data-page-list="[10, 25, 50, 100, ALL]" data-search="true" data-height="650" data-toolbar="#toolbar" data-show-export="true" data-show-refresh="true" data-show-columns="true">
    <thead>
        <tr>
            <th colspan="6" data-align="left"><strong>Savan Legend Resorts sole Company Limited.</strong></th>
        </tr>
        <tr>
            <th colspan="6" data-align="left"><strong><?= $station; ?> [Over (3) Sumary Report]</strong></th>
        </tr>
        <tr>
            <th colspan="6" data-align="left"><strong><?= $fromDate; ?> - <?= $toDate; ?></strong></th>
        </tr>
        <tr>
            <th data-field="Station" class="text-center">Station</th>
            <th data-field="Date" class="text-center">Date</th>
            <th data-field="EmpID" class="text-center">ID</th>
            <th data-field="EmpName" data-halign="center">Name</th>
            <th data-field="OrgCode" data-halign="center">Department</th>
            <th data-field="NumRows" class="text-center" data-formatter="numberValue">Total Time Scan</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    var $table = $('#table');

    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");

        return 'OverSummaryReport_' + today;
    }

    $(function() {
        $('#toolbar').find('select').change(function() {
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

    function numberValue(data) {
        return '<label class="label label-success" style="font-size: 16px;">' + data + '</label>';
    }
</script>