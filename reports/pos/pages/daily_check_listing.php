<?php
session_start();

include '../config/db.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$posID = $_POST['posID'];
$posName = $_POST['posName'];

?>

<table id="myTable" class="table table-bordered table-striped" 
       data-url="./controllers/json_daily_check_listing.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&posID=<?= $posID; ?>"
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
            <th colspan="12"><strong style="color: red">Daily Check Listing Reports</strong></th>
        </tr>
        <tr>
            <th colspan="12">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?> &emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr>
            <th colspan="12">
                <span style="color: red; font-size: 16px;">Outlet: 
                    <?php
                    if ($posID <= 0) {
                        echo 'Please Select Outlet';
                    } else {
                        echo $posName;
                    }
                    ?>
                </span>
            </th>
        </tr>
        <tr>
            <th data-field="CheckNo" data-sortable="true" class="text-nowrap"><strong>Check No</strong></th>
            <th data-field="PaymentTypeName" data-footer-formatter="totalTextFormatter" data-sortable="true" class="text-nowrap"><strong>Payment Type</strong></th>
            <th data-field="PaymentAmount" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Payment</strong></th>
            <th data-field="Cover"  data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Cover</strong></th>
            <th data-field="FoodALA" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Food-ALA</strong></th>
            <th data-field="FoodBUF" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Food-BUF</strong></th>
            <th data-field="Beverage" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Beverage</strong></th>
            <th data-field="Tobacco" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Tobacco</strong></th>
            <th data-field="TobaccoRetail" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Tobacco-Retail</strong></th>
            <th data-field="Tax" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Tax</strong></th>
            <th data-field="Discount" data-footer-formatter="sumFormatter" data-sortable="true" class="text-nowrap"><strong>Discount</strong></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'SpaDetailsCheckListingReport_' + today;
    }

    const formatter = new Intl.NumberFormat('en-US', {
        currency: 'USD',
        minimumFractionDigits: 2
    })

    $table = $('#myTable').bootstrapTable({
        paging: false,
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        },

    });

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

</script>

