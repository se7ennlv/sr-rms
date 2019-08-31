<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $sql = "SELECT TranDate, COUNT(*) AS [Total]
            FROM SRQTransactions
            WHERE TranDate BETWEEN '{$fromDate}' AND '{$toDate}'
            GROUP BY TranDate
            ORDER BY TranDate ASC";
    $stmt = $srut_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$srut_connect = NULL;

