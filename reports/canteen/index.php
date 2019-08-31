<?php
include '../../config/session.php';
include '../../config/db.php';

try {
    $sql = "SELECT DevID, DevName FROM [ZSAsscess].[dbo].[DevicrLinkInfo]
            WHERE DevName LIKE '%CANTEEN%' 
            ORDER BY DevName ASC ";
    $stmt = $fp_connect->prepare($sql);
    $stmt->execute();

    $group_id =  $_GET['group_id'];

    $sql1 = "SELECT * FROM dbo.ReportModules WHERE RGroupID = '{$group_id}'";
    $stmt1 = $rms_connect->prepare($sql1);
    $stmt1->execute();

    $dataArray = array();

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    echo  $sql1;

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
                                                    <select class="form-control" name="station">
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
                                                    <?php
                                                    $users =  explode(",", $_SESSION['roleModules']);
                                                    
                                                    foreach ($dataArray as $menu) { ?>
                                                        <?php foreach ($users as $user) { ?>
                                                            <?php if ($menu['RMID'] == $user) { ?>
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-custom btn-sm" id="<?= $menu['RMAction']; ?>"><i class="fa fa-search"></i> <?= $menu['RMName']; ?> </button>
                                                                </div>
                                                            <?php } ?>
                                                    <?php }
                                                    } ?>
                                                    <!-- <button type="button" class="btn btn-primary" id="btnRawReport"><i class="fa fa-bars"></i> Raw Report</button>
                                                    <button type="button" class="btn btn-info" id="btnTransactionReport"><i class="fa fa-list-ul"></i> Transaction Report</button>
                                                    <button type="button" class="btn btn-warning" id="btnSumaryReport"><i class="fa fa-th-large"></i> Sumary Report</button> -->
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

        <script src="script.js"></script>

</body>

</html>
<style>
    .btn-custom {
        background-color: #ffffff;
        color: #444;
        border-color: #00a65a;
    }
</style>