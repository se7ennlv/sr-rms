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
    
    if ($deptID == '1') {
        $sql = "SELECT * FROM NORMEXT.[dbo].[SevenAttdComplete] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgCode IN('{$deptCode}', 'FRONT OFFICE') AND (ShiftCode NOT LIKE 'C%' OR LateCheckIn IS NOT NULL OR EarlyCheckOut IS NOT NULL) AND ExemStatus IS NULL";
    } else if ($roleID == '1' || $roleID == '2') {
        if($orgCode == 'all'){
            $sql = "SELECT * FROM NORMEXT.[dbo].[SevenAttdComplete] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND (ShiftCode NOT LIKE 'C%' OR LateCheckIn IS NOT NULL OR EarlyCheckOut IS NOT NULL) AND ExemStatus IS NULL";
        } else {
            $sql = "SELECT * FROM NORMEXT.[dbo].[SevenAttdComplete] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgCode = '{$orgCode}' AND (ShiftCode NOT LIKE 'C%' OR LateCheckIn IS NOT NULL OR EarlyCheckOut IS NOT NULL) AND ExemStatus IS NULL";
        }
    } else {
        $sql = "SELECT * FROM NORMEXT.[dbo].[SevenAttdComplete] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgCode = '{$deptCode}' AND (ShiftCode NOT LIKE 'C%' OR LateCheckIn IS NOT NULL OR EarlyCheckOut IS NOT NULL) AND ExemStatus IS NULL";
    }


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


