<?php include '../config/session.php';
include 'controllers/json_dataproduction.php';
include 'controllers/json_datasoftware.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SR Phone</title>
    <?php include '../head.php' ?>
</head>

<body class="hold-transition skin-green">
    <div class="wrapper">
        <header class="main-header">
            <a href="./" class="logo">
                <span class="logo-mini"><b>ITSYS</b></span>
                <span class="logo-lg"><b>ITSYS</b></span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <a href="../" class="pull-left" style="margin-top: 15px; color: #fff" onclick="home()">
                    <i class="fa fa-home"></i> Home
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="../controllers/phpLogout.php" class="pull-right">
                                <i class="fa fa-sign-out"></i> Sign out
                            </a>
                            <a href="#" class="dropdown-toggle pull-right" data-toggle="dropdown">
                                <i class="fa fa-user fa-1x"></i>
                                [ <span class="hidden-xs"><?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?></span> ]
                                [ <span class="hidden-xs"><?= $_SESSION['ULName']; ?></span> ]
                                [ <span class="hidden-xs" id="deptName"><?= $_SESSION['DeptCode']; ?></span> ]
                                <span style="display: none" id="SectionID"><?= $_SESSION['SectionID']; ?></span>
                                <span style="display: none" id="ULID"><?= $_SESSION['ULID']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <p>
                                        <?= $_SESSION['EmpFname']; ?>&ensp;<?= $_SESSION['EmpLname']; ?>
                                        <small>Member since (<?= $_SESSION['UserCreatedAt']; ?>)</small>
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="content-wrapper" id="mainContent">
            <section class="content-header">
                <h1>
                    IT Software Productions
                    <small>( v.1.0.0 )</small>
                </h1>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-hover table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sort Name</th>
                                            <th>Full Name</th>
                                            <th>Screenshort</th>
                                            <th>Purpose</th>
                                            <th>Version</th>
                                            <th>Release date</th>
                                            <th>resolve issue</th>
                                            <th>Directory file setup</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $softs  = json_decode($getdata_soft, true);
                                        foreach ($softs as $row) { ?>
                                        <tr>
                                            <td class="text-nowrap"><?= $row['SoftID']; ?> </td>
                                            <td class="text-nowrap"><?= $row['SoftName']; ?></td>
                                            <td class="text-nowrap"><?= $row['SoftFullName']; ?></td>
                                            <td class="text-center"> <a href="#" onclick="ViewPro(this.id,this.name);" name="<?= $row['SoftFullName']; ?>" id="<?= $row['SoftScreenShort']; ?> "> View </a> </td>
                                            <!-- <td class="text-center"><button onclick="ViewPro(this.id,this.name);" class="btn btn-success" name="<?= $row['SoftFullName']; ?>" id="<?= $row['SoftScreenShort']; ?>"> View </button> </td> -->

                                            <td class="text-nowrap">
                                                <?php
                                                    $arr  = json_decode($getdata_pro, true);
                                                    foreach ($arr as $item) {
                                                        $uses = $item['ProSoftID'] ?>
                                                <?php if ($row['SoftID'] == $uses) { ?>
                                                <?= $item['ProPurpose'] ?> <br>
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $arr  = json_decode($getdata_pro, true);
                                                    foreach ($arr as $item) {
                                                        $uses = $item['ProSoftID'] ?>
                                                <?php if ($row['SoftID'] == $uses) { ?>
                                                <?= $item['ProVersion'] ?> <br>
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $arr  = json_decode($getdata_pro, true);
                                                    foreach ($arr as $item) {
                                                        $uses = $item['ProSoftID'] ?>
                                                <?php if ($row['SoftID'] == $uses) { ?>
                                                <?= $item['ProReleaseDate'] ?> <br>
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                    $arr  = json_decode($getdata_pro, true);
                                                    foreach ($arr as $item) {
                                                        $uses = $item['ProSoftID'] ?>
                                                <?php if ($row['SoftID'] == $uses) { ?>
                                                <a href="#" type="file" onclick="ViewResolve(this.name);" name="<?= $item['ProResolve']; ?>"> View </a> <br>
                                                <?php } ?>

                                                <?php } ?>
                                            </td>
                                            <td class="text-nowrap">
                                                <?php
                                                    $arr  = json_decode($getdata_pro, true);
                                                    foreach ($arr as $item) {
                                                        $uses = $item['ProSoftID'] ?>
                                                <?php if ($row['SoftID'] == $uses) { ?>
                                                <?= $item['ProDirectory'] ?> <br>
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> <i class="glyphicon glyphicon-cog"></i> Resolve Issue </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="" id="titelresolve"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Creates the bootstrap modal where the image will appear -->
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:70%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
                    </div>
                    <div class="modal-body">
                        <img src="" id="imagepreview" style="width:100%">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <footer class="main-footer">
            <div class="pull-right hidden-xs" style="color: red">
                <strong>Developed by IT</strong>
            </div>

            <strong><a href="#">(Version.1.0.0)</a></strong>
        </footer>
    </div>

    <?php include 'modals/modal_edit.php' ?>
    <?php include '../footer.php' ?>

</body>

</html>
<script>
    $(document).ready(function() {
        $(function() {
            $('#dataTable').DataTable();
        });
    });

    function ViewPro(id, name) {
        if (id.length > 1) {
            $('#myModalLabel').text(name);
            $('#imagepreview').attr('src', ' http://172.16.98.171/rms2/IT/img/' + id + '');
            var getfullname = $(this).attr('nameprogram');
            $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function

        } else {
            alert("Don't have image for this program");
        }
    }

    function ViewResolve(name) {
        if (name.length > 1) {
            $('#titelresolve').text(name);
            $('#exampleModalCenter').modal('show');
        } else {
            $('#titelresolve').text("Don't have resolve issue");
            $('#exampleModalCenter').modal('show');
        }


    }
</script>