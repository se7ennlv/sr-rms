<?php

session_start();
include '../config/db.php';

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM [dbo].[ITSoftware]";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dataArrays = array();
    while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $dataArrays[] = $rs;
      } 
  
  $getdata_soft =  json_encode($dataArrays);

  
} catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = NULL;

