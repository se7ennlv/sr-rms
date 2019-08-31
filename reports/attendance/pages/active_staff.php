
<div id="toolbar">
    <select class="form-control">
        <option value="">Export Only Page</option>
        <option value="selected">Export Selected</option>
        <option value="all">Export All</option>
    </select>
</div> 
<table id="myTable"
       data-toggle="table"
       data-url="./controllers/json_active_staff_data.php"
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
            <th colspan="7" data-align="left"><strong>Savan Legend Resorts sole  Company Limited.</strong></th>
        </tr>
        <tr>
            <th colspan="7" data-align="left"><strong>[ Active Sraff ] [ Inside Norming ]</strong></th>
        </tr>
        <tr>
            <!--<th data-field="state" data-checkbox="true"></th>-->
            <th data-field="HREMP_EMPCODE" data-sortable="true" class="text-nowrap">ID</th>
            <th data-field="HREMP_NAME" data-sortable="true" class="text-nowrap">NAME</th>
            <th data-field="HREMP_DEPT" data-sortable="true" class="text-nowrap">DEPARTMENT</th>
            <th data-field="HREMP_POSITION" data-sortable="true" class="text-nowrap">POSITION</th>
            <th data-field="HREMP_VILLAGE" data-sortable="true" class="text-nowrap">VILLAGE</th>
            <th data-field="HREMP_CITY" data-sortable="true" class="text-nowrap">CITY</th>
            <th data-field="HREMP_PROVINCE" data-sortable="true" class="text-nowrap">PROVINCE</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'ActiveStaffData_' + today;
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

