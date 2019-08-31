<?php
header('Content-Type: application/json');

include '../config/db.php';

try {
    $uid = $_POST['userId'];
    $rptName = $_POST['rptName'];

    $sql = "SELECT UserReportGroups FROM Users WHERE UserID = '{$uid}' ";
    $stmt = $rms_connect->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchColumn();

    echo json_encode(array(
        "status" => "success",
        "message" => $res
    ));
} catch (PDOException $ex) {
    echo json_encode(array(
        'status' => 'danger',
        'message' => 'Error'
    ));
}

$conn = NULL;
