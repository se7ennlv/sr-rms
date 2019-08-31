<?php
$leaveCode = $_POST['leaveCode'];
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
?>


<hr>
<table class="table table-bordered table-striped table-responsive table-hover" id="myTable"
       data-toggle="table"
       data-url="./controllers/json_search_roster.php?fromDate=<?= $fromDate; ?>&toDate=<?= $toDate; ?>&leaveCode=<?= $leaveCode; ?> "
       data-pagination="true"
       data-page-size="All"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-search="true"
       data-height="650"
       data-show-export="true"
       data-show-refresh="true"
       data-show-columns="true">
    <thead>
        <tr>
            <th data-field="WkDate">Work Date</th>
            <th data-field="EmpID">Emp ID</th>
            <th data-field="ShiftCode">Leave Code</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'LeaveByPeriod_' + today;
    }

    $table = $('#myTable').bootstrapTable({
        paging: false,
        showExport: true,
        exportTypes: ['excel'],
        exportOptions: {
            fileName: getCurDate()
        },

    });
</script>