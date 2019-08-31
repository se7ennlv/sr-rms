<?php
include '../../config/session.php';
include './config/db.php';
try {
    include '../../config/db.php';
    $group_id =  $_GET['group_id'];
    $sql1 = "SELECT * FROM dbo.ReportModules WHERE RGroupID = '{$group_id}' AND RMStatus = 1";
    $stmt1 = $rms_connect->prepare($sql1);
    $stmt1->execute();
    $dataArray = array();

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }
    // echo json_encode($dataArray);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS Reports</title>

    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    POS Reports
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
                                        <form name="frmPos" id="frmPos" class="form-inline" novalidate="off">
                                            <section class="text-center">
                                                <div class="form-group">
                                                    <label for="">From:</label>
                                                    <input type="text" name="fromDate" id="dtFrom" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">To</label>
                                                    <input type="text" name="toDate" id="dtTo" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Outlet:</label>
                                                    <select class="form-control" name="posID" id="posID">
                                                        <option value="">Select Outlet</option>
                                                        <?php
                                                        $sqlOutlet = "SELECT posID AS [PosID], posName AS [PosName] FROM mPOS ORDER BY posID ASC";
                                                        $stmtOutlet = $conn->prepare($sqlOutlet);
                                                        $stmtOutlet->execute();

                                                        while ($resOut = $stmtOutlet->FETCH(PDO::FETCH_NUM)) {
                                                            echo "<option value='$resOut[0]'>$resOut[1]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="posName" id="posName">
                                                </div>
                                            </section>
                                            <hr>
                                            <section class="text-center">
                                                <div class="form-group">
                                                    <?php
                                                    $users =  explode(",", $_SESSION['roleModules']);
                                                    foreach ($dataArray as $menu) { ?>
                                                        <?php foreach ($users as $user) { ?>
                                                            <?php if ($menu['RMID'] == $user) { ?>
                                                                <button type="button" class="btn btn-custom" onclick="<?= $menu['RMAction']; ?>" ><?= $menu['RMName']; ?> </button>
                                                            <?php } ?>
                                                    <?php }
                                                    } ?>

                                                    <!-- <button type="button" class="btn btn-default" onclick="Action1()" data-toggle="tooltip" data-placement="bottom" title="Released">Itemized Sales by Items Reports</button>
                                                    <button type="button" class="btn btn-default" onclick="Action2()" data-toggle="tooltip" data-placement="bottom" title="Released">Itemized Sales by Meal Period Reports</button>
                                                    <button type="button" class="btn btn-default" onclick="Action3()" data-toggle="tooltip" data-placement="bottom" title="Released">Daily Check Listing Reports</button>
                                                    <button type="button" class="btn btn-default" onclick="Action4()" data-toggle="tooltip" data-placement="bottom" title="Released">KOT Voided</button>
                                                    <button type="button" class="btn btn-default" onclick="Action5()" data-toggle="tooltip" data-placement="bottom" title="Released">House Check Summary Comp-Officer Reports</button>
                                                    <button type="button" class="btn btn-default" onclick="Action6()" data-toggle="tooltip" data-placement="bottom" title="Released">Individual OC Reports</button>
                                                    <button type="button" class="btn btn-default" onclick="Action7()" data-toggle="tooltip" data-placement="bottom" title="Released">Cross Outlet Net Revenue Reports</button> -->

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
    </div>

    <?php include '../../footer.php' ?>

</body>

</html>

<script type="text/javascript">
    $('select').on('change', '', function(e) {
        $("#posName").val($("#posID option:selected").text());
    });
</script>

<style>
    .btn-custom {
        background-color: #ffffff;
        color: #444;
        border-color: #00a65a;
    }
</style>