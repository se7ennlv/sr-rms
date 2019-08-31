<?php
session_start();
include '../config/db.php';
include '../config/db3.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];

$begin = new DateTime($fromDate);
$end = new DateTime($toDate);
?>

<table id="myTable" class="table table-bordered table-striped" 
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-height="650"
       data-show-export="true"
       >
    <thead>
        <tr>
            <th colspan="12"><strong style="color: red;">Individual OC Report</strong></th>
        </tr>
        <tr>
            <th colspan="12">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?>&emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
    </thead>
    <tbody>
        <?php
        $sqlCreditor = "SELECT businessSourceName AS [CreditorID], contactTitleName +' '+contactFirstName +' '+contactLastName AS [CreditorName], contactDesignation AS [CreditorPosition] 
                          FROM [dbo].[cBusinessSource] 
                          WHERE businessSourceName LIKE '20%' AND isActive = 1
                          ORDER BY businessSourceName ASC ";

        $stmtCreditor = $conn3->prepare($sqlCreditor);
        $stmtCreditor->execute();

        while ($rsCreditor = $stmtCreditor->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <tr>
                <td colspan="12"><label style="color: green;">ID: [<?= $rsCreditor['CreditorID']; ?>]&emsp;Name: [<?= $rsCreditor['CreditorName']; ?>]</label></td>
            </tr>

            <?php
            $sqlItem = "SELECT VoucherNo, VoucherDate, PosName, ItemCateName, ItemName, ItemCode, Price, Qty, Tax, NetSale, PaymentFullTime, PeriodName
                            FROM SevenOC
                            WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$rsCreditor['CreditorID']}' ";

            $stmtItem = $conn->prepare($sqlItem);
            $stmtItem->execute();
            ?>

            <tr>
                <td class="text-center text-nowrap"><strong>Voucher No</strong></td>
                <td class="text-center text-nowrap"><strong>Voucher Date</strong></td>
                <td class="text-center text-nowrap"><strong>Pos Name</strong></td>
                <td class="text-center text-nowrap"><strong>Cate Name</strong></td>
                <td class="text-center text-nowrap"><strong>Item Name</strong></td>
                <td class="text-center text-nowrap"><strong>Item Code</strong></td>
                <td class="text-center text-nowrap"><strong>Price</strong></td>
                <td class="text-center text-nowrap"><strong>Qty</strong></td>
                <td class="text-center text-nowrap"><strong>Tax</strong></td>
                <td class="text-center text-nowrap"><strong>Net Sale</strong></td>
                <td class="text-center text-nowrap"><strong>Payment Date</strong></td>
                <td class="text-center text-nowrap"><strong>Period Name</strong></td>
            </tr>

            <?php
            $qtyTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;

            while ($rsItem = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td class="text-right"><?= $rsItem['VoucherNo']; ?></td>
                    <td class="text-center"><?= $rsItem['VoucherDate']; ?></td>
                    <td class="text-nowrap"><?= $rsItem['PosName']; ?></td>
                    <td class="text-nowrap"><?= $rsItem['ItemCateName']; ?></td>
                    <td class="text-nowrap"><?= $rsItem['ItemName']; ?></td>
                    <td class="text-nowrap"><?= $rsItem['ItemCode']; ?></td>
                    <td class="text-right"><?= sprintf('%.2f', $rsItem['Price']); ?></td>
                    <td class="text-right"><?= sprintf('%.2f', $rsItem['Qty']); ?></td>
                    <td class="text-right"><?= sprintf('%.2f', $rsItem['Tax']); ?></td>
                    <td class="text-right"><?= sprintf('%.2f', $rsItem['NetSale']); ?></td>
                    <td class="text-nowrap"><?= $rsItem['PaymentFullTime']; ?></td>
                    <td class="text-nowrap"><?= $rsItem['PeriodName']; ?></td>
                </tr>

                <?php
                $qtyTotal += $rsItem['Qty'];
                $taxTotal += $rsItem['Tax'];
                $netTotal += $rsItem['NetSale'];
                ?>

            <?php } ?>

            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
                <td class="text-right text-nowrap"><strong>Period Total:</strong></td>
                <td class="text-right"><strong><?= number_format($qtyTotal, 2); ?></strong></td>
                <td class="text-right"><strong><?= number_format($taxTotal, 2); ?></strong></td>
                <td class="text-right"><strong><?= number_format($netTotal, 2); ?></strong></td>
                <td colspan="2"></td>
            </tr>

            <?php
            $sqlSumByPos = "SELECT PosName, SUM(NetSale) AS [NetSale]
                                FROM SevenOC
                                WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$rsCreditor['CreditorID']}'
                                GROUP BY PosName
                                ORDER BY PosName ASC ";

            $stmtSumByPos = $conn->prepare($sqlSumByPos);
            $stmtSumByPos->execute();

            while ($rsSumByPos = $stmtSumByPos->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td class="text-right"><strong>Total:</strong></td>
                    <td class="text-left text-nowrap"><strong><?= $rsSumByPos['PosName']; ?></strong></td>
                    <td class="text-right"><strong>BT</strong></td>
                    <td><strong><?= number_format($rsSumByPos['NetSale'], 2); ?></strong></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>

            <?php } ?>

        <?php } ?>

    </tbody>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'IndividualOCReport_' + today;
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
