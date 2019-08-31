<?php
session_start();

include '../config/db.php';

try {
    $sql1 = "SELECT * FROM [dbo].[Departments]";
    $stmt1 = $rms_connect->prepare($sql1);
    $stmt1->execute();


    $sql3 = "SELECT * FROM ReportGroups WHERE RGroupStatus = 1";
    $stmt3 = $rms_connect->prepare($sql3);
    $stmt3->execute();
    $dataArray = array();

    while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] = $row;
    }

    $sql4 = "SELECT * FROM ReportModules WHERE RMStatus = 1";
    $stmt4 = $rms_connect->prepare($sql4);
    $stmt4->execute();
    $dataArray1 = array();

    while ($row1 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        $dataArray1[] = $row1;
    }
    // echo json_encode($dataArray1);
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {

    $sql2 = "SELECT * FROM dbo.Roles ORDER BY RoleID ASC";

    $stmt2 = $rms_connect->prepare($sql2);
    $stmt2->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
}

$rms_connect = NULL;
?>

<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Users management
    </h1>
</section>

<section class="content">
    <div class="col-md-12">
        <div class="row">
            <div class="box box-success">

                <div class="box-body">
                    <div class="col-lg-3 col-md-3 col-sm-4">

                        <div class="box">

                            <div class="box-body">
                                <div class="form-group">
                                    <h2 class="label label-success">Add Users </h2>
                                </div>
                                <form name="formAddUsers" id="formAddUsers" method="POST" novalidate="off">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <input type="text" name="Username" class="form-control input-sm" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <input type="text" name="UserPwd" class="form-control input-sm" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <input type="number" name="EmpID" class="form-control input-sm" placeholder="EmpID" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <input type="text" name="EmpFname" class="form-control input-sm" placeholder="First Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <input type="text" name="EmpLname" class="form-control input-sm" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <input type="text" name="EmpEmail" class="form-control input-sm" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <select name="DeptID" class="form-control input-sm" required>
                                                <option value="">Select Department</option>
                                                <?php
                                                while ($sel1 = $stmt1->fetch(PDO::FETCH_NUM)) {
                                                    echo "<option value='$sel1[0]'>$sel1[3]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span style="color: red">*</span>
                                            </div>
                                            <select name="UserLevelID" class="form-control input-sm" required>
                                                <option value="">Select User Level</option>
                                                <?php
                                                while ($sel2 = $stmt2->fetch(PDO::FETCH_NUM)) {
                                                    echo "<option value='$sel2[0]'>$sel2[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" onclick="SaveAddUser()" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Clear</button>
                        </div>
                        </form>
                    </div>

                    <?php $auth = array('UserCanteenAuth', 'UserHoNAuth', 'UserLeaveAuth', 'UserSRExtAuth', 'UserAttdAuth', 'UserPosAuth', 'UserSoftAuth', 'UserEmpInfoAuth', 'UserSecFPAuth', 'UserProbationAuth');
                    $condition = array('Itemized Sales by Items Reports', 'Itemized Sales by Meal Period Reports', 'Daily Check Listing Reports', 'KOT Voided', 'House Check Summary Comp-Officer Reports', 'Individual OC Reports', 'Cross Outlet Net Revenue Reports');
                    ?>
                    <div class="col-lg-9 col-md-9 col-sm-4">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12 md-6">
                                        <h2 class="label label-success">Authorization Menu </h2>
                                        <?php
                                        foreach ($dataArray as $menu) { ?>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" onclick="checkBoxgroup_id('<?= $menu['RGroupID'] ?>')" data-toggle="collapse" data-target="#demo<?= $menu['RGroupID'] ?>" class="group_idx" id="checkBoxgroup_id<?= $menu['RGroupID'] ?>" value="<?= $menu['RGroupID'] ?>"> <b><?= $menu['RGroupDesc'] ?>
                                                        </b> </label>
                                                </div>
                                            </div>
                                            <div id="demo<?= $menu['RGroupID'] ?>" class="collapse">
                                                <?php foreach ($dataArray1 as $group) { ?>
                                                    <?php if ($menu['RGroupID'] == $group['RGroupID']) { ?>
                                                        <div class="form-group">
                                                            <div class="checkbox">
                                                                &nbsp; &nbsp; &nbsp; &nbsp; <label><input type="checkbox" id="checkBoxGroupid" class="groupx<?= $group['RGroupID'] ?>  grouploop" name="checkBoxGroupid<?= $group['RMID'] ?>" value="<?= $group['RMID'] ?>"> <span>
                                                                        <?= $group['RMName'] ?> </span> </label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                    } ?>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script src="./script.js" type="text/javascript">

</script>