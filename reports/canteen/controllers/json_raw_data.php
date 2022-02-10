<?php
session_start();

include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $station = $_GET['station'];
    
    $sql = "SELECT * 
            FROM CanteenRawData
            WHERE Station LIKE '{$station}' 
            AND Dates BETWEEN '{$fromDate}' AND '{$toDate}'
            ORDER BY Dept, EmpID, Dates, Periods ASC";
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


