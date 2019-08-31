<?php

session_start();
include '../config/db.php';

try {
    $posID = 0;

    if (isset($_GET['posID'])) {
        $posID = $_GET['posID'];
    }

    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];


    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT 
            CONVERT(VARCHAR, sm.voucherNo) +' | '+ CONVERT(varchar, CONVERT(DATE, sm.voucherDate)) AS [CheckNo],
            sm.salesID,
            sm.voucherNo AS [VoucherNo],
            CONVERT(DATE, sm.voucherDate) AS [VoucherDate], 
            CASE
		WHEN spt.payTypeID IS NULL AND spt.roomID IS NULL THEN 
                    CONVERT(VARCHAR, bs.businessSourceName)
		WHEN spt.payTypeID IS NULL AND spt.creditorID IS NULL THEN 
                    CONVERT(VARCHAR, spt.roomID)
		ELSE 
                    CONVERT(VARCHAR, pmt.paymentTypeAlias)
		END AS [PaymentTypeCode],
            CASE
		WHEN spt.payTypeID IS NULL AND spt.roomID IS NULL THEN 
                    CONVERT(VARCHAR, bs.businessSourceName)
		WHEN spt.payTypeID IS NULL AND spt.creditorID IS NULL THEN 
                    CONVERT(VARCHAR, spt.roomID)
		ELSE 
                    CONVERT(VARCHAR, pmt.paymentTypeName)
            END AS [PaymentTypeName],
            CAST(sm.totalPaidAmount AS NUMERIC(10, 2)) AS [PaymentAmount],
            sm.noOfperson AS [Cover],
            (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = {$posID} AND ItemCateID = 1 AND VoucherNo = sm.voucherNo ) AS [FoodALA],
            (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = {$posID} AND ItemCateID = 2 AND VoucherNo = sm.voucherNo ) AS [FoodBUF],
            (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = {$posID} AND ItemCateID = 3 AND VoucherNo = sm.voucherNo ) AS [Beverage],
            (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = {$posID} AND ItemCateID = 4 AND VoucherNo = sm.voucherNo ) AS [Tobacco],								
            (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = {$posID} AND ItemCateID = 16 AND VoucherNo = sm.voucherNo ) AS [TobaccoRetail],
            CAST(sm.totalTaxAmount AS NUMERIC(10, 2)) AS [Tax],
            CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [Discount]
            FROM mSalesMaster sm
            LEFT JOIN (SELECT * FROM tSalesPaymentTran WHERE amountPaid > 0 AND CONVERT(DATE, paymentDate) BETWEEN '{$fromDate}' AND '{$toDate}'
            UNION ALL
            SELECT * FROM tSalesPaymentTran WHERE amountPaid = 0 AND CONVERT(DATE, paymentDate) BETWEEN '{$fromDate}' AND '{$toDate}' AND salesID NOT IN(SELECT salesID FROM tSalesPaymentTran WHERE amountPaid > 0 AND CONVERT(DATE, paymentDate) BETWEEN '{$fromDate}' AND '{$toDate}')) spt ON sm.salesID = spt.salesID
            LEFT JOIN mPaymentType pmt ON spt.payTypeID = pmt.paymentTypeID
            LEFT JOIN [172.16.98.16\ASI2008].[ASIFD600].[dbo].[cBusinessSource] bs ON bs.businessSourceID = spt.creditorID
            WHERE sm.POSId = {$posID} AND CONVERT(DATE, sm.voucherDate) BETWEEN '{$fromDate}' AND '{$toDate}' 
            GROUP BY sm.salesID, sm.voucherNo, sm.voucherDate, spt.payTypeID, spt.creditorID, spt.roomID, sm.totalPaidAmount, sm.noOfperson, sm.totalTaxAmount, sm.totalDiscAmount, pmt.paymentTypeAlias, pmt.paymentTypeName, bs.businessSourceName
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
