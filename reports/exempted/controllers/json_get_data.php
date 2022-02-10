<?php

session_start();
include '../../../config/db.php';

try {
   
    $ExemID = $_GET['ExemID'];

    $sql = "SELECT * FROM tbl_exempted WHERE ExemID = '{$ExemID}'";
    $stmt = $norm_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
     $dataArray[] = $row;
   }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$norm_connect = NULL;