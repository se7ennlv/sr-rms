<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $orgCode = $_GET['orgCode'];
    
    if ($orgCode == 0) {
        $sql = "SELECT * FROM [ZSAsscess].[dbo].[RawDataForThakhek]
        WHERE WorkDate BETWEEN  CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate} ') AND LocationID = 1
        ORDER BY EmpID, WorkDate, CONVERT(TIME, [ScanTime]) ASC";
    } else if  ($orgCode == 1) {
        $sql = "SELECT * FROM [ZSAsscess].[dbo].[RawDataForThakhek]
        WHERE WorkDate BETWEEN  CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate} ') AND LocationID = 1
        ORDER BY EmpID, WorkDate, CONVERT(TIME, [ScanTime]) ASC";
    }





    $stmt = $psa_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$psa_connect = NULL;
