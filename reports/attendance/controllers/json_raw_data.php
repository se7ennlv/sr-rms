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
    
    if ($deptID == 21) {
        $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE OrgID IN(5, 12, 37)
            AND [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$fromDate}')
            AND (Station LIKE 'SAVSEC%' OR Station LIKE '%Welcome%') AND LocationID = 0
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
    }else if ($deptID == 1) {
        $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE OrgCode IN('ADMIN', 'FO')
            AND [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$fromDate}')
            AND (Station LIKE 'SAVSEC%' OR Station LIKE '%Welcome%') AND LocationID = 0
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
    }else if ($roleID == '1' || $roleID == '2') {
        if($orgCode == 'all'){
            $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}')
            AND (Station LIKE 'SAVSEC%' OR Station LIKE '%Welcome%') AND LocationID = 0
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
        } else {
            $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}')
            AND OrgCode = '{$orgCode}' AND (Station LIKE 'SAVSEC%' OR Station LIKE '%Welcome%') AND LocationID = 0
            ORDER BY EmpID, [Date], CONVERT(TIME, [Time]) ASC ";
        }
    } else {
        $orgCode = trim($_SESSION['deptCode']);
        
        $sql = "SELECT *
            FROM [ZSAsscess].[dbo].[RawData]
            WHERE [Date] BETWEEN CONVERT(DATE,'{$fromDate}')  AND CONVERT(DATE,'{$toDate}') 
            AND OrgCode = '{$orgCode}'
            AND (Station LIKE 'SAVSEC%' OR Station LIKE '%Welcome%') AND LocationID = 0
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


