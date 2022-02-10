<?php include '../../config/session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exempted</title>
    <?php include '../../head.php' ?>
</head>

<body class="hold-transition skin-green sidebar-collapse">
    <div class="wrapper">
        <?php include '../../header.php'; ?>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>Attendance Exempted List Reports</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <form name="frmexampted" id="frmexampted" class="form-inline" novalidate="off">

                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="AddNewEX()"><i
                                                class="fa fa-plus-circle"></i> Add new</button>
                                        <!-- <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus-circle"></i> Add new</button> -->
                                    </div>
                                </form>
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="table-responsive" id="dynamic-table1">
                                            <!-- dynamic response -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive" id="dynamic-table">
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
        <!-- <div class="modal fade" id="modalExp"> -->
        <div class="modal fade" id="modalExp" tabindex="-1" role="dialog" aria-labelledby="editor-title">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Attendance Exempted</h4>
                    </div>

                    <div class="modal-body">
                        <form name="formExempted" id="formExempted" action="#" method="POST">
                            <div class="form-group">
                                <label>EMP ID</label>
                                <input type="text" name="ExemID" id="ExemID" class="form-control" placeholder="EMP ID"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Tier</label>
                                <input type="text" name="Exempted" id="Exempted" class="form-control"
                                    placeholder="Ex: D1, E2" required>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="Eid" />
                                <button type="button" onclick="addUserExt()" class="btn btn-primary"id="btnInsert">Save</button>
                                <!-- <button type="button" onclick="UpdateExt()" class="btn btn-primary"id="btnUpdate">Update</button> -->
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->



        <footer class="main-footer">
            <strong><a href="#">Developed by IT</a></strong>
        </footer>

        <!-- <div class="modal fade" id="modalExp"> -->
        <div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="editor-title">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </div>

                    <div class="modal-body">
                        <form name="formExempted" id="formExempted" action="#" method="POST">
                            <div class="form-group">
                                <h2 class="text-center">Do you want to delete this Record?</h2>
                                <input type="hidden" name="exemD" id="exemD" class="form-control" placeholder="EMP ID"
                                    required>
                                <div class="modal-footer text-center">
                                    <p></p>
                                    <button type="button" onclick="DeleteEX()" class="btn btn-danger" id="btndelete">Confirm</button>
                                    <button type="button" class="btn btn-defaul" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

    </div>
    <?php include '../../footer.php' ?>
    <script src="./script.js?v=1.0.7"></script>

</html>
<script>

window.operateEvents = {
    'click .edit, .deletedata': function(e, value, row, index) {
        var ExemTiker = row.ExemTiker;
        $('#Exempted').val(ExemTiker);
        var ExemID = row.ExemID;
        $('#exemD').val(ExemID);
    }


};

// window.operateEvents = {
//     'click .deletedata': function(e, value, row, index) {
//         var ExemID = row.ExemID;
//         $('#exemD').val(ExemID);
     
        
//     }
// };
</script>