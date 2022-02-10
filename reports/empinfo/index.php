<?php
include '../../config/session.php';
include '../../config/db.php';
try {
    $sql = "SELECT OrgID,DeptName FROM NORMEXT.[dbo].tbl_departments";

    $stmt = $psa_connect->prepare($sql);
    $stmt->execute();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee information </title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    Employee information Reports
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
                                                <div class="form-group">
                                                    <label>Department</label>
                                                    <select name="orgID" class="form-control input-sm" required>
                                                        <option value="all">All</option>
                                                        <?php
                                                        while ($res = $stmt->fetch(PDO::FETCH_NUM)) {
                                                            echo "<option value='$res[0]'>$res[1]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default" onclick="SuccessAction()"> Search <i class="<?= $menu['RMIcon']; ?>"></i></button>
                                                </div>
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
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="myimage" class="img-responsive center-block" style=" width: 300px; height: 300px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <strong><a href="#">Developed by IT</a></strong>
        </footer>

        <?php include '../../footer.php' ?>

        <script src="script.js?v=1.0.0"></script>
</body>

</html>
<script>
    window.operateEvents = {
        'click .view-photo': function(e, value, row, index) {
            // alert([row.HREMP_EMPCODE]);
            $("#myModal").modal();
            $('#exampleModalLabel').text(row.HREMP_FNAME + '  ' + row.HREMP_LNAME);

            if (row.FILENAME == null) {
                $('#myimage').attr('src', 'http://172.16.98.171/rms/dist/img/no-pic.png');
            } else {
                $('#myimage').attr('src', 'http://172.16.98.81:8090/psa/files/' + row.FILENAME);
            }
        }
    };
</script>