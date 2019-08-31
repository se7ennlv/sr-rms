<?php
session_start();
include '../config/db.php';
include '../config/db2.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
?>

<table id="myTable" 
       data-toggle="table"
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-search="true"
       data-height="650"
       data-show-export="true"
       data-show-refresh="true"
       data-show-columns="true">
    <thead>
        <tr>
            <th colspan="9" data-align="left"><strong style="color: red">Bill Voided Report</strong></th>
        </tr>
        <tr>
            <th colspan="9" data-align="left">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?> &emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr>
            <th></th><th></th><th></th><th></th><th></th><th></th><th></th>
        </tr>
        <tr>
            <th>
                <h3 style="color: red" class="text-center">Records not found (The POS system will be delete records from database when use the function void)</h3>
            </th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'BillCancelVoidReport_' + today;
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
