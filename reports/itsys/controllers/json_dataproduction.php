<?php

session_start();
include '../config/db.php';

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqls = "SELECT * FROM [dbo].[Productions]";
    $stmte = $conn->prepare($sqls);
    $stmte->execute();
    $dataArray = array();
    while ($rows = $stmte->fetch(PDO::FETCH_ASSOC)) {
      $dataArray[] = $rows;
      } 
  
  $getdata_pro =  json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = NULL;

