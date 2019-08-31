<h4><i class="fa fa-history"></i> Log for [ <?= $_GET['logDate']; ?> ]</h4>
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_log.php?logDate=<?= $_GET['logDate']; ?> "  
       data-pagination="true"
       data-page-size="25"
       data-click-to-select="true"
       data-page-list="[10, 25, 50, 100, ALL]"
       data-search="true"
       data-height="750"
       data-toolbar="#toolbar"
       data-show-refresh="true">
    <thead>
        <tr>
            <th data-field="UserEmpID" data-sortable="true" class="text-nowrap">Emp ID</th>
            <th data-field="EmpFullName" data-sortable="true" class="text-nowrap">Emp Name</th>
            <th data-field="DeptName" data-sortable="true" class="text-nowrap">Department</th>
            <th data-field="RoleName" data-sortable="true" class="text-nowrap">User Level</th>
            <th data-field="LogRptAccess" data-sortable="true" class="text-nowrap">System Access</th>
            <th data-field="LogAccessTime" data-sortable="true" class="text-nowrap">System Access Time</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    $('#myTable').bootstrapTable();
</script>