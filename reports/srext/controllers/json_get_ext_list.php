<?php

session_start();
include '../config/db.php';

try {
    $sql = "SELECT * FROM ExtensionNumbers INNER JOIN Departments ON ExtDeptID = DeptID WHERE ExtIsActive = 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = NULL;

