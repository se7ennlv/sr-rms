<?php

session_start();
include '../../../config/db.php';

try {
   

    $sql = "SELECT 
                tbl_exempted.ExemID,
                PSA66.dbo.HREMP.HREMP_FNAME +' '+PSA66.dbo.HREMP.HREMP_LNAME as HREMP_NAME,
                PSA66.dbo.HRJOB.HRJOB_JOBNAME,
                PSA66.dbo.ASORG.ASORG_ORGNAME,
                tbl_exempted.ExemTiker
                FROM tbl_exempted
                LEFT JOIN PSA66.dbo.HREMP ON PSA66.dbo.HREMP.HREMP_EMPCODE = tbl_exempted.ExemID
                LEFT JOIN PSA66.dbo.HRJOB ON PSA66.dbo.HRJOB.HRJOB_JOBID = PSA66.dbo.HREMP.HREMP_JOBID
                LEFT JOIN PSA66.dbo.ASORG ON PSA66.dbo.HREMP.HREMP_ORG = PSA66.dbo.ASORG.ASORG_ORGID
                WHERE tbl_exempted.ExemStatus ='1'
                ORDER BY  tbl_exempted.ExemID ASC";
    $stmt = $norm_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$norm_connect = NULL;

