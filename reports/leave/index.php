<?php 
include '../../config/session.php'; 
include '../../config/db.php';

$group_id =  $_GET['group_id'];

$sql1 = "SELECT * FROM dbo.ReportModules WHERE RGroupID = '{$group_id}' AND RMIsActive = 1";
$stmt1 = $rms_connect->prepare($sql1);
$stmt1->execute();
$dataArray = array();

while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Reports</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">

        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    Leave Reports
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php
                                        $users =  explode(",", $_SESSION['roleModules']);
                                        foreach ($dataArray as $menu) { ?>
                                            <?php foreach ($users as $user) { ?>
                                                <?php if ($menu['RMID'] == $user) { ?>

                                                    <button type="button" class="btn btn-custom" data-toggle="modal" data-target="<?= $menu['RMAction']; ?>"><?= $menu['RMName']; ?> </button>
                                                    <!-- <button type="button" class="btn btn-primary btn-sm" id="<?= $menu['RMAction']; ?>"><i class="fa fa-search"></i> <?= $menu['RMName']; ?> </button> -->
                                                <?php } ?>
                                        <?php }
                                        } ?>
                                        <!-- <div class="btn-group pull-left">
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
                                                <b>Leave Account Summary</b> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu bullet pull-left">
                                                <li><a href="#" data-toggle="modal" data-target=".dept"><i class="fa fa-building" aria-hidden="true"></i> By Departments</a></li>
                                                <li><a href="#" data-toggle="modal" data-target=".empid"><i class="fa fa-user" aria-hidden="true"></i> By Employees ID</a></li>
                                            </ul>
                                        </div> -->
                                        <!-- <a href="#" data-toggle="modal" data-target=".spl" class="btn btn-warning">SPL Leave Account Update</a> -->
                                        <!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".spl">SPL Leave Account Update</button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".search-leave">Search Roster</button> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabel table-responsive" id="tblRespone">
                                            <!-- dynamic response -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs" style="color: red">
                <strong>Developed by IT</strong>
            </div>

            <strong><a href="#">(Version.1.0.2)</a></strong>
        </footer>
    </div>

    <?php include '../../footer.php' ?>

    <?php include 'modals/modal_by_emp.php' ?>
    <?php include 'modals/modal_by_dept.php' ?>
    <?php include 'modals/modal_spl_update.php' ?>
    <?php include 'modals/modal_search_roster.php' ?>

    <script src="script.js"></script>

</body>

</html>
