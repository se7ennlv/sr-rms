<?php

session_start();
include '../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $posID = $_GET['posID'];
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "WITH cte AS(
            SELECT TOP(100)PERCENT
            RowID = ROW_NUMBER() OVER(ORDER BY st.salesTranID), 
            ROW_NUMBER() OVER(ORDER BY st.salesTranID) AS [AliasID],
            st.salesTranID AS [TranID],
            sm.salesID AS [SaleID], 
            CONVERT(DATE, sm.voucherDate) AS [VoucherDate],
            sm.voucherNo AS [VoucherNo],
            sm.POSId AS [PosID],
            pos.posName AS [PosName],
            itemcate.itemCategoryID AS [ItemCateID],
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
            itemrate.itemCode AS [ItemCode],
            CAST(st.rate AS NUMERIC(10, 2)) AS [Price],
            CAST(st.quantity AS NUMERIC(10, 2)) AS [Qty], 
            unit.unitName AS [Unit],
            CAST(st.rate * st.quantity AS NUMERIC(10, 2)) AS [Amount],
            CAST(st.discAmount AS NUMERIC(10, 2)) AS [DiscAmt],
            CAST(st.taxAmount AS NUMERIC(10, 2)) AS [TaxAmt],
            CAST(st.itemAmount AS NUMERIC(10, 2)) AS [TotalSale],
            CAST(sm.totalDiscAmount AS NUMERIC(10, 2)) AS [Discount]
            FROM tSalesTran st
            LEFT JOIN mSalesMaster sm ON st.salesID = sm.salesID
            INNER JOIN mPOS pos ON sm.POSId = pos.posID
            INNER JOIN mItemGroupCategory itemcate ON st.itemGroupID = itemcate.groupID
            LEFT JOIN mItemGroup itemgrp ON st.itemGroupID = itemgrp.itemgroupID
            INNER JOIN mItem item ON st.itemID = item.itemID
            INNER JOIN mItemRate itemrate ON st.itemRateID = itemrate.itemRateId
            INNER JOIN mUnit unit ON st.unitID = unit.unitID
            WHERE sm.voucherDate BETWEEN '{$fromDate}' AND '{$toDate}' AND sm.POSId = {$posID}
            )
            SELECT TOP(100)PERCENT 
            cte.ItemCateName, cte.ItemCode, cte.ItemName, cte.Price, SUM(cte.Qty) AS [Qty], SUM(cte.Amount) AS [Amount]
            FROM cte
            LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1
            LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1
            GROUP BY cte.ItemCateID, cte.ItemCateName, cte.ItemCode, cte.ItemName, cte.Price
            ORDER BY cte.ItemCateID ASC ";

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

