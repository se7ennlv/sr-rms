<?php
session_start();
include '../config/db.php';
include '../config/db3.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];

?>

<table id="myTable" class="table table-bordered table-striped" 
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-height="650"
       data-show-export="true"
       >
    <thead>
        <tr>
            <th colspan="8"><strong style="color: red;">House Check Summary Comp-Officer Report</strong></th>
        </tr>
        <tr>
            <th colspan="8">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?>&emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
    </thead>
    <tbody>
        
        <?php
        $sqlCreditor = "SELECT businessSourceName AS [CreditorID], contactTitleName +' '+contactFirstName +' '+contactLastName AS [CreditorName], contactDesignation AS [CreditorPosition] 
                            FROM [dbo].[cBusinessSource] 
                            WHERE businessSourceName LIKE '20%'
                            ORDER BY businessSourceName ASC ";

        $stmtCreditor = $conn3->prepare($sqlCreditor);
        $stmtCreditor->execute();

        while ($resCreditor = $stmtCreditor->fetch(PDO::FETCH_ASSOC)) {
            $alaTotal = 0;
            $bufTotal = 0;
            $bevTotal = 0;
            $tobTotal = 0;
            $otherTotal = 0;
            $grandTotal = 0;
            ?>
        
            <tr>
                <td colspan="8"><strong>ID: [ <?= $resCreditor['CreditorID']; ?> ]&emsp;Name: [ <?= $resCreditor['CreditorName']; ?> ]</strong></td>
            </tr>                                           
            <tr>
                <td class="text-right"><strong>Outlet</strong></td>
                <td class="text-center"><strong>Pay Type</strong></td>
                <td class="text-center"><strong>Food-ALA</strong></td>
                <td class="text-center"><strong>Food-BUF</strong></td>
                <td class="text-center"><strong>Beverage</strong></td>
                <td class="text-center"><strong>Tobacco</strong></td>
                <td class="text-center"><strong>Other</strong></td>
                <td class="text-center"><strong>Sub Total</strong></td>
            </tr>

            <?php
            $sqlOutlet = "SELECT PosID, PosName, PaymentTypeName
                            FROM SevenOC
                            WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' 
                            GROUP BY PosID, PosName, PaymentTypeName
                        ";

            $stmtOutlet = $conn->prepare($sqlOutlet);
            $stmtOutlet->execute();
            while ($rsOutlet = $stmtOutlet->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <?php
                $sqlSum = "SELECT 
                                (SELECT SUM(ISNULL(NetSale, 0)) FROM SevenOC
                                 WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' AND PosID = '{$rsOutlet['PosID']}' AND ItemCateID = 1) AS [FoodAlA],
                                (SELECT SUM(ISNULL(NetSale, 0)) FROM SevenOC
                                 WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' AND PosID = '{$rsOutlet['PosID']}' AND ItemCateID = 2) AS [FoodBuf],
                                (SELECT SUM(ISNULL(NetSale, 0)) FROM SevenOC
                                 WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' AND PosID = '{$rsOutlet['PosID']}' AND ItemCateID = 3) AS [Beverage],
                                (SELECT SUM(ISNULL(NetSale, 0)) FROM SevenOC
                                 WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' AND PosID = '{$rsOutlet['PosID']}' AND ItemCateID = 4) AS [Tobacco],
                                (SELECT SUM(ISNULL(NetSale, 0)) FROM SevenOC
                                 WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' AND PosID = '{$rsOutlet['PosID']}' AND ItemCateID = 5) AS [Other],
                                (SELECT SUM(ISNULL(NetSale, 0)) FROM SevenOC
                                 WHERE PaymentDate BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = '{$resCreditor['CreditorID']}' AND PosID = '{$rsOutlet['PosID']}' ) AS [SubTotal]
                            ";

                $stmtSum = $conn->prepare($sqlSum);
                $stmtSum->execute();
                while ($rsSum = $stmtSum->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <tr>
                        <td class="text-right"><?= $rsOutlet['PosName']; ?></td>
                        <td class="text-right"><?= $rsOutlet['PaymentTypeName']; ?></td>
                        <td class="text-right"><?= sprintf('%.2f', $rsSum['FoodAlA']); ?></td>
                        <td class="text-right"><?= sprintf('%.2f', $rsSum['FoodBuf']); ?></td>
                        <td class="text-right"><?= sprintf('%.2f', $rsSum['Beverage']); ?></td>
                        <td class="text-right"><?= sprintf('%.2f', $rsSum['Tobacco']); ?></td>
                        <td class="text-right"><?= sprintf('%.2f', $rsSum['Other']); ?></td>
                        <td class="text-right"><strong><?= sprintf('%.2f', $rsSum['SubTotal']); ?></strong></td>
                    </tr>

                    <?php
                    $alaTotal += $rsSum['FoodAlA'];
                    $bufTotal += $rsSum['FoodBuf'];
                    $bevTotal += $rsSum['Beverage'];
                    $tobTotal += $rsSum['Tobacco'];
                    $otherTotal += $rsSum['Other'];
                    $grandTotal += $rsSum['SubTotal'];
                    ?>

                <?php } ?>

            <?php } ?>

            <tr>
                <td class="text-right" colspan="2"><strong>Grand Total</strong></td>
                <td class="text-right"><strong><?= number_format($alaTotal, 2) ?></strong></td>
                <td class="text-right"><strong><?= number_format($bufTotal, 2) ?></strong></td>
                <td class="text-right"><strong><?= number_format($bevTotal, 2) ?></strong></td>
                <td class="text-right"><strong><?= number_format($tobTotal, 2) ?></strong></td>
                <td class="text-right"><strong><?= number_format($otherTotal, 2) ?></strong></td>
                <td class="text-right"><strong><?= number_format($grandTotal, 2) ?></strong></td>
            </tr>

        <?php } $conn = NULL; ?>

    </tbody>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'HouseCheckSummaryCompOfficerReport_' + today;
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
