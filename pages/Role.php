<?php
session_start();
include '../config/db.php';


try {

    $sql1 = "SELECT * FROM [dbo].[Departments]";

    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {

    $sql2 = "SELECT * FROM dbo.UserLevel ORDER BY ULID ASC";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = NULL;
?>

<section class="content-header">
    <h1>
        <i class="fa fa-lock" aria-hidden="true"></i> System Access Role
    </h1>
</section>

<section class="content">
    <div class="col-md-12">
        <div class="row">
            <div class="box box-success">
                <div class="box-body">
                    <div class="tabel table-responsive">
                        <form name="frmSysAccessRole" id="frmSysAccessRole" method="POST" novalidate="off">
                            <table class="tabel table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">Emp ID</th>
                                        <th colspan="4" class="text-center">System Approve</th>
                                    </tr>
                                    <tr>
                                        <th><h4>Fingerprint Report</h4></th>
                                        <th><h4>Happy Or Not Report</h4></th>
                                        <th><h4>Leave Report</h4></th>
                                        <th><h4>SR Phone Numbers</h4></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center"><input type="number" name="EmpID" class="form-control" style="width: 100px"></th>
                                        <th class="text-center"><input type="checkbox" name="AccessFingerprintSys"></th>
                                        <th class="text-center"><input type="checkbox" name="AccessHappyOrNotSys"></th>
                                        <th class="text-center"><input type="checkbox" name="AccessLeaveSys"></th>
                                        <th class="text-center"><input type="checkbox" name="AccessSRPhoneSys"></th>
                                    </tr>
                                </thead>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>

<script src="./script.js" type="text/javascript"></script>


