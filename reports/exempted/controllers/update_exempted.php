<?php

session_start();
include '../../../config/db.php';

try {


    $empid = $_POST['ExemID'];
    $Exempted = $_POST['Exempted'];

    $empid1 = $_POST['ExemID'];
    $Exempted1 = $_POST['Exempted'];

    $sql = "UPDATE [NORMEXT].[dbo].[tbl_exempted] SET [ExemTiker]= '{$Exempted}' WHERE ([ExemID]= '{$empid}')";
    $sql1 = "UPDATE [PSA66].[dbo].[EXEMPTED] SET [ExemTiker]= '{$Exempted1}' WHERE ([ExemID]= '{$empid1}') ";
  


   $stmt =  $norm_connect->prepare($sql);
   $stmt->execute();

    $stmt1 =  $psa_connect->prepare($sql1);
    $stmt1->execute();

    header('Content-Type: application/json');
    $arr = 'Update Data Success';
    echo json_encode(array(
        "status" => "success",
        "message" => $arr
    ));
} catch (PDOException $ex) {
    header('Content-Type: application/json');
    $error = 'Update data Fail'; //$ex->getMessage();
    echo json_encode(array(
        'status' => 'danger',
        'message' => $error
    ));
}

$norm_connect = NULL;
 $psa_connect = NULL;