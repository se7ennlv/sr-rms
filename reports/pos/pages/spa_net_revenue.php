<?php
session_start();
include '../config/db.php';

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$posID = $_POST['posID'];
$posName = $_POST['posName'];
?>

<table id="myTable" class="table table-bordered table-striped" 
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-height="650"
       data-show-export="true"
       >
    <thead>
        <tr>
            <th colspan="11"><strong style="color: red">Cross Outlet Net Revenue Report</strong></th>
        </tr>
        <tr>
            <th colspan="11">Period [ <?= $fromDate; ?> To <?= $toDate; ?> ]&emsp;Printed At:&emsp;<?= date("Y-m-d h:i:s A"); ?> &emsp;Printed By: &emsp;<?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></th>
        </tr>
        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="11"><label style="color: green; font-size: 16px;">Outlet: <?php if($posID <= 0){echo 'Please Select Outlet'; }else{echo $posName;}?></label></td>
        </tr>
        <tr><td colspan="11"><strong style="color: red; ">REVENUE BY PERIOD</strong></td></tr>
        <tr>
        <tr>
            <td class="text-nowrap text-right"><strong>Meal Period</strong></td>
            <td class="text-nowrap text-center"><strong>Payment</strong></td>
            <td class="text-nowrap text-center"><strong>Covers</strong></td>
            <td class="text-nowrap text-center"><strong>No Of Check</strong></td>
            <td class="text-nowrap text-center"><strong>Spa</strong></td> 
            <td class="text-nowrap text-center"><strong>Spa-Massage</strong></td> 
            <td class="text-nowrap text-center"><strong>Spa-Facial</strong></td> 
            <td class="text-nowrap text-center"><strong>Spa-Consignment</strong></td> 
            <td class="text-nowrap text-center"><strong>Spa-Other</strong></td>    
            <td class="text-nowrap text-center"><strong>Tax</strong></td>
            <td class="text-nowrap text-center"><strong>Discount</strong></td>
        </tr>

        <?php
        $sqlPeriod = "SELECT * FROM SevenMealPeriod ORDER BY PeriodID ASC";

        $stmtPeriod = $conn->prepare($sqlPeriod);
        $stmtPeriod->execute();

        $paymentTotal = 0;
        $coverTotal = 0;
        $noOfCheckTotal = 0;
        $spaTotal = 0;
        $msgTotal = 0;
        $facialTotal = 0;
        $ConsTotal = 0;
        $otherTotal = 0;
        $taxTotal = 0;
        $discTotal = 0;

        while ($resPeriod = $stmtPeriod->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <?php
            $sqlByPeriod = "WITH cte AS(
                            SELECT TOP(100)PERCENT
                            RowID = ROW_NUMBER() OVER(ORDER BY st.salesTranID), 
                            CONVERT(DATE, sm.voucherDate) AS [VoucherDate],
                            sm.voucherNo AS [VoucherNo],
                            sm.POSId AS [PosID],
                            itemcate.itemCategoryID AS [ItemCateID],
                            CAST(st.rate * st.quantity AS NUMERIC(10, 2)) AS [ItemSale],
                            CASE WHEN (spt.payTypeID IN(1, 36, 37) OR spt.payTypeID IS NULL) THEN CAST(sm.totalTaxAmount AS NUMERIC(10, 2)) ELSE 0 END [TaxTotal],
                            CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [DiscTotal],
                            CAST(sm.totalPaidAmount AS NUMERIC(10, 2)) AS [Payment],
                            CASE 
                                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '04:00:01' AND '11:00:00' THEN '1'
                                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '11:00:01' AND '15:30:00' THEN '2'
                                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '15:30:01' AND '21:30:00' THEN '3'
                                ELSE '4'
                            END AS [PeriodID],
                            CAST(sm.noOfPerson AS NUMERIC(10, 2)) AS [Cover]
                            FROM tSalesTran st
                            LEFT JOIN mSalesMaster sm ON st.salesID = sm.salesID
                            INNER JOIN mPOS pos ON sm.POSId = pos.posID
                            INNER JOIN mItemGroupCategory itemcate ON st.itemGroupID = itemcate.groupID
                            LEFT JOIN tSalesPaymentTran spt ON st.salesID = spt.salesID
                            WHERE sm.voucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND sm.POSId = {$posID}
                            )
                            SELECT TOP(100)PERCENT
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Payment = nex.Payment THEN 0 ELSE cte.Payment END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [Payment],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Cover = nex.Cover THEN 0 ELSE cte.Cover END) , 0)
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [Cover],
                            (SELECT ISNULL(COUNT(DISTINCT cte.VoucherNo), 0) FROM cte WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = {$resPeriod['PeriodID']}) AS [NoOfCheck],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.ItemSale = nex.ItemSale THEN 0 ELSE cte.ItemSale END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.ItemCateID = 6 AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [Spa],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.ItemSale = nex.ItemSale THEN 0 ELSE cte.ItemSale END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.ItemCateID = 7 AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [SpaMassage],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.ItemSale = nex.ItemSale THEN 0 ELSE cte.ItemSale END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.ItemCateID = 8 AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [SpaFacial],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.ItemSale = nex.ItemSale THEN 0 ELSE cte.ItemSale END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.ItemCateID = 9 AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [SpaConsignment],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.ItemSale = nex.ItemSale THEN 0 ELSE cte.ItemSale END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.ItemCateID = 10 AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [SpaOther],                      
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.TaxTotal = nex.TaxTotal THEN 0 ELSE cte.TaxTotal END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [TaxTotal],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.DiscTotal = nex.DiscTotal THEN 0 ELSE cte.DiscTotal END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = {$resPeriod['PeriodID']}
                            ) AS [DiscTotal] ";

            $stmtByPeriod = $conn->prepare($sqlByPeriod);
            $stmtByPeriod->execute();

            while ($resByPeriod = $stmtByPeriod->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td class="text-right"><strong><?= $resPeriod['PeriodName']; ?></strong></td>
                    <td class="text-right"><?= $resByPeriod['Payment']; ?></td>
                    <td class="text-right"><?= $resByPeriod['Cover']; ?></td>
                    <td class="text-right"><?= $resByPeriod['NoOfCheck']; ?></td>
                    <td class="text-right"><?= $resByPeriod['Spa']; ?></td>
                    <td class="text-right"><?= $resByPeriod['SpaMassage']; ?></td>
                    <td class="text-right"><?= $resByPeriod['SpaFacial']; ?></td>
                    <td class="text-right"><?= $resByPeriod['SpaConsignment']; ?></td>
                    <td class="text-right"><?= $resByPeriod['SpaOther']; ?></td>
                    <td class="text-right"><?= $resByPeriod['TaxTotal']; ?></td>
                    <td class="text-right"><?= $resByPeriod['DiscTotal']; ?></td>
                </tr>

                <?php
                $paymentTotal += $resByPeriod['Payment'];
                $coverTotal += $resByPeriod['Cover'];
                $noOfCheckTotal += $resByPeriod['NoOfCheck'];
                $spaTotal += $resByPeriod['Spa'];
                $msgTotal += $resByPeriod['SpaMassage'];
                $facialTotal += $resByPeriod['SpaFacial'];
                $ConsTotal += $resByPeriod['SpaConsignment'];
                $otherTotal += $resByPeriod['SpaOther'];
                $taxTotal += $resByPeriod['TaxTotal'];
                $discTotal += $resByPeriod['DiscTotal'];
                ?>

            <?php } ?>

        <?php } ?>

        <tr>
            <td class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong><?= number_format($paymentTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($coverTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($noOfCheckTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($spaTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($msgTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($facialTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($ConsTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($otherTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($taxTotal, 2) ?></strong></td>
            <td class="text-right"><strong><?= number_format($discTotal, 2) ?></strong></td>
        </tr>
        <tr><td colspan="11"><strong style="color: red; ">REVENUE BY PAYMENT</strong></td></tr>
        <tr>
            <td><strong>Pay Type</strong></td>
            <td class="text-center"><strong>Payment</strong></td>
            <td class="text-center"><strong>Covers</strong></td>
            <td class="text-center"><strong>Breakfast</strong></td>
            <td class="text-center"><strong>Lunch</strong></td>
            <td class="text-center"><strong>Dinner</strong></td>
            <td class="text-center"><strong>Supper</strong></td>
            <td></td><td></td><td></td><td></td>
        </tr>

        <?php
        $sqlPayType = "WITH cte AS(
                        SELECT TOP(100)PERCENT
                        RowID = ROW_NUMBER() OVER(ORDER BY st.salesTranID), 
                        CONVERT(DATE, sm.voucherDate) AS [VoucherDate],
                        sm.voucherNo AS [VoucherNo],
                        sm.POSId AS [PosID],
                        CAST(st.discAmount AS NUMERIC(10, 2)) AS [DiscAmt],
                        CAST(st.itemAmount AS NUMERIC(10, 2)) AS [TotalSale],
                        CASE WHEN (spt.payTypeID IN(1, 36, 37) OR spt.payTypeID IS NULL) THEN CAST(sm.totalTaxAmount AS NUMERIC(10, 2)) ELSE 0 END [TaxTotal],
                        CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [DiscTotal],
                        CAST(sm.totalPaidAmount AS NUMERIC(10, 2)) AS [Payment],
                        CASE
                            WHEN spt.payTypeID IS NULL AND spt.roomID IS NULL THEN CONVERT(VARCHAR, bs.businessSourceName)
                            WHEN spt.payTypeID IS NULL AND spt.creditorID IS NULL THEN CONVERT(VARCHAR, spt.roomID)
                            ELSE CONVERT(VARCHAR, pmt.paymentTypeAlias)
                        END AS [PaymentTypeCode],
                        CASE
                            WHEN spt.payTypeID IS NULL AND spt.roomID IS NULL THEN CONVERT(VARCHAR, bs.businessSourceName)
                            WHEN spt.payTypeID IS NULL AND spt.creditorID IS NULL THEN CONVERT(VARCHAR, spt.roomID)
                            ELSE CONVERT(VARCHAR, pmt.paymentTypeName)
                        END AS [PaymentTypeName],
                        CASE 
                            WHEN CAST(spt.paymentDate AS TIME) BETWEEN '04:00:01' AND '11:00:00' THEN '1'
                            WHEN CAST(spt.paymentDate AS TIME) BETWEEN '11:00:01' AND '15:30:00' THEN '2'
                            WHEN CAST(spt.paymentDate AS TIME) BETWEEN '15:30:01' AND '21:30:00' THEN '3'
                            ELSE '4'
                        END AS [PeriodID],
                        CAST(sm.noOfPerson AS NUMERIC(10, 2)) AS [Cover]
                        FROM tSalesTran st
                        LEFT JOIN mSalesMaster sm ON st.salesID = sm.salesID
                        INNER JOIN mPOS pos ON sm.POSId = pos.posID
                        LEFT JOIN tSalesPaymentTran spt ON st.salesID = spt.salesID
                        LEFT JOIN mPaymentType pmt ON spt.payTypeID = pmt.paymentTypeID
                        LEFT JOIN [172.16.98.16\ASI2008].[ASIFD600].[dbo].[cBusinessSource] bs ON bs.businessSourceID = spt.creditorID
                        WHERE sm.voucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND sm.POSId = {$posID}
                        )
                        SELECT TOP(100)PERCENT
                        cte.PaymentTypeCode, 
                        cte.PaymentTypeName, 
                        SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Payment = nex.Payment THEN 0 ELSE cte.Payment END) AS [Payment],
                        SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Cover = nex.Cover THEN 0 ELSE cte.Cover END) AS [Cover]
                        FROM cte
                        LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                        LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                        GROUP BY cte.PaymentTypeCode, cte.PaymentTypeName ";

        $stmtPayType = $conn->prepare($sqlPayType);
        $stmtPayType->execute();

        $payTotal = 0;
        $covTotal = 0;
        $bfTotal = 0;
        $lunTotal = 0;
        $dinTotal = 0;
        $supTotal = 0;

        while ($resPayType = $stmtPayType->FETCH(PDO::FETCH_ASSOC)) {
            ?>

            <?php
            $sqlByPayType = "WITH cte AS(
                            SELECT TOP(100)PERCENT
                            RowID = ROW_NUMBER() OVER(ORDER BY st.salesTranID), 
                            CONVERT(DATE, sm.voucherDate) AS [VoucherDate],
                            sm.voucherNo AS [VoucherNo],
                            sm.POSId AS [PosID],
                            CASE WHEN (spt.payTypeID IN(1, 36, 37) OR spt.payTypeID IS NULL) THEN CAST(sm.totalTaxAmount AS NUMERIC(10, 2)) ELSE 0 END [TaxTotal],
                            CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [DiscTotal],
                            CAST(sm.totalPaidAmount AS NUMERIC(10, 2)) AS [Payment],
                            CASE
                                WHEN spt.payTypeID IS NULL AND spt.roomID IS NULL THEN CONVERT(VARCHAR, bs.businessSourceName)
                                WHEN spt.payTypeID IS NULL AND spt.creditorID IS NULL THEN CONVERT(VARCHAR, spt.roomID)
                                ELSE CONVERT(VARCHAR, pmt.paymentTypeAlias)
                            END AS [PaymentTypeCode],
                            CASE 
                                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '04:00:01' AND '11:00:00' THEN '1'
                                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '11:00:01' AND '15:30:00' THEN '2'
                                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '15:30:01' AND '21:30:00' THEN '3'
                                ELSE '4'
                            END AS [PeriodID],
                            sm.noOfPerson AS[Cover]
                            FROM tSalesTran st
                            LEFT JOIN mSalesMaster sm ON st.salesID = sm.salesID
                            INNER JOIN mPOS pos ON sm.POSId = pos.posID
                            LEFT JOIN tSalesPaymentTran spt ON st.salesID = spt.salesID
                            LEFT JOIN mPaymentType pmt ON spt.payTypeID = pmt.paymentTypeID
                            LEFT JOIN [172.16.98.16\ASI2008].[ASIFD600].[dbo].[cBusinessSource] bs ON bs.businessSourceID = spt.creditorID
                            WHERE sm.voucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND sm.POSId = {$posID}
                            )
                            SELECT TOP(100)PERCENT
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Payment = nex.Payment THEN 0 ELSE cte.Payment END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = 1 AND RTRIM(cte.PaymentTypeCode) = '{$resPayType['PaymentTypeCode']}'
                             ) AS [Breakfast],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Payment = nex.Payment THEN 0 ELSE cte.Payment END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = 2 AND RTRIM(cte.PaymentTypeCode) = '{$resPayType['PaymentTypeCode']}'
                             ) AS [Lunch],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Payment = nex.Payment THEN 0 ELSE cte.Payment END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = 3 AND RTRIM(cte.PaymentTypeCode) = '{$resPayType['PaymentTypeCode']}'
                             ) AS [Dinner],
                            (SELECT ISNULL(SUM(CASE WHEN cte.VoucherNo = nex.VoucherNo AND cte.Payment = nex.Payment THEN 0 ELSE cte.Payment END) , 0) 
                               FROM cte 
                               LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1 
                               LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
                               WHERE cte.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND cte.PosID = {$posID} AND cte.PeriodID = 4 AND RTRIM(cte.PaymentTypeCode) = '{$resPayType['PaymentTypeCode']}'
                             ) AS [Supper] ";

            $stmtByPayType = $conn->prepare($sqlByPayType);
            $stmtByPayType->execute();

            while ($resByPayType = $stmtByPayType->FETCH(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td><?= $resPayType['PaymentTypeName']; ?></td>
                    <td class="text-right"><?= $resPayType['Payment']; ?></td>
                    <td class="text-right"><?= $resPayType['Cover']; ?></td>
                    <td class="text-right"><?= $resByPayType['Breakfast']; ?></td>
                    <td class="text-right"><?= $resByPayType['Lunch']; ?></td>
                    <td class="text-right"><?= $resByPayType['Dinner']; ?></td>
                    <td class="text-right"><?= $resByPayType['Supper']; ?></td>
                    <td></td><td></td><td></td><td></td>
                </tr>

                <?php
                $payTotal += $resPayType['Payment'];
                $covTotal += $resPayType['Cover'];
                $bfTotal += $resByPayType['Breakfast'];
                $lunTotal += $resByPayType['Lunch'];
                $dinTotal += $resByPayType['Dinner'];
                $supTotal += $resByPayType['Supper'];
                ?>

            <?php } ?>

        <?php } ?>

        <tr>
            <td class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong><?= number_format($payTotal, 2) ?></td>
            <td class="text-right"><strong><?= number_format($covTotal, 2) ?></td>
            <td class="text-right"><strong><?= number_format($bfTotal, 2) ?></td>
            <td class="text-right"><strong><?= number_format($lunTotal, 2) ?></td>
            <td class="text-right"><strong><?= number_format($dinTotal, 2) ?></td>
            <td class="text-right"><strong><?= number_format($supTotal, 2) ?></td>
            <td></td><td></td><td></td><td></td>
        </tr>

        <?php $conn = NULL; ?>

    </tbody>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'CrossOutletNetRevenueReport_' + today;
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

