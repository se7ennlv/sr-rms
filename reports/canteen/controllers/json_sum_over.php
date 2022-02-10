<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $station = $_GET['station'];

    $sql = "SELECT Station, EmpID, EmpName, OrgCode, [Date], COUNT(*) AS NumRows
            FROM RawData
            WHERE Station = '{$station}' AND [Date] BETWEEN CONVERT(DATE, '{$fromDate}') AND CONVERT(DATE, '{$toDate}')
            GROUP BY Station, EmpID, EmpName, OrgCode, [Date]
            HAVING COUNT(*) > 3 
            ORDER BY [Date]
            ";
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


