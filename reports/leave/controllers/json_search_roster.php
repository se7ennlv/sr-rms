<?php

include '../../../config/db.php';

try {
    $leaveCode = $_GET['leaveCode'];
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $sql = "SELECT 
            CONVERT(DATE, ATWKCALDEMP_WKDATE) AS [WkDate], 
            ATWKCALDEMP_EMPID AS [EmpID],
            ATWKCALDEMP_SHIFTCODE AS [ShiftCode]
            FROM ATWKCALDEMP
            INNER JOIN HREMP ON ATWKCALDEMP_EMPID = HREMP_EMPCODE
            WHERE CONVERT(DATE, ATWKCALDEMP_WKDATE) BETWEEN '{$fromDate}' AND '{$toDate}' AND ATWKCALDEMP_SHIFTCODE = '{$leaveCode}' AND HREMP_STATUS = 1 ";

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

