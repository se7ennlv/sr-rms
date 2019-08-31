<?php

session_start();
include '../../../config/db.php';

try {
    $sql = "SELECT *
            FROM VIEW_ProbationWarning
            WHERE 
                Period15Days IS NOT NULL OR
                Period10Days IS NOT NULL OR
                Period3Days IS NOT NULL OR
                JobTranPeriod15Days IS NOT NULL OR
                JobTranPeriod10Days IS NOT NULL OR
                JobTranPeriod3Days IS NOT NULL 
            ORDER BY EmpCode ASC
            ";

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


