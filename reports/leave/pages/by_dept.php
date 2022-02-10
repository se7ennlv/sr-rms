<?php
session_start();

try {
    $org = $_POST['org'];
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
       data-url="./controllers/json_count_by_dept.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&org=<?= $org;?>"
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
            <th data-field="EmpCode" data-sortable="true" class="text-nowrap text-center" rowspan="2" data-vlign="middle">Emp ID</th>
            <th data-field="EmpName" data-sortable="true" class="text-nowrap" rowspan="2" data-vlign="middle">Emp Name</th>
            <th data-field="Hireday" data-sortable="true" class="text-nowrap" rowspan="2" data-vlign="middle">Hireday</th>
            <th data-field="Position" data-sortable="true" class="text-nowrap" rowspan="2" data-vlign="middle">Position</th>
            <th data-field="Dept" data-sortable="true" class="text-nowrap" rowspan="2" data-vlign="middle">Department</th>
            <th colspan="18" class="text-nowrap text-center">Leave Types</th>
            <th data-field="Total" data-sortable="true" class="text-nowrap text-center" rowspan="2" style="color: red" data-vlign="middle">Total</th>
        </tr>
        <tr>
            <th data-field="AB" data-sortable="true" class="text-nowrap text-center">AB</th>
            <th data-field="AL" data-sortable="true" class="text-nowrap text-center">AL</th>
            <th data-field="FL" data-sortable="true" class="text-nowrap text-center">FL</th>
            <th data-field="HL" data-sortable="true" class="text-nowrap text-center">HL</th>
            <th data-field="ML" data-sortable="true" class="text-nowrap text-center">ML</th>
            <th data-field="NDL" data-sortable="true" class="text-nowrap text-center">NDL</th>
            <th data-field="PH" data-sortable="true" class="text-nowrap text-center">PH</th>
            <th data-field="PL" data-sortable="true" class="text-nowrap text-center">PL</th>
            <th data-field="SL" data-sortable="true" class="text-nowrap text-center">SL</th>
            <th data-field="SPL" data-sortable="true" class="text-nowrap text-center">SPL</th>
            <th data-field="TL" data-sortable="true" class="text-nowrap text-center">TL</th>
            <th data-field="UL" data-sortable="true" class="text-nowrap text-center">UL</th>
            <th data-field="WL" data-sortable="true" class="text-nowrap text-center">WL</th>
            <th data-field="XL" data-sortable="true" class="text-nowrap text-center">XL</th>
            <th data-field="MSO" data-sortable="true" class="text-nowrap text-center">MSO</th>
            <th data-field="LWP" data-sortable="true" class="text-nowrap text-center">LWP</th>
            <th data-field="WOP" data-sortable="true" class="text-nowrap text-center">WOP</th>
            <th data-field="LDL" data-sortable="true" class="text-nowrap text-center">LDL</th>
            
        </tr>     
    </thead>

</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'LeaveReport_' + today;
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