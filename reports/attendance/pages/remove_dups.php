<?php
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
?>

<h4>Period: [ <?= $fromDate; ?> ] - [ <?= $toDate; ?> ][ Remove Dups Data ]</h4>
<div id="toolbar">
    <select class="form-control">
        <option value="">Export Only Page</option>
        <option value="selected">Export Selected</option>
        <option value="all">Export All</option>
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_remove_dups_data.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>"
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
            <th colspan="4" data-align="left"><strong>Savan Legend Resorts sole  Company Limited.</strong></th>
        </tr>
        <tr>
            <th colspan="4" data-align="left"><strong>[Remove Dups Data]</strong></th>
        </tr>
        <tr>
            <th colspan="4" data-align="left"><strong><?= $fromDate; ?> - <?= $toDate; ?></strong></th>
        </tr>
        <tr>
            <th data-field="state" data-checkbox="true" class="text-nowrap"></th>
            <th data-field="Department" data-sortable="true" class="text-nowrap">Department</th>
            <th data-field="ID" data-sortable="true" class="text-nowrap">ID</th>
            <th data-field="Name" data-sortable="true" class="text-nowrap">Name</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'RemoveDupsData_' + today;
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

