<?php
include '../../config/session.php';
include '../../config/db.php';

try {
    $sql = "SELECT DevID, DevName FROM [ZSAsscess].[dbo].[DevicrLinkInfo]
            WHERE DevName LIKE '%SecerityOffice%' 
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
    <title>probation</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    Probation Notify Reports
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="myTable" data-toggle="table" data-url="./controllers/json_raw_data.php" data-pagination="true" data-page-size="25" data-click-to-select="true" data-page-list="[10, 25, 50, 100, ALL]" data-search="false" data-height="650" data-show-export="true" data-show-refresh="true" data-show-columns="true" class="table table-responsive table-bordered table-striped" >
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th colspan="7" class="text-center bg-info"><strong style="color: while">EMP Info</strong></th>
                                                    <th colspan="3" class="text-center bg-info"><strong style="color: while">New Hiring</strong></th>
                                                    <th colspan="3" class="text-center bg-info"><strong style="color: while">After promoted / an internal transfer</strong></th>
                                                </tr>
                                                <tr>
                                                    <th data-field="EmpCode" data-sortable="true">Emp ID</th>
                                                    <th data-field="EmpName" class="text-nowrap">Emp Name</th>
                                                    <th data-field="Positions" class="text-nowrap">Position</th>
                                                    <th data-field="Dept" data-sortable="true">DEPT</th>
                                                    <th data-field="HireDay" data-sortable="true">HireDay</th>
                                                    <th data-field="JobTranferDate" data-sortable="true">Job Transfer Date</th>
                                                    <th data-field="PassProbationDay" data-sortable="true">Probation Day</th>
                                                    <th data-field="Period15Days" data-sortable="true">Period 15 Days</th>
                                                    <th data-field="Period10Days" data-sortable="true">Period 10 Days</th>
                                                    <th data-field="Period3Days" data-sortable="true">Period 3 Days</th>
                                                    <th data-field="JobTranPeriod15Days" data-sortable="true">Period 15 Days</th>
                                                    <th data-field="JobTranPeriod10Days" data-sortable="true">Period 10 Days</th>
                                                    <th data-field="JobTranPeriod3Days" data-sortable="true">Period 3 Days</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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

        <script type="text/javascript">
            $('#myTable').bootstrapTable({
                showExport: true,
                exportTypes: ['excel', 'csv'],
                exportOptions: {
                    fileName: 'probation_warning_reports'
                }
            });
        </script>


</body>

</html>