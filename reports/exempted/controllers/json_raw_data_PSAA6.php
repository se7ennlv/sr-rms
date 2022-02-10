<?php

session_start();
include '../../../config/db.php';

try {
    $sql = "SELECT
                EXEMPTED.ExemID,
                HREMP.HREMP_FNAME +' '+ HREMP.HREMP_LNAME as HREMP_NAME,
                HRJOB.HRJOB_JOBNAME,
                ASORG.ASORG_ORGNAME,
                EXEMPTED.ExemTiker
                FROM
                EXEMPTED
                LEFT JOIN HREMP ON HREMP.HREMP_EMPCODE = EXEMPTED.ExemID
                LEFT JOIN HRJOB ON HRJOB.HRJOB_JOBID = HREMP.HREMP_JOBID
                LEFT JOIN ASORG ON HREMP.HREMP_ORG = ASORG.ASORG_ORGID
                WHERE EXEMPTED.ExemStatus ='1'
                ORDER BY ExemID ASC";
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

