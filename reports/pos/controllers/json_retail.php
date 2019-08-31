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
                (SELECT CAST(ISNULL(SUM(NetSale), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '$toDate' AND PosID = 2 AND ItemGroupID NOT IN(7, 8, 9, 14) AND VoucherNo = sm.voucherNo) AS [Retail],
                (SELECT CAST(ISNULL(SUM(NetSale), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '$toDate' AND PosID = 2 AND ItemGroupID = 7 AND VoucherNo = sm.voucherNo) AS [Beverage],
                (SELECT CAST(ISNULL(SUM(NetSale), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '$toDate' AND PosID = 2 AND ItemGroupID = 9 AND VoucherNo = sm.voucherNo) AS [Liqours],
                (SELECT CAST(ISNULL(SUM(NetSale), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '$toDate' AND PosID = 2 AND ItemGroupID = 14 AND VoucherNo = sm.voucherNo) AS [RefillCard],
                (SELECT CAST(ISNULL(SUM(NetSale), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '$toDate' AND PosID = 2 AND ItemGroupID = 8 AND VoucherNo = sm.voucherNo) AS [Tobacco],
                (SELECT CAST(ISNULL(SUM(NetSale), 0) AS NUMERIC(10, 2)) FROM [dbo].[SevenRawData] WHERE VoucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND PosID = 2 AND VoucherNo = sm.voucherNo) AS [SubTotal]
            FROM mSalesMaster sm
            LEFT JOIN tSalesPaymentTran spt ON sm.salesID = spt.salesID
            LEFT JOIN mPaymentType pt ON spt.payTypeID = pt.paymentTypeID
            WHERE POSId = 2 AND CONVERT(DATE, voucherDate) BETWEEN '{$fromDate}' AND '$toDate' 
            GROUP BY sm.salesID, sm.voucherNo, sm.voucherDate, pt.paymentTypeAlias, pt.paymentTypeName, sm.totalPaidAmount 
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

