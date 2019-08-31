<?php

include '../config/db.php';

try {
    $params = array(
        $_POST['ExtNumber'],
        $_POST['ExtDeptID'],
        $_POST['ExtLocation'],
        $_POST['ExtUsername'],
        $_POST['ExtIsActive'],
        $_POST['ExtID']
    );

    //echo '<pre>', print_r($_POST, TRUE), '<pre>';

    $sql = "UPDATE ExtensionNumbers 
            SET ExtNumber = ?,
                ExtDeptID = ?,
                ExtLocation = ?,
                ExtUsername = ?,
                ExtIsActive = ?
            WHERE ExtID = ?
            ";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    header('Content-Type: application/json');
    echo json_encode(array(
        "status" => "success",
        "message" => 'Success'
    ));
} catch (Exception $ex) {
    header('Content-Type: application/json');
    echo json_encode(array(
        'status' => 'danger',
        'message' => 'Error ' . die(print_r(sqlsrv_errors(), true))
    ));
}

$conn = null;
