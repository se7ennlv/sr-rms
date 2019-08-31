<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $station = $_GET['station'];

    $sql = "SELECT * FROM [ZSAsscess].[dbo].[CanteenData]
            WHERE Station LIKE '{$station}' 
            AND [Datetime] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}')
            ORDER BY [Datetime], Department ASC ";
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


