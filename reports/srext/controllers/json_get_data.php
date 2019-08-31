<?php
include '../config/db.php';

try {
    $extId = $_GET['extId'];

    $sql = "SELECT * FROM ExtensionNumbers WHERE ExtIsActive = 1 AND  ExtID = {$extId}";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($rs);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$conn = NULL;
