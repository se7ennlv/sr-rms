<?php

session_start();
include '../../../config/db.php';

try {
    $date = date("Y-m-d");
    $strWhere = "";

    if (empty($_SESSION['UserLevelID'] == 1)) {
        $strWhere = "WHERE CONVERT(DATE, TranCreatedAt) LIKE '{$date}' ";
    } else {
        $strWhere = "WHERE CONVERT(DATE, TranCreatedAt) LIKE '{$date}' AND Transactions.DeptID = '{$_SESSION['DeptID']}'";
    }

    $sql = "SELECT Count(dbo.Transactions.TranID) AS countByType,
            dbo.Departments.DeptName,
            dbo.Locations.LocaName,
            dbo.Transactions.TranType
            FROM dbo.Transactions
            INNER JOIN dbo.Departments ON dbo.Transactions.DeptID = dbo.Departments.DeptID
            INNER JOIN dbo.Locations ON dbo.Transactions.LocaID = dbo.Locations.LocaID
            WHERE TranCreatedAt >= DATEADD(d, -7, GETDATE()) AND TranCreatedAt < GETDATE()
            GROUP BY dbo.Transactions.TranType, dbo.Departments.DeptName, dbo.Locations.LocaName
            ORDER BY Departments.DeptName, Locations.LocaName ASC";
    $stmt = $hon_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$hon_connect = NULL;

