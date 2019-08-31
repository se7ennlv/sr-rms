<?php include '../../config/session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SRQ</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>SRQ Reports</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <form name="frmSrq" id="frmSrq" class="form-inline" novalidate="off">
                                    <div class="form-group">
                                        <label for="">From:</label>
                                        <input type="text" name="fromDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                    </div>
                                    <div class="form-group">
                                        <label for="">To:</label>
                                        <input type="text" name="toDate" class="form-control input-sm datepicker" required readonly style="width: 120px">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="GetRawData();"><i class="fa fa-eye"></i> Show</button>
                                    </div>
                                </form>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive" id="dynamic-table">
                                    <!-- dynamic response -->
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

    <script src="script.js?v=1.0.0"></script>



</body>

</html>