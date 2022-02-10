<?php
session_start();
include '../../../config/db.php';

try {
    $dateProcess = $_POST['dateProcess'];

    $sqlQuery = "SELECT HREMP_EMPID FROM HREMP WHERE HREMP_STATUS = 1 AND DATEDIFF(DAY, HREMP_LHIREDAY, '{$dateProcess}') = 365";

    $stmtQuery = $psa_connect->prepare($sqlQuery);
    $stmtQuery->execute();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>

<div id="toolbar">
    <h4>Date Process: [ <?= $dateProcess; ?> ]</h4>
    <h5 style="color: green">The AL has been updated</h5>
</div>
<table id="myTable" class="table table-bordered table-striped" data-toggle="table" data-height="650" data-toolbar="#toolbar" data-show-export="true">
    <thead>
        <tr>
            <th>Emp ID</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($resQuery = $stmtQuery->fetch(PDO::FETCH_ASSOC)) { ?>

            <?php
                try {
                    $sqlUpdate = "
                    UPDATE LVEMPLEAVE 
                    SET LVEMPLEAVE_CARRYDAYS = '15'
                    WHERE LVEMPLEAVE_EMPID = {$resQuery['HREMP_EMPID']} AND LVEMPLEAVE_LEAVECODE = 'AL'
                    ";
                    $stmtUpdate = $psa_connect->prepare($sqlUpdate);
                    $stmtUpdate->execute();
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                ?>
            <tr>
                <td><?= $resQuery['HREMP_EMPCODE']; ?></td>

            </tr>
        <?php } ?>
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
            fileName: 'SplReport_' + getCurDate()
        }
    });
</script>