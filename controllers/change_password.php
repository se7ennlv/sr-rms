<?php

session_start();

include '../config/db.php';


try {
    $salt = 'tyidi3idkdislsoskdisli333lidk';
    $newPwd = hash_hmac('sha256', $_POST['newPwd'], $salt);

    
    $sql = "UPDATE [SRRMS].[dbo].[Users] SET [UserPassword]= '{$newPwd}', UserUpdatedAt = GETDATE() WHERE ([UserID]= {$_SESSION['uid']} ) ";
    $stmt =  $rms_connect->prepare($sql);
    $stmt->execute();

    header('Content-Type: application/json');
    $arr = 'Changed';
    echo json_encode(array(
        "status" => "success",
        "message" => $arr
    ));
} catch (PDOException $ex) {
    header('Content-Type: application/json');
    $error = 'Changed Password Fail'; //$ex->getMessage();
    echo json_encode(array(
        'status' => 'danger',
        'message' => $error
    ));
}

$rms_connect = NULL;
