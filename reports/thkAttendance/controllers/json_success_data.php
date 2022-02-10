<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $deptID = trim($_SESSION['deptID']);
    $deptCode = trim($_SESSION['deptCode']);
    $roleID = trim($_SESSION['roleID']);
    $orgCode = $_GET['orgCode'];

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
