<?php
header('Content-Type: application/json');

include '../config/session.php';
include '../config/db.php';

try {
    $params = array(
        $_GET['userId'],
        $_GET['rptName']
    );

    $rms_connect->beginTransaction();
    $sql = "INSERT INTO Logs (LogUserID, LogRptAccess, LogAccessTime) VALUES (?, ?, GETDATE() )";
    $stmt = $rms_connect->prepare($sql);
    $stmt->execute($params);
    $rms_connect->commit();

    echo json_encode(array(
        "status" => "success",
        "message" => 'Success'
    ));
} catch (PDOException $ex) {
    echo json_encode(array(
        "status" => "danger",
        "message" => 'Error'
    ));

    $rms_connect->rollBack();
}

$rms_connect = NULL;
