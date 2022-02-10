<?php

session_start();
include '../config/db.php';

try {
    $logDate = $_GET['logDate'];
    
    $sql = "SELECT
    dbo.Logs.LogID,
    dbo.Logs.LogUserID,
    dbo.Users.UserID,
    dbo.Users.UserEmpID,
    dbo.Users.UserFname + ' ' + dbo.Users.UserLname AS EmpFullName,
    dbo.Roles.RoleName,
    dbo.Departments.DeptName,
    dbo.Logs.LogAccessTime,
    dbo.Logs.LogRptAccess,
    dbo.ReportGroups.RGroupDesc
    FROM
        [SRRMS].[dbo].[Logs]
    INNER JOIN dbo.Users ON dbo.Logs.LogUserID = dbo.Users.UserID
    INNER JOIN dbo.Roles ON dbo.Users.UserRoleID = dbo.Roles.RoleID
    INNER JOIN dbo.Departments ON dbo.Users.UserDeptID = dbo.Departments.DeptID
    INNER JOIN dbo.ReportGroups ON dbo.Logs.LogRptAccess = dbo.ReportGroups.RGroupID
    WHERE
        CONVERT (DATE, LogAccessTime) = '{$logDate}'
    ORDER BY
        Logs.LogID DESC";

    $stmt = $rms_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$rms_connect = NULL;
