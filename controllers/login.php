<?php
session_start();
header('Content-Type: application/json');

include '../config/db.php';

try {
    $salt = 'tyidi3idkdislsoskdisli333lidk';

    $usr = $_REQUEST['Username'];
    $pwd = hash_hmac('sha256', $_REQUEST['UserPassword'], $salt);

    $sql = "SELECT * 
            FROM Users
            INNER JOIN Roles ON UserRoleID = RoleID
            INNER JOIN Departments ON UserDeptID = DeptID
            WHERE UserUsername = ? AND UserPassword = ? AND UserIsActive = 1";

    $params = array($usr, $pwd);
    $stmt = $rms_connect->prepare($sql);
    $stmt->execute($params);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($result['UserUsername'])) {
        $_SESSION['valid_user'] = true;
        $_SESSION['uid'] = $result['UserID'];
        $_SESSION['username'] = $result['UserUsername'];
        $_SESSION['fname'] = $result['UserFname'];
        $_SESSION['lname'] = $result['UserLname'];
        $_SESSION['email'] = $result['UserEmail'];
        $_SESSION['deptID'] = $result['DeptID'];
        $_SESSION['deptCode'] = $result['DeptCode'];
        $_SESSION['deptCode'] = $result['DeptCode'];
        $_SESSION['deptName'] = $result['DeptName'];
        $_SESSION['roleID'] = $result['RoleID'];
        $_SESSION['roleName'] = $result['RoleName'];
        $_SESSION['createdAt'] = $result['UserCreatedAt'];
        $_SESSION['roleModules'] = $result['UserReportModules'];

        echo json_encode(array(
            "status" => "success",
            "message" => 'Login Success'
        ));
    } else {
        echo json_encode(array(
            'status' => 'danger',
            'message' => 'Username or password incorect'
        ));
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

$rms_connect = NULL;
