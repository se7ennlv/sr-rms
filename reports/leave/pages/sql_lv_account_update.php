<?php
session_start();
include '../../../config/db.php';

try {
    $dateProcess = $_POST['dateProcess'];

    $sqlQuery = "WITH cte AS (
            SELECT 
            LVEMPLEAVE_EMPID AS [EmpID],
            HREMP_EMPCODE AS [EmpCode],
            HREMP_NAME AS [EmpName],
            CONVERT(DATE, HREMP_LHIREDAY) AS [LastHireDay],
            DATEDIFF(YEAR, HREMP_LHIREDAY, CONVERT(DATE, '{$dateProcess}')) AS [WorkYears],
            LVEMPLEAVE_LEAVEDAYS AS [AvailableDays],
            (SELECT 
            ISNULL(SUM(DATEDIFF(DAY, CONVERT(DATE, LVLEAVEREQ_BDATE), CONVERT(DATE, LVLEAVEREQ_EDATE)) + 1), 0) 
            FROM LVLEAVEREQ
            INNER JOIN HREMP ON LVLEAVEREQ_EMPID = HREMP_EMPID
            WHERE HREMP_EMPID = LVEMPLEAVE_EMPID AND LVLEAVEREQ_LEAVECODE = 'SPL' AND LVLEAVEREQ_STATUS NOT IN(0, 3, 4) AND HREMP_STATUS = 1 AND (FORMAT(LVLEAVEREQ_BDATE, 'MM-dd') >= FORMAT(HREMP_LHIREDAY, 'MM-dd'))
            AND YEAR(LVLEAVEREQ_BDATE) = YEAR(GETDATE())
            ) AS [SPLUsed]
            FROM LVEMPLEAVE
            INNER JOIN HREMP ON LVEMPLEAVE_EMPID = HREMP_EMPID
            WHERE LVEMPLEAVE_LEAVECODE = 'SPL' AND HREMP_STATUS = 1 
            )
            SELECT
            cte.EmpID, 
            cte.EmpCode, 
            cte.EmpName, 
            cte.LastHireDay, 
            FORMAT(CONVERT(DATE, '{$dateProcess}'), 'yyyy-MM-dd') AS [ProcessDate],
            cte.WorkYears, 
            cte.AvailableDays, 
            cte.SPLUsed,
            CASE
                WHEN FORMAT(CONVERT(DATE, '{$dateProcess}'), 'MM-dd') >= FORMAT(cte.LastHireDay, 'MM-dd') THEN  
                    CASE 
                        WHEN cte.WorkYears <= 1 THEN 0
                        WHEN cte.WorkYears > 1 AND cte.WorkYears < 5 THEN 
                            CASE
                                WHEN cte.SPLUsed = 0 THEN 1 ELSE 0
                            END
                            WHEN cte.WorkYears >= 5 THEN 
                                CASE
                                    WHEN cte.SPLUsed = 0 THEN 2 WHEN cte.SPLUsed = 1 THEN 1 ELSE 0 
                                END
                        ELSE 2
                        END
                    ELSE 0
            END AS [CurrentSPL]
            FROM cte
            WHERE FORMAT(cte.LastHireDay, 'MM-dd') = FORMAT(CONVERT(DATE, '{$dateProcess}'), 'MM-dd')
            ORDER BY cte.EmpID ASC ";

    $stmtQuery = $psa_connect->prepare($sqlQuery);
    $stmtQuery->execute();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>

<div id="toolbar">
    <h4>Date Process: [ <?= $dateProcess; ?> ]</h4>
    <h5 style="color: green">The SPL has been updated</h5>
</div>
<table id = "myTable" class="table table-bordered table-striped" 
       data-toggle="table"
       data-height="650"
       data-toolbar="#toolbar"
       data-show-export="true">
    <thead>
        <tr>
            <th>Emp ID</th>
            <th>Emp Name</th>
            <th>Last HireDay</th>
            <th>Process Date</th>
            <th>Work Years</th>
            <th>Available Days</th>
            <th>SPL Used</th>
            <th>SPL Should Have</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($resQuery = $stmtQuery->fetch(PDO::FETCH_ASSOC)) { ?>

            <?php
            try {
                $sqlUpdate = "
                    UPDATE LVEMPLEAVE 
                    SET LVEMPLEAVE_LEAVEDAYS = '{$resQuery['CurrentSPL']}'
                    WHERE LVEMPLEAVE_EMPID = {$resQuery['EmpID']} AND LVEMPLEAVE_LEAVECODE = 'SPL'
                    ";
                $stmtUpdate = $psa_connect->prepare($sqlUpdate);
                $stmtUpdate->execute();
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            ?>
            <tr>
                <td><?= $resQuery['EmpCode']; ?></td>
                <td><?= $resQuery['EmpName']; ?></td>
                <td><?= $resQuery['LastHireDay']; ?></td>
                <td><?= $resQuery['ProcessDate']; ?></td>
                <td><?= $resQuery['WorkYears']; ?></td>
                <td><?= $resQuery['AvailableDays']; ?></td>
                <td><?= $resQuery['SPLUsed']; ?></td>
                <td><?= $resQuery['CurrentSPL']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type = "text/javascript">
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