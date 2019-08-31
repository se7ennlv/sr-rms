<?php
include '../../config/session.php';
include '../../config/db.php';
try {
    $sql = "SELECT DeptID, DeptName FROM Departments ORDER BY DeptID ASC";
    $stmt = $hon_connect->prepare($sql);
    $stmt->execute();
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
    <title>Customer feedback Report</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    Customer feedback Reports
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
                                        <label>Department</label>
                                        <select name="DeptID" class="form-control input-sm" required>
                                            <option value="all">All</option>
                                            <?php
                                            while ($res = $stmt->fetch(PDO::FETCH_NUM)) {
                                                echo "<option value='$res[0]'>$res[1]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">From:</label>
                                        <input type="text" name="fromDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                    </div>
                                    <div class="form-group">
                                        <label for="">To:</label>
                                        <input type="text" name="toDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </form>

                                <table id="myTable1" data-toggle="table" data-url="./controllers/json_raw_data.php" data-pagination="true" data-page-size="25" data-click-to-select="true" data-page-list="[10, 25, 50, 100, ALL]" data-search="false" data-height="650" data-show-export="true" data-show-refresh="true" data-show-columns="true">
                                    <thead>
                                        <tr>
                                            <th data-field="TranType" data-sortable="true">Transaction</th>
                                            <th data-field="TranQuestion" data-sortable="true">Question</th>
                                            <th data-field="TranComment" data-sortable="true">Customer Feedback</th>
                                            <th data-field="DeptName" data-sortable="true">Department</th>
                                            <th data-field="LocaName" data-sortable="true">Location</th>
                                            <th data-field="TranCreatedAt" data-formatter="dateFormat" data-sortable="true">Created At</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <table id="myTable2" data-toggle="table" data-url="./controllers/json_sum_data.php" data-page-size="25" data-click-to-select="true" data-height="450" data-search="true" data-show-export="true" data-show-refresh="true">
                                <thead>
                                    <tr>
                                        <th data-field="DeptName" data-sortable="true">Department</th>
                                        <th data-field="LocaName" data-sortable="true">Location</th>
                                        <th data-field="TranType" data-sortable="true">Transaction</th>
                                        <th data-field="countByType" data-sortable="true">Total</th>
                                    </tr>
                                </thead>
                            </table>
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

    <script src="script.js"></script>

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