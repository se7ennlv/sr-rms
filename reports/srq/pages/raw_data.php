<?php
session_start();

try {
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<h4>Period:[ <?= $fromDate; ?> ] - [ <?= $toDate; ?> ]</h4>
<div id="toolbar">
    <select class="form-control">
        <option value="all">Export All</option>
        <option value="">Export Only Page</option>
    </select>
</div> 

<table id="myTable" 
       data-toggle="table"
       data-url="controllers/json_raw_data.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>"
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-pagination="true"
       data-search="true"
       data-height="650"
       data-toolbar="#toolbar"
       data-show-export="true"
       data-show-refresh="true"
       data-show-columns="true">
    <thead>
        <tr>
            <th data-field="TranDate" data-sortable="true" class="text-nowrap text-center">Date</th>
            <th data-field="Total" data-sortable="true" class="text-nowrap">Total Customers</th>
            
        </tr>     
    </thead>

</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'SRQReport_' + today;
    }

    var $table = $('#myTable');
    
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val(),
                exportTypes: ['excel'],
                exportOptions: {
                    fileName: getCurDate()
                }
            });
        });
    });

    $table = $('#myTable').bootstrapTable({
        showExport: true,
        exportTypes: ['excel'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>