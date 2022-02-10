<?php

session_start();
include '../../../config/db.php';

try {
    $sql = "SELECT 
                HREMP_EMPCODE,
                HREMP_FNAME +' '+HREMP_LNAME AS [HREMP_NAME],
                ASORG_ORGNAME AS [HREMP_DEPT],
                HRJOB_JOBNAME AS [HREMP_POSITION],
                HREMP_ADDRH1 AS [HREMP_VILLAGE],
                HREMP_CITY AS [HREMP_CITY],
                HREMP_STATE AS [HREMP_PROVINCE]
            FROM [PSA66].[dbo].[HREMP]
            INNER JOIN ASORG ON HREMP_ORG = ASORG_ORGID
            INNER JOIN HRJOB ON HREMP_JOBID = HRJOB_JOBID
            WHERE [HREMP_STATUS] = '1' 
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


