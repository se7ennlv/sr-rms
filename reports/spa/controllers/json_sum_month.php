<?php

session_start();
include '../../../config/db.php';

try {
    $sql = "SELECT
    dept.DeptName,
     SUM (survey.Rating) AS Rating,
     COUNT (*) AS NoOfScorer,
     loca.LocaName AS Location,
     q.QuesEnName + '' + q.QuesThName AS Questions,
     CAST (
         CAST (
             SUM (survey.Rating) AS DECIMAL
         ) / CAST (COUNT(*) AS DECIMAL) AS DECIMAL (18, 2)
     ) AS [AvgScore],
     REPLACE(
         CAST (
             CAST (
                 CAST (
                     SUM (survey.Rating) AS DECIMAL
                 ) / CAST (COUNT(*) AS DECIMAL) AS DECIMAL (18, 2)
             ) / 5 AS DECIMAL (18, 2)
         ),
         '.',
         ''
     ) + '' + '%' AS [AVG]
 
 FROM
     SpaSurveyDetails survey
 INNER JOIN Departments dept ON survey.DeptID = dept.DeptID
 INNER JOIN Locations loca ON survey.LocaID = loca.LocaID
 INNER JOIN Questions q ON survey.QuesID = q.QuesID
 WHERE
     (
         survey.CreatedAt >= DATEADD(D, - 30, GETDATE())
         AND CreatedAt < GETDATE()
     )
 GROUP BY
     dept.DeptName,
     loca.LocaName,
     q.QuesEnName,
     q.QuesThName,
     q.QuesID
 ORDER BY
     q.QuesID ASC";
    $stmt = $hon_connect->prepare($sql);
    $stmt->execute();

    $dataArray = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo json_encode($dataArray);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$hon_connect = NULL;