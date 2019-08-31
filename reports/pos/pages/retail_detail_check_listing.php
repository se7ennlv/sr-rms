<?php
session_start();

include '../config/db.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
?>

<table id="myTable" class="table table-bordered table-striped" 
       data-url="./controllers/json_retail.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>"
       data-search="true"
       data-show-refresh="true"
       data-show-columns="true"
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-height="650"
       data-show-footer="true"
       data-export-footer="true"
       data-show-export="true"
       >
    <thead>
        <tr>
            <th colspan="9"><strong style="color: red">Retail Shop Details Check Listing Report</strong></th>
        </tr>
        <tr>
            <th colspan="9">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?> &emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr>
            <th colspan="9"><span style="color: red;">Outlet: Retail Shop</span></th>
        </tr>
        <tr>
            <th data-field="CheckNo" data-sortable="true" class="text-nowrap"><strong>Check No</strong></th>
            <th data-field="PayTypeName" data-footer-formatter="totalTextFormatter" data-sortable="true" class="text-nowrap"><strong>Payment Type</strong></th>
            <th data-field="PaymentAmount" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Payment</strong></th>
            <th data-field="Retail" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Retail</strong></th>
            <th data-field="Beverage" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Beverage</strong></th>
            <th data-field="Liqours" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Liqours</strong></th>
            <th data-field="RefillCard" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Refill-Card</strong></th>
            <th data-field="Tobacco" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Tobacco</strong></th>
            <th data-field="SubTotal" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Sub Total</strong></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'RetailShopDetailsCheckListingReport_' + today;
    }

    const formatter = new Intl.NumberFormat('en-US', {
        //style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    })

    function totalTextFormatter(data) {
        return '<strong>Grand Total</strong>';
    }

    function sumFormatter(data) {
        var field = this.field;

        var totalSum = data.reduce(function (sum, row) {
            return sum + (+row[field]);
        }, 0);

        return '<strong>' + formatter.format(totalSum) + '</strong>';
    }
    
    $table = $('#myTable').bootstrapTable({
        paging: false,
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        },
    });

</script>

