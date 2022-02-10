<?php

session_start();
include '../../../config/db.php';

try {


    $empid = $_POST['ExemID'];
   $empid1 = $_POST['ExemID'];
 

    $sql = "UPDATE [NORMEXT].[dbo].tbl_exempted SET ExemStatus= '0' WHERE ExemID = '{$empid}'";
    $sql1 = "UPDATE [PSA66].[dbo].EXEMPTED SET ExemStatus= '0' WHERE ExemID= '{$empid1}' ";
  
   $stmt =  $norm_connect->prepare($sql);
   $stmt->execute();

    $stmt1 =  $psa_connect->prepare($sql1);
    $stmt1->execute();

    header('Content-Type: application/json');
    $arr = 'Delete Data Success';
    echo json_encode(array(
        "status" => "success",
        "message" => $arr
    ));
} catch (PDOException $ex) {
    header('Content-Type: application/json');
    $error = 'Delete data Fail'; //$ex->getMessage();
    echo json_encode(array(
        'status' => 'danger',
        'message' => $ex
        
    ));
}

$norm_connect = NULL;
$psa_connect = NULL;