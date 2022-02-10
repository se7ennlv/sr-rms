<?php
include '../../config/session.php';
include '../../config/db.php';
try {
    $group_id =  $_GET['group_id'];
    $sql = "SELECT DeptID, DeptName FROM Departments ORDER BY DeptID ASC";
    $stmt = $hon_connect->prepare($sql);
    $stmt->execute();

    $sql1 = "SELECT * FROM dbo.ReportModules WHERE RGroupID = '{$group_id}'  AND RMIsActive = 1";
    $stmt1 = $rms_connect->prepare($sql1);
    $stmt1->execute();
    $dataArray = array();

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }
    // echo json_encode($dataArray);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
$hon_connect = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPA Report</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">

            <section class="content-header">
                <h1>
                    SPA Report
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <form name="frmAttd" id="frmAttd" class="form-inline" novalidate="off">

                                    <div class="form-group">
                                        <label for="">From:</label>
                                        <input type="text" name="fromDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                    </div>
                                    <div class="form-group">
                                        <label for="">To:</label>
                                        <input type="text" name="toDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                    </div>
                                    <?php
                                    $users =  explode(",", $_SESSION['roleModules']);
                                    foreach ($dataArray as $menu) { ?>
                                        <?php foreach ($users as $user) { ?>
                                            <?php if ($menu['RMID'] == $user) { ?>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-custom" onclick="<?= $menu['RMAction']; ?>()"><i class="fa fa-search"></i> <?= $menu['RMName']; ?> </button>
                                                </div>
                                            <?php } ?>
                                    <?php }
                                    } ?>
                                </form>
                                <section id="tabs" class="project-tab">
                                    <div class="tabel table-responsive" id="tableRespone">
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <strong><a href="#">Developed by IT</a></strong>
        </footer>
    </div>

    <?php include '../../footer.php' ?>

    <script src="script.js?v=1.0.2"></script>

    <script type="text/javascript">
        function dateFormat(value, row, index) {
            return moment(value).format('YYYY-MM-DD HH:mm:ss');
        }

        function getCurDate() {
            var $now = new Date();
            var $today = $now.format("isoDateTime");
            return $today;
        }
    </script>

</body>

</html>
<style>
    .btn-custom {
        background-color: #ffffff;
        color: #444;
        border-color: #00a65a;
    }
</style>