<?php
include '../controllers/json_summary_report.php';
function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}


?>
<br>
<table id="myTable1" data-pagination="true" data-show-footer="true" data-export-footer="true" data-page-size="All" data-sortable="false" data-click-to-select="true" data-search="false" data-show-export="true" data-show-refresh="true">
    <thead>
        <tr>
            <th colspan="6" data-align="left"><strong>Savan Legend Resorts sole Company Limited.</strong></th>
        </tr>
        <tr>
            <th colspan="7" data-align="left"><strong><?= $fromDate; ?> - <?= $toDate; ?></strong></th>
        </tr>
        <tr>
            <th>Emp Name</th>
            <th>Questions</th>
            <th>Rating</th>
            <th>Number Of Scorer</th>
            <th>Avg Score</th>
            <th>AVG %</th>
        </tr>
    <tbody>
        <?php foreach ($dataArray1 as $user) { ?>
            <tr>
                <td colspan="6"> <b> <?php echo $user['EmpName'] ?> </b> </td>
                <!-- <td style="display: none;"></td>
                <td style="display: none;"></td> -->
            </tr>
            <?php foreach ($dataArray as $emp) { ?>
                <tr>
                    <?php if ($user['EmpName']  ==  $emp['EmpName']) { ?>
                        <td></td>
                        <td><?= $emp['Questions'] ?></td>
                        <td><?= $emp['Rating'] ?></td>
                        <td><?= $emp['NoOfScorer'] ?></td>
                        <td><?= $emp['AvgScore'] ?></td>
                        <td> <?php if (startsWith($emp['AVG'], '0')) {
                                                echo substr($emp['AVG'], 1, 3);
                                            } else {
                                                echo $emp['AVG'];
                                            } ?> </td>
                    <?php } ?>
                </tr>
            <?php } ?>

        <?php } ?>
        <!-- <tr class="info">
            <td colspan="3"> <b>  </b> </td>
        </tr> -->
    </tbody>
    </thead>

</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'SpaMonthlyReport - ' + today;
    }

    var $table = $('#table');
    $(function() {
        $('#toolbar').find('select').change(function() {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val(),
                exportTypes: ['csv', 'excel'],
                exportOptions: {
                    fileName: getCurDate()

                }
            });
        });
    });
    $table = $('#myTable1').bootstrapTable({
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>
<style>
    .bg-grey {
        background-color: #e8e7e7;
    }
</style>