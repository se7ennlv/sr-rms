<?php
session_start();

try {
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<h4><strong>Norming (PSA)</strong></h4>
<hr>
<table id="myTable1" 
       data-toggle="table1"
       data-url="controllers/json_raw_data_PSAA6.php?"
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
            <th data-field="ExemID" data-sortable="true" class="text-nowrap text-center">EMP ID</th>
            <th data-field="HREMP_NAME" data-sortable="true" class="text-nowrap">EMP Name</th>
            <th data-field="HRJOB_JOBNAME" data-sortable="true">Position</th>
            <th data-field="ASORG_ORGNAME" data-sortable="true">DEPT</th>
            <th data-field="ExemTiker" data-sortable="true">Tier</th>
            
        </tr>     
    </thead>

</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'EXamtReport_' + today;
    }

    var $table = $('#myTable1');
    
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

    $table = $('#myTable1').bootstrapTable({
        showExport: true,
        exportTypes: ['excel'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>