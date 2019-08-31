<?php

session_start();
include '../../../config/db.php';

try {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $date = date("Y-m-d");
    $sql = "SELECT
    dbo.SpaSurveys.EmpName,
    dbo.Questions.QuesEnName,
    dbo.Questions.QuesThName,
    dbo.Rating.RateDesc,
    dbo.SpaSurveyDetails.Rating,
    dbo.SpaSurveyDetails.CreatedAt
    
    FROM
        dbo.SpaSurveys
        INNER JOIN dbo.SpaSurveyDetails ON dbo.SpaSurveys.DocNo = dbo.SpaSurveyDetails.DocNo
        INNER JOIN dbo.Locations ON dbo.SpaSurveyDetails.LocaID = dbo.Locations.LocaID
        INNER JOIN dbo.Departments ON dbo.SpaSurveyDetails.DeptID = dbo.Departments.DeptID
        INNER JOIN dbo.Questions ON dbo.SpaSurveyDetails.QuesID = dbo.Questions.QuesID
        INNER JOIN dbo.Rating ON dbo.SpaSurveyDetails.Rating = dbo.Rating.RateID
    WHERE dbo.SpaSurveyDetails.CreatedAt BETWEEN '{$fromDate}' AND '{$toDate}' ORDER BY dbo.SpaSurveyDetails.CreatedAt";
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
