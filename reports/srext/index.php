<?php
include '../../config/session.php';
include '../../config/db.php';

$sql = "SELECT * FROM Departments";
$stmt = $rms_connect->prepare($sql);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SR Extensions</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    Savan Resorts Extension
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div id="toolbar">
                                    <select class="form-control">
                                        <option value="">Export Only Page</option>
                                        <option value="all">Export All</option>
                                    </select>
                                </div>
                                <table id="myTable" data-toggle="table" data-url="./controllers/json_get_ext_list.php" data-pagination="true" data-page-size="25" data-click-to-select="true" data-page-list="[10, 25, 50, 100, ALL]" data-search="true" data-height="750" data-toolbar="#toolbar" data-show-export="true" data-show-refresh="true" data-show-columns="true">
                                    <thead>
                                        <tr>
                                            <th data-field="ExtNumber" data-sortable="true">Extension Numbers</th>
                                            <th data-field="DeptName" data-sortable="true">Departments</th>
                                            <th data-field="ExtLocation" data-sortable="true">Locations</th>
                                            <th data-field="ExtUsername" data-sortable="true">Usernames</th>
                                            <th data-field="operate" data-align="center" data-events="OptionEvents" data-formatter="OptionFormatter">Options</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Modal Update -->
            <div id="md-edit" class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Update Extension Number (<span id="extNumber"></span>)</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <form name="frmEdit" id="frmEdit" class="form-horizontal" method="POST" autocomplete="off">
                                    <div class="form-group">
                                        <label for="">Extension Number</label>
                                        <input type="number" name="ExtNumber" id="ExtNumber" class="form-control input-sm" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Department</label>
                                        <select name="ExtDeptID" id="ExtDeptID" class="form-control input-sm" required>
                                            <option value="">Select DEPT</option>
                                            <?php
                                            while ($dept = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?= $dept['DeptID']; ?>"><?= $dept['DeptName']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <input type="text" name="ExtLocation" id="ExtLocation" class="form-control input-sm" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="ExtUsername" id="ExtUsername" class="form-control input-sm" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="radio-inline"><input type="radio" name="ExtIsActive" value="1" checked>Enable</label>
                                        <label class="radio-inline"><input type="radio" name="ExtIsActive" value="0">Disable</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="ExtID" id="ExtID">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer class="main-footer">
            <strong><a href="#">Developed by IT</a></strong>
        </footer>
    </div>

    <?php include '../../footer.php' ?>

    <script src="script.js"></script>

</body>

</html>