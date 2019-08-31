<?php
include '../controllers/json_report_weekly.php';

?>

<table id="myTable1" data-pagination="true" data-show-footer="true" data-export-footer="true" data-page-size="All" data-sortable="false" data-click-to-select="true" data-search="false" data-show-export="true" data-show-refresh="true">
    <thead>
        <tr>
            <th colspan="3" data-align="left"><strong>Savan Legend Resorts sole Company Limited.</strong></th>
        </tr>
        <tr>
            <th data-footer-formatter="sumFormatter">EmpName</th>
            <th>Descriptions</th>
            <th>RatingStar</th>
        </tr>
    <tbody>
        <?php foreach ($dataArray1 as $user) { ?>
            <tr>
                <td colspan="3"> <b> <?php echo $user['EmpName'] ?> </b> </td>
                <!-- <td style="display: none;"></td>
                <td style="display: none;"></td> -->
            </tr>
            <?php foreach ($dataArray as $emp) { ?>
                <tr>
                    <?php if ($user['EmpName']  ==  $emp['EmpName']) { ?>
                        <td></td>
                        <td><?= $emp['RateDesc'] ?></td>
                        <td><?= $emp['RatingStar'] ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <?php foreach ($dataArray2 as $sum) { ?>
                <tr class="bg-grey">
                    <?php if ($user['EmpName']  ==  $sum['EmpName']) { ?>
                        <td colspan="2"></td>

                        <td><b> Total : <?= $sum['RatingStar'] ?> </b></td>

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

    function sumFormatter(data) {
        var field = this.field;
        var totalSum = data.reduce(function(sum, row) {
            return sum + (+row[field]);
        }, 0);

        return '<strong>' + 'Grand Total : ' + <?= $dataArray3[0]['RatingStar']; ?> + '</strong>';
    }
</script>
<style>
    .bg-grey {
        background-color: #e8e7e7;
    }
</style>