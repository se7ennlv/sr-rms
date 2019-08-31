<?php

session_start();
include '../../../config/db.php';

try {
    $sum = 0;
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $station = $_GET['station'];

    $sql = "SELECT COUNT(*) AS countRows, Department,Period_Title
            FROM [ZSAsscess].[dbo].[brakeData]
            WHERE Station LIKE '{$station}' 
            AND [Datetime] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}')
            GROUP BY Period_Title, Department
             ORDER BY Period_Title DESC " ;
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


