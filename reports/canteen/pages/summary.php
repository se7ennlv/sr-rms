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
       data-url="./controllers/json_sum_data.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&station=<?= $station; ?>"
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
            <th colspan="8" data-align="left"><strong><?= $station; ?> (Sumary Report)</strong></th>
        </tr>
        <tr>
            <th colspan="8" data-align="left"><strong><?= $fromDate; ?> - <?= $toDate; ?></strong></th>
        </tr>
        <tr>
            <th data-field="Department" data-sortable="true">Department</th>
            <th data-field="Period_Title" data-sortable="true">Period_Title</th>
            <th data-field="countRows" data-sortable="true">Total</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'SummaryReport_' + today;
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

