<?php

include '../../../config/db.php';

try {
    $empid1 = $_POST['ExemID'];
    $Exempted1 = $_POST['Exempted'];

    $empid = $_POST['ExemID'];
    $Exempted = $_POST['Exempted'];

    $sql1 = "INSERT INTO [PSA66].[dbo].[EXEMPTED] ([ExemID], [ExemTiker]) VALUES ('{$empid1}', '{$Exempted1}')";
    $sql = "INSERT INTO [NORMEXT].[dbo].[tbl_exempted] ([ExemID], [ExemTiker]) VALUES ('{$empid}', '{$Exempted}')";
    
    $stmt1 = $psa_connect->prepare($sql1);
    $stmt1->execute();

    $stmt = $norm_connect->prepare($sql);
    $stmt->execute();
    
    header('Content-Type: application/json');
    echo json_encode(array(
        "status" => "success",
        "message" => 'Inserted'
    ));
} catch (PDOException $ex) {
    header('Content-Type: application/json');
    echo json_encode(array(
        "status" => "danger",
        "message" => "Fail " . $ex->getMessage()
    ));
    $psa_connect->rollBack();
    $norm_connect->rollBack();
}
$psa_connect = null;
$norm_connect =null;
