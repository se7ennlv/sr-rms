<?php
session_start();
include '../config/db.php';
include '../config/db2.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
?>

<table id="myTable" 
       data-toggle="table"
       data-url="./controllers/json_is_kot_void.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>"
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-search="true"
       data-height="650"
       data-show-export="true"
       data-show-refresh="true"
       data-show-columns="true">
    <thead>
        <tr>
            <th colspan="9" data-align="left"><strong style="color: red">KOT Voided Report</strong></th>
        </tr>
        <tr>
            <th colspan="9" data-align="left">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?> &emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
        <tr>
            <th data-field="Outlet" data-sortable="true" class="text-nowrap"><strong>Outlet</strong></th>
            <th data-field="KotNo" data-sortable="true" class="text-nowrap"><strong>KOT No</strong></th>
            <th data-field="KotDate" data-sortable="true" class="text-nowrap"><strong>KOT Date</strong></th>
            <th data-field="ServiceType" data-sortable="true" class="text-nowrap">Service Type</th>
            <th data-field="ItemName" data-sortable="true" class="text-nowrap"><strong>Item Name</strong></th>
            <th data-field="WaiterName" data-sortable="true" class="text-nowrap"><strong>Waiter Name</strong></th>
            <th data-field="Source" data-sortable="true" class="text-nowrap"><strong>Source</strong></th>
            <th data-field="VoidedBy" data-sortable="true" class="text-nowrap"><strong>Voided By</strong></th>
            <th data-field="VoidedDate" data-sortable="true" class="text-nowrap"><strong>Voided Date</strong></th>           
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'KotCancelVoidReport_' + today;
    }

    $table = $('#myTable').bootstrapTable({
        paging: false,
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportDataType: 'all',
        exportOptions: {
            fileName: getCurDate()
        },

    });
</script>
