<?php
session_start();
include '../../../config/db.php';

try {
    $empID = $_POST['empID'];
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];

    $sql1 = "SELECT 
                hr.HREMP_EMPID AS [EmpID], 
                hr.HREMP_FNAME +' '+ hr.HREMP_LNAME AS [EmpName],
                job.HRJOB_JOBNAME AS [Position],  
                org.ASORG_ORGNAME AS [Dept],
                CONVERT(DATE, hr.HREMP_HIREDAY) AS [Hireday]
            FROM [PSA66].[dbo].[HREMP] hr
            INNER JOIN dbo.ASORG org ON hr.HREMP_ORG = org.ASORG_ORGID
            INNER JOIN HRJOB job ON hr.HREMP_JOBID = job.HRJOB_JOBID
            WHERE hr.HREMP_EMPID = '{$empID}' ";

    $stmt1 = $psa_connect->prepare($sql1);
    $stmt1->execute();
    $res1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    $sql2 = "SELECT LVLEAVE_LEAVECODE AS LvCode FROM LVLEAVE ORDER BY LVLEAVE_LEAVECODE ASC";

    $stmt2 = $psa_connect->prepare($sql2);
    $stmt2->execute();

    $sql3 = "SELECT COUNT(*) AS NumRows FROM LVLEAVE";
    $stmt3 = $psa_connect->prepare($sql3);
    $stmt3->execute();

    $numRows = $stmt3->fetch(PDO::FETCH_COLUMN);
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
<div id="toolbar">
    <h4>Period:[ <?= $fromDate; ?> ] - [ <?= $toDate; ?> ]</h4>
</div>
<table id="myTable" class="table table-bordered table-striped" data-toggle="table" data-height="650" data-toolbar="#toolbar" data-show-export="true">
    <thead>
        <tr>
            <th rowspan="2" data-vlign="middle">Emp ID</th>
            <th rowspan="2" data-vlign="middle">Emp Name</th>
            <th rowspan="2" data-vlign="middle">Hire Date</th>
            <th rowspan="2" data-vlign="middle">Position</th>
            <th rowspan="2" data-vlign="middle">Department</th>
            <th colspan="<?= $numRows; ?>" class="text-center">Leave Type</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle">Total</th>
        </tr>
        <tr>
            <?php
            $sql4 = "SELECT LVLEAVE_LEAVECODE AS LvCode FROM LVLEAVE ORDER BY LVLEAVE_LEAVECODE ASC";
            $stmt4 = $psa_connect->prepare($sql4);
            $stmt4->execute();

            while ($col = $stmt4->fetch(PDO::FETCH_ASSOC)) { ?>
                <th class="text-center"><?= $col['LvCode']; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $res1['EmpID']; ?></td>
            <td><?= $res1['EmpName']; ?></td>
            <td><?= $res1['Hireday']; ?></td>
            <td><?= $res1['Position']; ?></td>
            <td><?= $res1['Dept']; ?></td>

            <?php while ($res2 = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
                <?php
                $sql5 = "
                WITH LeaveExtract AS (
                    SELECT 
                    HREMP_EMPCODE AS EmpID, 
                    HREMP_ORG AS OrgID,
                    CONVERT(DATE, ATWKCALDEMP_WKDATE) AS RosterDate, 
                    ATWKCALDEMP_SHIFTCODE AS RosterShiftCode,
                    LVLEAVEBANK_LEAVECODE AS LeaveCode,
                    CONVERT(DATE, LVLEAVEBANK_ACTDATE) AS LeaveActiveDate,
                    LVLEAVEBANK_REQID AS LeaveNo
                    FROM ATWKCALDEMP
                    INNER JOIN HREMP ON ATWKCALDEMP_EMPID = HREMP_EMPCODE
                    LEFT JOIN (
                                SELECT LVLEAVEBANK_EMPID, LVLEAVEBANK_ACTDATE, LVLEAVEBANK_REQID, LVLEAVEBANK_LEAVECODE
                                FROM LVLEAVEBANK 
                                WHERE LVLEAVEBANK_TYPE = 2 AND LVLEAVEBANK_INACTIVE = 0) AS Leave 
                    ON CONVERT(DATE, ATWKCALDEMP_WKDATE) = CONVERT(DATE, LVLEAVEBANK_ACTDATE) AND HREMP_EMPID = LVLEAVEBANK_EMPID
                    WHERE HREMP_EMPCODE = '{$empID}' AND CONVERT(DATE, ATWKCALDEMP_WKDATE) BETWEEN '{$fromDate}' AND '{$toDate}' AND (ATWKCALDEMP_SHIFTCODE NOT LIKE 'C%' AND ATWKCALDEMP_SHIFTCODE NOT LIKE 'DO' AND ATWKCALDEMP_SHIFTCODE NOT LIKE 'OS')
                )
                SELECT COUNT(*) AS countDay FROM LeaveExtract WHERE EmpID = '{$empID}' AND (RosterShiftCode = '{$res2['LvCode']}' OR LeaveCode = '{$res2['LvCode']}') 
                ";

                $stmt5 = $psa_connect->prepare($sql5);
                $stmt5->execute();
                $res5 = $stmt5->fetch(PDO::FETCH_ASSOC);

                $total += $res5['countDay'];
                ?>
                <td class="text-center">
                    <?php if ($res5['countDay'] > 0) { ?>
                        <a href="#" style="color: red"><?= $res5['countDay'] ?></a>
                    <?php } else { ?>
                        <a href="#">0</a>
                    <?php } ?>
                </td>
            <?php }
            $psa_connect = NULL; ?>

            <td class="text-center">
                <label class="label label-success" style="font-size: 14px"><?= $total; ?></label>
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    function getCurDate() {
        var $now = new Date();
        var $today = $now.format("isoDateTime");
        return $today;
    }

    $table1 = $('#myTable').bootstrapTable({
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: 'LeaveReport_' + getCurDate()
        }
    });
</script>