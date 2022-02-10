<div id="toolbar">
    <select class="form-control">
        <option value="">Export Only Page</option>
        <option value="all">Export All</option>
    </select>
</div>
<table id="myTable" data-toggle="table" data-url="./controllers/json_sum_month.php" data-pagination="true" data-page-size="25" data-click-to-select="true" data-page-list="[10, 25, 50, 100, ALL]" data-toolbar="#toolbar" data-show-export="true" data-show-refresh="true" data-show-columns="true">
    <thead>
        <tr>
            <th colspan="7" data-align="left"><strong>Savan Legend Resorts sole Company Limited.</strong></th>
        </tr>
        <tr></tr>
        <th colspan="7" data-align="left"><strong>Summary Month Report</strong></th>
        </tr>
        <tr>
            <th data-field="DeptName" data-sortable="true">Department</th>
            <th data-field="Location" data-sortable="true">Location</th>
            <th data-field="Questions" data-sortable="true">Questions</th>
            <th data-field="Rating" data-sortable="true">Rating</th>
            <th data-field="NoOfScorer" data-sortable="true">Number Of Scorer</th>
            <th data-field="AvgScore" data-sortable="true">Avg Score</th>
            <th data-field="AVG" data-sortable="true">AVG %</th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'RawReport_' + today;
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

    $table = $('#myTable').bootstrapTable({
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });
</script>