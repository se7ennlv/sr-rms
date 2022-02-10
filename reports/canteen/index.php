<?php
include '../../config/session.php';
include '../../config/db.php';

try {
    $sql = "SELECT DevID, DevName FROM [ZSAsscess].[dbo].[DevicrLinkInfo]
            WHERE DevName LIKE '%CANTEEN%' 
            ORDER BY DevName ASC ";
    $stmt = $fp_connect->prepare($sql);
    $stmt->execute();

} catch (PDOException $e) {
    echo $e->getMessage();
}

$fp_connect = NULL;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Canteen Reports</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>Canteen Reports</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-4">
                                        <form name="formFingerScan" id="formFingerScan" class="form-inline" novalidate="off">
                                            <section class="text-center">
                                                <div class="form-group">
                                                    <label for="">From:</label>
                                                    <input type="text" name="fromDate" class="form-control datepicker" required readonly style="width: 120px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">To:</label>
                                                    <input type="text" name="toDate" class="form-control datepicker" required readonly style="width: 120px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Station:</label>
                                                    <select class="form-control" name="station" id="picker">
                                                        <?php
                                                        while ($sel = $stmt->fetch(PDO::FETCH_NUM)) {
                                                            echo "<option value='$sel[1]'>$sel[1]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </section>
                                            <hr style="margin: 7px">
                                            <section class="text-center">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default" id="btnRawReport"><i class="fa fa-search"></i> Raw Data</button>
                                                    <button type="button" class="btn btn-default" id="btnCountByPeriodReport"><i class="fa fa-search"></i> Count Person by Periods</button>
                                                    <button type="button" class="btn btn-default" id="btnSumaryReport"><i class="fa fa-search"></i> Dept Summary by Periods</button>
                                                    <!-- <button type="button" class="btn btn-default" onclick="summaryByPerson();"><i class="fa fa-search"></i> Over (3) Sumary Report</button>  -->
                                                </div>
                                            </section>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                                <div class="tabel table-responsive" id="tableRespone">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong><a href="#">Developed By IT</a></strong>
        </footer>

        <?php include '../../footer.php' ?>

        <!-- <script src="script.js?v=1007"></script> -->

</body>

</html>
