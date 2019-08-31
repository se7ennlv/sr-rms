<?php

session_start();
include '../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $posID = $_GET['posID'];

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "WITH cte AS (
            SELECT TOP (100) PERCENT RowID = ROW_NUMBER () OVER (ORDER BY st.salesTranID),
            CONVERT(DATE, sm.voucherDate) AS [VoucherDate],
            CASE itemcate.itemCategoryID
              WHEN 0 THEN 'No Name'
              WHEN 1 THEN 'Food-ALA'
              WHEN 2 THEN 'Food-BUF'
              WHEN 3 THEN 'Beverage'
              WHEN 4 THEN 'Tobacco'
              WHEN 5 THEN 'Other'
              WHEN 6 THEN 'Spa'
              WHEN 7 THEN 'Spa-Massage'
              WHEN 8 THEN 'Spa-Facial'
              WHEN 9 THEN 'Spa-Consignment'
              WHEN 10 THEN 'Spa-Other'
              WHEN 11 THEN 'Retail'
              WHEN 12 THEN 'Retail-Liquors'
              WHEN 13 THEN 'Retail-Logo Item'
              WHEN 14 THEN 'Retail-Refill Card'
              WHEN 15 THEN 'Retail-Mobile SIM'
              WHEN 16 THEN 'Retail-Tobacco'
              WHEN 17 THEN 'Retail-Consignment'
              WHEN 18 THEN 'Retail-Other'
            ELSE NULL
            END AS [ItemCateName],
            item.itemName AS [ItemName],
            sm.voucherNo AS [VoucherNo],
            CAST(st.rate AS NUMERIC(10, 2)) AS [Price],
            CAST(st.quantity AS NUMERIC(10, 2)) AS [Qty],
            CAST(st.rate * st.quantity AS NUMERIC(10, 2)) AS [Amount],
            CASE WHEN spt.payTypeID IN(1, 36, 37) THEN CAST(sm.totalTaxAmount AS NUMERIC(10, 2)) ELSE 0 END AS [TotalTax],
            CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [TotalDiscount],
            CAST(sm.totalPaidAmount AS NUMERIC(10, 2)) AS [TotalPayment],
            CAST(st.discAmount AS NUMERIC(10, 2)) AS [DiscAmt],
            CAST(st.taxAmount AS NUMERIC(10, 2)) AS [TaxAmt],
            CAST(st.itemAmount AS NUMERIC(10, 2)) AS [ItemSales],
            CASE 
                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '04:00:01' AND '11:00:00' THEN '1'
                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '11:00:01' AND '15:30:00' THEN '2'
                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '15:30:01' AND '21:30:00' THEN '3'
                ELSE '4'
            END AS [PeriodID],
            CASE 
                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '04:00:01' AND '11:00:00' THEN 'Breakfast'
                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '11:00:01' AND '15:30:00' THEN 'Lunch'
                WHEN CAST(spt.paymentDate AS TIME) BETWEEN '15:30:01' AND '21:30:00' THEN 'Dinner'
                ELSE 'Supper'
            END AS [PeriodName],
            sm.noOfPerson AS [Cover]      
            FROM tSalesTran st
            LEFT JOIN mSalesMaster sm ON st.salesID = sm.salesID
            INNER JOIN mPOS pos ON sm.POSId = pos.posID
            INNER JOIN mItemGroupCategory itemcate ON st.itemGroupID = itemcate.groupID
            INNER JOIN mItem item ON st.itemID = item.itemID
            LEFT JOIN tSalesPaymentTran spt ON st.salesID = spt.salesID
            WHERE sm.VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND sm.PosID = {$posID}
            ) 

            SELECT TOP(100) PERCENT 
            CASE WHEN cte.VoucherNo = prev.VoucherNo THEN '' ELSE CONVERT(VARCHAR, cte.VoucherNo) +' | '+CONVERT(VARCHAR, cte.VoucherDate) END AS [BillNo],
            cte.ItemCateName, 
            cte.ItemName, 
            CONVERT(VARCHAR, cte.Price) AS [Price], 
            cte.Qty, 
            cte.Amount, 
            cte.TaxAmt,
            cte.DiscAmt, 
            cte.ItemSales, 
            CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalTax END AS [TotalTax], 
            CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalDiscount END AS [TotalDiscount],
            CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalPayment END AS [TotalPayment]

            FROM cte
            LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1
            LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1

            UNION ALL

            SELECT
            '', '', '', 
            cte.PeriodName, 
            SUM(cte.Qty), 
            SUM(cte.Amount),
            SUM(cte.DiscAmt), 
            SUM(cte.TaxAmt), 
            SUM(cte.ItemSales), 
            SUM(CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalTax END), 
            SUM(CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalDiscount END),
            SUM(CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalPayment END)

            FROM cte 
            LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1
            LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
            GROUP BY cte.PeriodName

            UNION ALL

            SELECT
            '', '', '', 
            'Grand Total', 
            SUM(cte.Qty), 
            SUM(cte.Amount), 
            SUM(cte.DiscAmt), 
            SUM(cte.TaxAmt), 
            SUM(cte.ItemSales), 
            SUM(CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalTax END), 
            SUM(CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalDiscount END),
            SUM(CASE WHEN cte.VoucherNo = prev.VoucherNo THEN 0 ELSE cte.TotalPayment END)

            FROM cte
            LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1
            LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1 
        ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$conn = NULL;

