<?php

session_start();
include '../../../config/db.php';


try {
    // $fromDate = $_POST['fromDate']; 
    // $toDate = $_POST['toDate']; 

    // echo $fromDate;
    // echo $toDate;

    $date = date("Y-m-d");
    $sql = "SELECT
    dbo.SpaSurveys.EmpName,
    Count(dbo.SpaSurveyDetails.Rating) AS RatingStar,
    dbo.Rating.RateDesc
    FROM
    dbo.SpaSurveys
    INNER JOIN dbo.SpaSurveyDetails ON dbo.SpaSurveys.DocNo = dbo.SpaSurveyDetails.DocNo
    INNER JOIN dbo.Locations ON dbo.SpaSurveyDetails.LocaID = dbo.Locations.LocaID
    INNER JOIN dbo.Departments ON dbo.SpaSurveyDetails.DeptID = dbo.Departments.DeptID
    INNER JOIN dbo.Questions ON dbo.SpaSurveyDetails.QuesID = dbo.Questions.QuesID
    INNER JOIN dbo.Rating ON dbo.SpaSurveyDetails.Rating = dbo.Rating.RateID
    WHERE (SpaSurveyDetails.CreatedAt >= DATEADD(D, -7, GETDATE()) AND SpaSurveyDetails.CreatedAt < GETDATE()) 
    GROUP BY EmpName,DeptName,RateDesc";

    $sql1 = "SELECT
    DISTINCT(dbo.SpaSurveys.EmpName) 
    FROM
    dbo.SpaSurveys
    INNER JOIN dbo.SpaSurveyDetails ON dbo.SpaSurveys.DocNo = dbo.SpaSurveyDetails.DocNo
    INNER JOIN dbo.Locations ON dbo.SpaSurveyDetails.LocaID = dbo.Locations.LocaID
    INNER JOIN dbo.Departments ON dbo.SpaSurveyDetails.DeptID = dbo.Departments.DeptID
    INNER JOIN dbo.Questions ON dbo.SpaSurveyDetails.QuesID = dbo.Questions.QuesID
    INNER JOIN dbo.Rating ON dbo.SpaSurveyDetails.Rating = dbo.Rating.RateID
    WHERE (SpaSurveyDetails.CreatedAt >= DATEADD(D, -7, GETDATE()) AND SpaSurveyDetails.CreatedAt < GETDATE()) 
    GROUP BY EmpName,DeptName,RateDesc ";

    $sql2 = "SELECT
    dbo.SpaSurveys.EmpName,
    Count(dbo.SpaSurveyDetails.Rating) AS RatingStar
    
    FROM
    dbo.SpaSurveys
    INNER JOIN dbo.SpaSurveyDetails ON dbo.SpaSurveys.DocNo = dbo.SpaSurveyDetails.DocNo
    INNER JOIN dbo.Locations ON dbo.SpaSurveyDetails.LocaID = dbo.Locations.LocaID
    INNER JOIN dbo.Departments ON dbo.SpaSurveyDetails.DeptID = dbo.Departments.DeptID
    INNER JOIN dbo.Questions ON dbo.SpaSurveyDetails.QuesID = dbo.Questions.QuesID
    INNER JOIN dbo.Rating ON dbo.SpaSurveyDetails.Rating = dbo.Rating.RateID
    WHERE (SpaSurveyDetails.CreatedAt >= DATEADD(D, -7, GETDATE()) AND SpaSurveyDetails.CreatedAt < GETDATE()) 
    GROUP BY EmpName,DeptName";

    $sql3 = "SELECT COUNT ( dbo.SpaSurveyDetails.Rating ) AS RatingStar FROM SpaSurveyDetails WHERE ( SpaSurveyDetails.CreatedAt >= DATEADD(D, - 7, GETDATE()) AND SpaSurveyDetails.CreatedAt < GETDATE() )";

    $stmt = $hon_connect->prepare($sql);
    $stmt->execute();

    $stmt1 = $hon_connect->prepare($sql1);
    $stmt1->execute();

    $stmt2 = $hon_connect->prepare($sql2);
    $stmt2->execute();

    $stmt3 = $hon_connect->prepare($sql3);
    $stmt3->execute();

    $dataArray = array();
    $dataArray1 = array();
    $dataArray2 = array();
    $dataArray3 = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $dataArray1[] = $row1;
    }

    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $dataArray2[] = $row2;
    }

    while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $dataArray3[] = $row3;
    }
    //  echo json_encode($dataArray);
    // echo json_encode($dataArray1);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$hon_connect = NULL;
