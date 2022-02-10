<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['foDate'];
    $deptID = trim($_SESSION['deptID']);
    $deptCode = trim($_SESSION['deptCode']);
    $roleID = trim($_SESSION['roleID']);
    $orgCode = $_GET['orgCode'];

    if ($deptID == 1) {
        $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Department] IN('{$deptCode}', 'FRONT OFFICE')
            AND [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$fromDate}')
            AND Station = 'HR'
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
    }else if ($roleID == '1' || $roleID == '2') {
        if($orgCode == 'all'){
            $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}')
            AND Station = 'HR'
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
        } else {
            $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}')
            AND OrgCode = '{$orgCode}' AND Station = 'HR'
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
        }
    } else {
        $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}') 
            AND [Department] LIKE '{$deptCode}'
            AND Station = 'HR'
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
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


