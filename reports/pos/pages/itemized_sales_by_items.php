<?php
session_start();
include '../config/db.php';
include '../config/db2.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$posID = $_POST['posID'];
$posName = $_POST['posName'];
?>

<table id="myTable" class="table table-bordered table-striped"
       data-toggle="table"
       data-url="./controllers/json_itemized_sales_by_items.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&posID=<?= $posID; ?>"
       data-search="true"
       data-show-refresh="true"
       data-show-columns="true"
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-height="650"
       data-show-footer="true"
       data-export-footer="true"
       data-show-export="true">
    <thead>
        <tr>
            <th colspan="6" data-align="left"><strong style="color: red">Itemized Sales by Items</strong></th>
        </tr>
        <tr>
            <th colspan="6" data-align="left">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?>&emsp;Printed By:&emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr>
            <th colspan="6" data-align="left">
                <label style="color: red;">Outlet: <?php
                    if ($posID <= 0) {
                        echo 'Please Select Outlet';
                    } else {
                        echo $posName;
                    }
                    ?>
                </label>
            </th>
        </tr>
        <tr>
            <th data-field="ItemCateName" class="text-nowrap"><strong>Categories</strong></th>
            <th data-field="ItemCode" class="text-nowrap"><strong>Item Code</strong></th>
            <th data-field="ItemName" class="text-nowrap"><strong>Item Name</strong></th>
            <th data-field="Price" data-footer-formatter="totalTextFormatter" class="text-nowrap text-center"><strong>Price</strong></th>
            <th data-field="Qty" data-footer-formatter="sumFormatter" class="text-nowrap text-center"><strong>Qty</strong></th>
            <th data-field="Amount" data-footer-formatter="sumFormatter" class="text-nowrap text-center"><strong>Amount</strong></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'ItemizedSalesByItems_' + today;
    }
    
    const formatter = new Intl.NumberFormat('en-US', {
        currency: 'USD',
        minimumFractionDigits: 2
    })

  

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
        exportDataType: 'all',
        exportOptions: {
            fileName: getCurDate()
        },
    });
</script>
