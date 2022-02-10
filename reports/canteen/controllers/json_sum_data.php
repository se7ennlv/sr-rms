<?php

session_start();
include '../../../config/db.php';

try {
    $sum = 0;
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $station = $_GET['station'];

    $sql = "SELECT Dept, Periods,  COUNT(EmpID) AS Total 
            FROM CanteenRawData
            WHERE Dates BETWEEN '{$fromDate}' AND '{$toDate}' AND Station = '{$station}'
            GROUP BY Dept, Periods
            ORDER BY Dept, Periods";
    $stmt = $fp_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$fp_connect = NULL;


