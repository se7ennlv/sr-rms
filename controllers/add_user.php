<?php

session_start();

include '../config/db.php';

try {
    $salt = 'tyidi3idkdislsoskdisli333lidk';

    $params = array(
        $_POST['Username'],
        hash_hmac('sha256', $_POST['UserPwd'], $salt),
        $_POST['EmpID'],
        $_POST['EmpFname'],
        $_POST['EmpLname'],
        $_POST['EmpEmail'],
        $_POST['DeptID'],
        $_POST['UserLevelID'],
        $_POST['menu'],
        $_POST['group']
    );

    $rms_connect->beginTransaction();
    $sql = "INSERT INTO [SRRMS].[dbo].[Users] (
                                                [UserUsername], 
                                                [UserPassword], 
                                                [UserEmpID], 
                                                [UserFname], 
                                                [UserLname], 
                                                [UserEmail], 
                                                [UserDeptID], 
                                                [UserIsActive], 
                                                [UserRoleID], 
                                                [UserCreatedAt],
                                                [UserReportGroups],
                                                [UserReportModules])
                                    VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, GETDATE(),?,?)";
    $stmt = $rms_connect->prepare($sql);
    $stmt->execute($params);
    $rms_connect->commit();

    header('Content-Type: application/json');
    $arr = "Add User Success";
    echo json_encode(array(
        "status" => "success",
        "message" => $arr
    ));
} catch (PDOException $ex) {
    header('Content-Type: application/json');
    $arr = "Add User Fail "; //$ex->getMessage();
    echo json_encode(array(
        "status" => "danger",
        "message" => $arr
    ));
    $rms_connect->rollBack();
}

$rms_connect = NULL;
