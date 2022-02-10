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
        $sql = "SELECT * FROM NORMEXT.[dbo].[RMSAttdCompleted] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgCode IN('{$deptCode}', 'FRONT OFFICE') AND ([FpIn] = 'Y' AND [FpOut] = 'Y' AND [LateCheckIn] IS NULL AND [EarlyCheckOut] IS NULL) AND ExemStatus IS NULL";
    } else if ($deptID == 21) {
        $sql = "SELECT * FROM NORMEXT.[dbo].[RMSAttdCompleted] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgID IN(5, 12, 37) AND ShiftCode LIKE 'C%' AND ([FpIn] = 'Y' AND [FpOut] = 'Y' AND [LateCheckIn] IS NULL AND [EarlyCheckOut] IS NULL) AND ExemStatus IS NULL";
    } else if ($userLevelId == '1' || $roleID == '2') {
        if ($orgCode == 'all') {
            $sql = "SELECT * FROM NORMEXT.[dbo].[RMSAttdCompleted] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND ([FpIn] = 'Y' AND [FpOut] = 'Y' AND [LateCheckIn] IS NULL AND [EarlyCheckOut] IS NULL) AND ExemStatus IS NULL";
        } else {
            $sql = "SELECT * FROM NORMEXT.[dbo].[RMSAttdCompleted] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgCode = '{$orgCode}' AND ([FpIn] = 'Y' AND [FpOut] = 'Y' AND [LateCheckIn] IS NULL AND [EarlyCheckOut] IS NULL) AND ExemStatus IS NULL";
        }
    } else {
        $sql = "SELECT * FROM NORMEXT.[dbo].[RMSAttdCompleted] WHERE ([WorkDay] BETWEEN CONVERT(DATE,'{$fromDate}') AND CONVERT(DATE,'{$toDate}')) AND OrgCode = '{$deptCode}' AND ShiftCode LIKE 'C%' AND ([FpIn] = 'Y' AND [FpOut] = 'Y' AND [LateCheckIn] IS NULL AND [EarlyCheckOut] IS NULL) AND ExemStatus IS NULL";
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
