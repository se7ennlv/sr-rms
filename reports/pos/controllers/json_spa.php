<?php

session_start();
include '../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT 
                CONVERT(VARCHAR, sm.voucherNo) +' | '+ CONVERT(varchar, CONVERT(DATE, sm.voucherDate)) AS [CheckNo],
                sm.salesID,
                sm.voucherNo AS [VoucherNo],
                CONVERT(DATE, sm.voucherDate) AS [VoucherDate], 
                pt.paymentTypeAlias AS [PayTypeCode],
                pt.paymentTypeName AS [PayTypeName],
                CAST(sm.totalPaidAmount AS NUMERIC(10, 2)) AS [PaymentAmount],
                sm.noOfperson AS [Cover],
                (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = 1 AND ItemGroupID = 90 AND VoucherNo = sm.voucherNo ) AS [Spa],
                (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = 1 AND ItemGroupID = 4 AND VoucherNo = sm.voucherNo ) AS [Massage],
                (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = 1 AND ItemGroupID = 3 AND VoucherNo = sm.voucherNo ) AS [Facial],
                (SELECT CAST(ISNULL(SUM(Amount), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = 1 AND ItemGroupID NOT IN(3, 4, 90) AND VoucherNo = sm.voucherNo ) AS [Other],
                CAST(sm.totalTaxAmount AS NUMERIC(10, 2)) AS [TaxTotal],
                CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [DiscTotal]
            FROM mSalesMaster sm
            LEFT JOIN tSalesPaymentTran spt ON sm.salesID = spt.salesID
            LEFT JOIN mPaymentType pt ON spt.payTypeID = pt.paymentTypeID
            WHERE sm.POSId = 1 AND CONVERT(DATE, sm.voucherDate) BETWEEN '{$fromDate}' AND '{$toDate}' 
            GROUP BY sm.salesID, sm.voucherNo, sm.voucherDate, pt.paymentTypeAlias, pt.paymentTypeName, sm.totalPaidAmount, sm.noOfperson, sm.totalTaxAmount, sm.totalDiscAmount
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

