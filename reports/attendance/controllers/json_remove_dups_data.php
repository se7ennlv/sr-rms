<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $sql = "SELECT DISTINCT(dbo.FP_TRANSACTION.ID), dbo.FP_TRANSACTION.Department, dbo.FP_TRANSACTION.Name
            FROM   dbo.FP_TRANSACTION
            WHERE  dbo.FP_TRANSACTION.Datetime BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}') ";

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


