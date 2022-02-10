<?php
session_start();
include '../config/db.php';
include '../config/db2.php';
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$posID = $_POST['posID'];
$posName = $_POST['posName'];
?>

<table id="myTable" class="table table-bordered table-striped" data-page-size="All" data-page-list="[10, 25, 50, 100, ALL]" data-height="650" data-show-export="true">
    <thead>
        <tr>
            <th colspan="14"><strong style="font-size: 24px">Food & Beverage Revenue Report</strong></th>
        </tr>

        <tr>
            <th colspan="14">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?> &emsp;Printed By: &emsp;<?= $_SESSION['fname']; ?>&ensp;<?= $_SESSION['lname']; ?></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="14"><label style="color: red; font-size: 20px;">Outlet: <?php if ($posID <= 0) {
                                                                                        echo 'Please Select Outlet';
                                                                                    } else {
                                                                                        echo $posName;
                                                                                    } ?></label></td>
        </tr>
        <tr>
            <?php
            $strPeriod = "SELECT * FROM KhamlaPeriod ORDER BY PeriodID ASC";

            $stmtPeriod = $conn->prepare($strPeriod);
            $stmtPeriod->execute();
            while ($resPeriodName = $stmtPeriod->FETCH(PDO::FETCH_ASSOC)) {
            ?>
                <td colspan="14"><strong style="color: green;font-size: 20px; "><?= $resPeriodName['PeriodName']; ?></strong></td>
        </tr>
        <tr>
            <td class="text-nowrap"><strong>Description</strong></td>
            <td class="text-nowrap text-center"><strong>Cover Food</strong></td>
            <td class="text-nowrap text-center"><strong>Food Revenue</strong></td>
            <td class="text-nowrap text-center"><strong>Cover Beverage</strong></td>
            <td class="text-nowrap text-center"><strong>Beverage Revenue</strong></td>
            <td class="text-nowrap text-center"><strong>Total Cover</strong></td>
            <td class="text-nowrap text-center"><strong>Total revenue</strong></td>
        </tr>
        <?php
                $sqlPayType = "SELECT 
                -- PaymentTypeCode,
                PaymentTypeName,
                PeriodID,
                PeriodName,
                SUM(CoverFood) as CoverFood,
                SUM(FoodRevenue) as FoodRevenue,
                
                SUM(CoverBev) as CoverBev,
                SUM(BeverageRev) as BeverageRev,
                
                SUM(TotalCover) as TotalCover,
                SUM(TotalRevenue) as TotalRevenue
                
                FROM  KView
                -- WHERE voucherDate BETWEEN '2019-12-24' AND '2019-12-24' AND POSId = 4 
                WHERE voucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND POSId = {$posID}
                GROUP BY PaymentTypeName,
                PeriodID,
                PeriodName
                ORDER BY  PaymentTypeName, PeriodID";
                $stmtPayType = $conn->prepare($sqlPayType);
                $stmtPayType->execute();


                $TotalCoverFood = 0;
                $TotalFoodRev = 0;
                $TotalCoverBev = 0;
                $TotalBeverageRev = 0;
                $TotalCover = 0;
                $TotalRevenue = 0;

                // $GrandCovertFood = 0;
                // $GrandFoodRev = 0;
                // $GrandCoverBev = 0;
                // $GrandBeverageRev = 0;
                // $GrandTotalCover = 0;
                // $GrandTotalRevenue = 0;


                while ($resPayType = $stmtPayType->FETCH(PDO::FETCH_ASSOC)) { ?>


            <?php if ($resPeriodName['PeriodID'] === $resPayType['PeriodID']) { ?>
                <tr>
                    <td><?= $resPayType['PaymentTypeName']; ?></td>
                    <td class="text-nowrap text-center"><?= $resPayType['CoverFood']; ?></td>
                    <td class="text-nowrap text-center"><?= number_format($resPayType['FoodRevenue'], 2); ?></td>
                    <td class="text-nowrap text-center"><?= $resPayType['CoverBev']; ?></td>
                    <td class="text-nowrap text-center"><?= number_format($resPayType['BeverageRev'], 2); ?></td>
                    <td class="text-nowrap text-center"><?= number_format($resPayType['TotalCover'], 2); ?></td>
                    <td class="text-nowrap text-center"><?= number_format($resPayType['TotalRevenue'], 2); ?></td>
                </tr>

                <?php
                        $TotalCoverFood += $resPayType['CoverFood'];
                        $TotalFoodRev += $resPayType['FoodRevenue'];
                        $TotalCoverBev += $resPayType['CoverBev'];
                        $TotalBeverageRev += $resPayType['BeverageRev'];
                        $TotalCover += $resPayType['TotalCover'];
                        $TotalRevenue += $resPayType['TotalRevenue'];
                        // ------------------------------------------
                ?>
            <?php } ?>
            
        <?php } ?>

        <tr>
            <td class="text-nowrap text-center"><strong>Total:</strong></td>
            <td class="text-nowrap text-center"><strong><?= $TotalCoverFood; ?></strong></td>
            <td class="text-nowrap text-center"><strong><?= number_format($TotalFoodRev, 2); ?></strong></td>
            <td class="text-nowrap text-center"><strong><?= $TotalCoverBev; ?></strong></td>
            <td class="text-nowrap text-center"><strong><?= number_format($TotalBeverageRev, 2); ?></strong></td>
            <td class="text-nowrap text-center"><strong><?= number_format($TotalCover, 2); ?></strong></td>
            <td class="text-nowrap text-center"><strong><?= number_format($TotalRevenue, 2); ?></strong></td>
        </tr>
        <?php
                $GrandCovertFood += $TotalCoverFood;
                $GrandFoodRev += $TotalFoodRev;
                $GrandCoverBev += $TotalCoverBev;
                $GrandBeverageRev += $TotalBeverageRev;
                $GrandTotalCover += $TotalCover;
                $GrandTotalRevenue += $TotalRevenue;
        ?>
    <?php } ?>

    <tr>
        <td class="text-nowrap text-center"><strong>Grand Total:</strong></td>
        <td class="text-nowrap text-center"><strong><?= $GrandCovertFood; ?></strong></td>
        <td class="text-nowrap text-center"><strong><?= number_format($GrandFoodRev, 2); ?> </strong></td>
        <td class="text-nowrap text-center"><strong><?= $GrandCoverBev; ?></strong></td>
        <td class="text-nowrap text-center"><strong><?= number_format($GrandBeverageRev, 2); ?></strong></td>
        <td class="text-nowrap text-center"><strong><?= number_format($GrandTotalCover, 2); ?></strong></td>
        <td class="text-nowrap text-center"><strong><?= number_format($GrandTotalRevenue, 2); ?></strong></td>
    </tr>
    </tbody>
    <?php $conn = NULL; ?>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'RevenueReport_' + today;
    }

    $table = $('#myTable').bootstrapTable({
        paging: false,
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>