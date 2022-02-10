<?php
session_start();

$orgCode = $_POST['orgCode'];
?>
<div id="toolbar">
    <select class="form-control">
        <option value="">Export Only Page</option>
        <option value="all">Export All</option>
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_raw_data.php?"
       data-pagination="true"
       data-page-size="25"
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
            <th colspan="7" data-align="left"><strong>Savan Legend Resorts sole  Company Limited.(IT Inventory Request System)</strong></th>
        </tr>
        <tr>
            <th colspan="7" data-align="left"><strong>[Raw Item Data]-[For IT Only]</strong></th>
        </tr>
        
        <tr>
            <th data-field="ITEMNO" data-sortable="true" class="text-nowrap">Item Code</th>
            <th data-field="DESCREIPTION" data-sortable="true" class="text-nowrap">Description</th>
            <th data-field="DEPT" data-sortable="true" class="text-nowrap text-center">Department</th>
            <th data-field="QTYONHAND" data-sortable="true" class="text-nowrap text-right">Qty On Hand</th>
            <th data-field="COSTUNIT" data-sortable="true" class="text-nowrap text-center">Cost Unit</th>
           
            <!-- <th data-field="DeviceZone" data-sortable="true" class="text-nowrap">Device Zone</th> -->
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'RawData_' + today;
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
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>

