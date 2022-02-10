<?php

include '../../../config/db.php';

try {
    $org = $_GET['org'];
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $sql = "WITH LeaveExtract AS (
        SELECT 
        HREMP_EMPCODE AS EmpID, 
        HREMP_ORG AS OrgID,
        CONVERT(DATE, ATWKCALDEMP_WKDATE) AS RosterDate, 
        ATWKCALDEMP_SHIFTCODE AS RosterShiftCode,
        LVLEAVEBANK_LEAVECODE AS LeaveCode,
        CONVERT(DATE, LVLEAVEBANK_ACTDATE) AS LeaveActiveDate,
        LVLEAVEBANK_REQID AS LeaveNo
        FROM ATWKCALDEMP
        INNER JOIN HREMP ON ATWKCALDEMP_EMPID = HREMP_EMPCODE
        LEFT JOIN (
                    SELECT LVLEAVEBANK_EMPID, LVLEAVEBANK_ACTDATE, LVLEAVEBANK_REQID, LVLEAVEBANK_LEAVECODE
                    FROM LVLEAVEBANK 
                     WHERE LVLEAVEBANK_TYPE = 2 AND LVLEAVEBANK_INACTIVE = 0) AS Leave 
        ON CONVERT(DATE, ATWKCALDEMP_WKDATE) = CONVERT(DATE, LVLEAVEBANK_ACTDATE) AND HREMP_EMPID = LVLEAVEBANK_EMPID
        WHERE HREMP_ORG = {$org} AND CONVERT(DATE, ATWKCALDEMP_WKDATE) BETWEEN '{$fromDate}' AND '{$toDate}' AND (ATWKCALDEMP_SHIFTCODE NOT LIKE 'C%' AND ATWKCALDEMP_SHIFTCODE NOT LIKE 'DO' AND ATWKCALDEMP_SHIFTCODE NOT LIKE 'OS')
    )
    SELECT 
      HREMP_EMPCODE AS [EmpCode], 
      HREMP_FNAME +' '+HREMP_LNAME AS [EmpName],
      CONVERT(DATE, HREMP_HIREDAY) AS [Hireday],
      HRJOB_JOBNAME AS [Position],
      ASORG_ORGNAME AS [Dept],
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'AB' OR LeaveCode = 'AB')) AS AB,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'AL' OR LeaveCode = 'AL')) AS AL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'FL' OR LeaveCode = 'FL')) AS FL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'HL' OR LeaveCode = 'HL')) AS HL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'ML' OR LeaveCode = 'ML')) AS ML,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'NDL' OR LeaveCode = 'NDL')) AS NDL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'PH' OR LeaveCode = 'PH')) AS PH,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'PL' OR LeaveCode = 'PL')) AS PL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'SL' OR LeaveCode = 'SL')) AS SL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'SPL' OR LeaveCode = 'SPL')) AS SPL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'TL' OR LeaveCode = 'TL')) AS TL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'UL' OR LeaveCode = 'UL')) AS UL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'WL' OR LeaveCode = 'WL')) AS WL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'XL' OR LeaveCode = 'XL')) AS XL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'MSO' OR LeaveCode = 'MSO')) AS MSO,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'LWP' OR LeaveCode = 'LWP')) AS LWP,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'WOP' OR LeaveCode = 'WOP')) AS WOP,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND (RosterShiftCode = 'LDL' OR LeaveCode = 'LDL')) AS LDL,
        (SELECT COUNT(*) FROM LeaveExtract WHERE EmpID = HREMP_EMPCODE AND 
            (RosterShiftCode IN('AB','AL','FL','HL','ML','NDL','PH','PL','SL','SPL','TL','UL','WL','XL','MSO','LWP') 
            OR LeaveCode IN('AB','AL','FL','HL','ML','NDL','PH','PL','SL','SPL','TL','UL','WL','XL','MSO','LWP', 'WOP', 'LDL'))
        ) AS Total
    FROM HREMP
    INNER JOIN HRJOB ON HREMP_JOBID = HRJOB_JOBID
    INNER JOIN ASORG ON HREMP_ORG = ASORG_ORGID
    WHERE HREMP_STATUS = 1 AND HREMP_ORG = {$org}
    ORDER BY HREMP_EMPCODE ASC ";

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

