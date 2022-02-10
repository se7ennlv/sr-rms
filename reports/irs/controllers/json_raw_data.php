<?php

session_start();
include '../../../config/db.php';

try {

    $sql ="SELECT a.ITEMNO,c.[desc] AS DESCREIPTION,a.LOCATION as DEPT,a.QTYONHAND,a.COSTUNIT from ICILOC a 
    INNER JOIN ICLOC b on a.LOCATION = b.LOCATION 
    INNER JOIN icitem c ON a.ITEMNO = c.itemno
    WHERE  a.LOCATION = 'IT'";

    $stmt = $irs_connect->prepare($sql);
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


