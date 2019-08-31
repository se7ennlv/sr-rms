<?php

session_start();
include '../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "WITH cte AS(
            SELECT TOP(100)PERCENT
            RowID = ROW_NUMBER() OVER(ORDER BY kot.kotID), 
            pos.posName AS [Outlet],
            kot.kotNo AS [KotNo], 
            kot.kotDateTime AS [KotDate], 
            item.itemName AS [ItemName], 
            CASE kot.serviceType
                    WHEN 1 THEN 'Dine-In'
                    WHEN 2 THEN 'Take Away'
                    WHEN 3 THEN 'Phone Order'
                    ELSE '--N/A--'
            END AS [ServiceType], 
            wter.waiterName AS [WaiterName], 
            tbl.tableName AS [Source], 
            dskuser.deskUserName AS [VoidedBy],
            kot.CancelASIPosDate AS [VoidedDate]
            FROM [dbo].[mKOT] kot
            LEFT JOIN mWaiter wter ON kot.waiterID = wter.waiterID
            LEFT JOIN tKOTTran ktran ON kot.kotID = ktran.kotID
            LEFT JOIN mItem item ON ktran.itemID = item.itemID
            INNER JOIN mDeskUserMaster dskuser ON kot.CancelByDeskUser = dskuser.deskUserID
            INNER JOIN mTable tbl ON kot.tableID = tbl.tableID
            INNER JOIN mPOS pos ON kot.posID = pos.posID
            WHERE (CONVERT(DATE, kot.kotDateTime) BETWEEN '{$fromDate}' AND '{$toDate}') AND kot.isBill = 0 AND kot.IsCancel = 1 
            )
            SELECT TOP(100)PERCENT
            CASE WHEN cte.Outlet = prev.Outlet THEN '' ELSE cte.Outlet END AS [Outlet],
            CASE WHEN cte.KotNo = prev.KotNo THEN '' ELSE cte.KotNo END AS [KotNo], 
            cte.KotDate, 
            cte.ServiceType, 
            cte.ItemName, 
            cte.WaiterName, 
            cte.Source, 
            cte.VoidedBy, 
            cte.VoidedDate
            FROM cte
            LEFT JOIN cte prev ON prev.RowID = cte.RowID - 1
            LEFT JOIN cte nex ON nex.RowID = cte.RowID + 1 ";

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

