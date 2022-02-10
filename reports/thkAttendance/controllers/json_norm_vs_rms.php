<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $sql = "SELECT
            emp.HREMP_EMPCODE AS [EmpCode], emp.HREMP_FNAME +' '+ emp.HREMP_LNAME AS [EmpName], org.ASORG_ORGNAME AS [Dept], emp.HREMP_CURRENCY AS [Currency],
            (SELECT CAST(ISNULL(SUM(PRCALD_AMOUNT), 0) AS NUMERIC(10, 0)) FROM PSA66.dbo.PRCALD 
                    WHERE PRCALD_ITEMCODE IN('LATEMIN', 'EARLYMIN')  AND CONVERT(DATE, PRCALD_CALDATE) = '{$toDate}' AND PRCALD_EMPLOYEE = emp.HREMP_EMPID
            ) AS [NormTotalMin],
            (SELECT ISNULL(SUM(ABS(LateCheckIn)), 0) + ISNULL(SUM(ABS(EarlyCheckOut)), 0) 
                    FROM NORMEXT.dbo.RMSAttdCompleted  
                    WHERE WorkDay BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = emp.HREMP_EMPID
            ) AS [RmsTotalMin],
            (SELECT ISNULL(SUM(ABS(LateCheckIn)), 0) 
                    FROM NORMEXT.dbo.RMSAttdCompleted  
                    WHERE WorkDay BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = emp.HREMP_EMPID
            ) AS [LateMin],
            (SELECT ISNULL(SUM(ABS(EarlyCheckOut)), 0) 
                    FROM NORMEXT.dbo.RMSAttdCompleted 
                    WHERE WorkDay BETWEEN '{$fromDate}' AND '{$toDate}' AND EmpID = emp.HREMP_EMPID
            ) AS [EarlyMin]

            FROM PSA66.dbo.HREMP emp
            LEFT JOIN PSA66.dbo.EXEMPTED exem ON emp.HREMP_EMPID = exem.ExemID
            INNER JOIN PSA66.dbo.ASORG org ON emp.HREMP_ORG = org.ASORG_ORGID
            WHERE HREMP_STATUS = 1 AND exem.ExemStatus IS NULL ";

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


