<?php

session_start();
include '../../../config/db.php';

try {
    $date = date("Y-m-d");
    $sql = "SELECT * FROM dbo.Transactions
            INNER JOIN dbo.Departments ON dbo.Transactions.DeptID = dbo.Departments.DeptID
            INNER JOIN dbo.Locations ON dbo.Transactions.LocaID = dbo.Locations.LocaID
            WHERE TranCreatedAt >= DATEADD(d, -7, GETDATE()) AND TranCreatedAt < GETDATE()
            ORDER BY tranID DESC ";
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

