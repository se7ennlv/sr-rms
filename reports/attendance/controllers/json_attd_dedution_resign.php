<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET[ 'fromDate' ];
    $toDate = $_GET[ 'toDate' ];

    $sql = "WITH cte AS (SELECT TOP(100)PERCENT 
            attd.WorkDay,
            attd.EmpID,
            attd.EmpCode,
            attd.EmpName,
            attd.[Position],
            attd.OrgCode,
            attd.Department,
            attd.ShiftCode,
            attd.ShiftStart,
            attd.ShiftEnd,
            attd.FirstCheckIn,
            attd.LastCheckOut,
            emp.HREMP_STATUS AS [EmpStatus],
            CASE WHEN attd.LateCheckIn IS NULL THEN 0 ELSE abs(attd.LateCheckIn) END AS [LateCheckIn],
            CASE WHEN attd.EarlyCheckOut IS NULL THEN 0 ELSE abs(attd.EarlyCheckOut) END AS [EarlyCheckOut],
            CASE WHEN attd.ShiftCode = 'AB' THEN 1 ELSE 0 END AS [AbsentDay],
            attd.FpIn,
            attd.FpOut,
            emp.HREMP_SALARY AS [Salary],
            emp.HREMP_CURRENCY AS [Currency]
            FROM NORMEXT.dbo.SevenAttdComplete attd
            INNER JOIN PSA66.dbo.HREMP emp ON rtrim(attd.EmpCode) = RTRIM(emp.HREMP_EMPCODE)
            WHERE (attd.ShiftCode LIKE 'C%' OR attd.ShiftCode = 'AB') AND attd.EmpID NOT IN (SELECT ExemID FROM NORMEXT.dbo.tbl_exempted) 
            )
            SELECT TOP(100) PERCENT cte.*,
            CAST(cte.Salary * (cte.LateCheckIn + cte.EarlyCheckOut) / 14400 AS MONEY) AS [Deduction],
            CAST(CASE WHEN cte.Currency = 'KIP' THEN cte.Salary * (cte.LateCheckIn + cte.EarlyCheckOut) / 14400 ELSE 0 END AS MONEY) AS [KIP],
            CAST(CASE WHEN cte.Currency = 'THB' THEN cte.Salary * (cte.LateCheckIn + cte.EarlyCheckOut) / 14400 ELSE 0 END AS MONEY) AS [THB],
            CAST(CASE WHEN cte.Currency = 'USD' THEN cte.Salary * (cte.LateCheckIn + cte.EarlyCheckOut) / 14400 ELSE 0 END AS MONEY) AS [USD]
            FROM cte
            WHERE (cte.WorkDay BETWEEN '{$fromDate}' AND '{$toDate}') AND cte.ShiftCode LIKE 'C%' AND (cte.LateCheckIn + cte.EarlyCheckOut) > 0 ";

    $stmt = $psa_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch ( PDOException $e ) {
    echo $e->getMessage();
}

$psa_connect = NULL;


