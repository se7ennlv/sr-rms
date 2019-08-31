<?php
session_start();

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];

?>

<div id="toolbar">
    <select class="form-control">
        <option value="all">Export All</option>
        <option value="">Export Only Page</option>       
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_attd_dedution_resign.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>"
       data-pagination="true"
       data-page-size="All"
       data-click-to-select="true"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-search="true"
       data-height="650"
       data-toolbar="#toolbar"
       data-show-export="true"
       data-show-refresh="true"
       data-show-columns="true">
    <thead>
        <tr>
            <th colspan="19" data-align="left"><strong>Savan Legend Resorts sole  Company Limited.</strong></th>
        </tr>
        <tr>
            <th colspan="19" data-align="left"><strong>[Attendance Deduction Data] Period [<strong><?= $fromDate; ?> - <?= $toDate; ?></strong>]</strong></th>
        </tr>
        <tr>
            <th data-field="WorkDay" data-sortable="true" class="text-nowrap">Work Date</th>
            <th data-field="EmpCode" data-sortable="true" class="text-nowrap">Emp ID</th>
            <th data-field="EmpName" data-sortable="true" class="text-nowrap">Emp Name</th>
            <th data-field="Department" data-sortable="true" class="text-nowrap">Department</th>
            <th data-field="ShiftCode" data-sortable="true" class="text-nowrap">Shift Code</th>
            <th data-field="ShiftStart" data-sortable="true" class="text-nowrap">Shift Start</th>
            <th data-field="ShiftEnd" data-sortable="true" class="text-nowrap">Shift End</th>
            <th data-field="FirstCheckIn" data-sortable="true" data-format="dateFormat" class="text-nowrap">First Check-In</th>
            <th data-field="LastCheckOut" data-sortable="true" data-format="dateFormat" class="text-nowrap">Last Check-Out</th>
            <th data-field="LateCheckIn" data-sortable="true" class="text-nowrap">Late Check-In(Min)</th>
            <th data-field="EarlyCheckOut" data-sortable="true" class="text-nowrap">Early Check-Out(Min)</th>
            <th data-field="FpIn" data-sortable="true" class="text-nowrap">FP-In</th>
            <th data-field="FpOut" data-sortable="true" class="text-nowrap">FP-Out</th>
            <th data-field="Salary" data-sortable="true" class="text-nowrap">Salary</th>
            <th data-field="Currency" data-sortable="true" class="text-nowrap">Currency</th>
            <th data-field="Deduction" data-sortable="true" class="text-nowrap">Deduction</th>
            <th data-field="KIP" data-sortable="true" class="text-nowrap">KIP</th>
            <th data-field="THB" data-sortable="true" class="text-nowrap">THB</th>
            <th data-field="USD" data-sortable="true" class="text-nowrap">USD</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'AttdDeductionData_' + today;
    }

    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val(),
                exportTypes: ['csv', 'excel'],
                exportOptions: {
                    fileName: getCurDate()
                }
            });
        });
    });

    $table = $('#myTable').bootstrapTable({
        undefinedText: '',
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>

