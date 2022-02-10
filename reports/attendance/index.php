<?php
include '../../config/session.php';
include '../../config/db.php';

try {
    $sql = "SELECT OrgCode, DeptName FROM ZSAsscess.[dbo].DeptInfo";
    $stmt = $psa_connect->prepare($sql);
    $stmt->execute();

    $group_id =  $_GET['group_id'];
    $sql1 = "SELECT * FROM dbo.ReportModules WHERE RGroupID = '{$group_id}' AND RMIsActive = 1";
    $stmt1 = $rms_connect->prepare($sql1);
    $stmt1->execute();
    $dataArray = array();

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }
    //echo json_encode($dataArray);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Report</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    Attendance Reports
                    <small>( v.1.0.2 )</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-4">
                                        <form name="frmAttd" id="frmAttd" class="form-inline" novalidate="off">
                                            <section class="text-center">
                                                <?php if ($_SESSION['roleID'] == '1' || $_SESSION['roleID'] == '2') { ?>
                                                    <div class="form-group">
                                                        <label>Department</label>
                                                        <select name="orgCode" class="form-control input-sm" required>
                                                            <option value="all">All</option>
                                                            <?php
                                                                while ($res = $stmt->fetch(PDO::FETCH_NUM)) {
                                                                    echo "<option value='$res[0]'>$res[1]</option>";
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <label for="">From:</label>
                                                    <input type="text" name="fromDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">To:</label>
                                                    <input type="text" name="toDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
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
                                                                <button type="button" class="<?= $menu['RMBtnClass']; ?>" onclick="<?= $menu['RMAction']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?= $menu['RMName']; ?>"><i class="<?= $menu['RMIcon']; ?>"></i> <?= $menu['RMName']; ?></button>
                                                            <?php } ?>
                                                    <?php }
                                                    } ?>
                                                </div>
                                            </section>
                                        </form>
                                    </div>
                                </div>
                                <hr>

                                <div class="tabel table-responsive" id="tblRespone">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong><a href="#">Developed by IT</a></strong>
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