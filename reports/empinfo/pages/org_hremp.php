<?php
session_start();
$orgID = $_POST['orgID'];
?>

<div id="toolbar">
    <select class="form-control">
        <option value="all">Export All</option>
        <option value="">Export Only Page</option>
    </select>
</div>
<table id="myTable" data-toggle="table" data-url="./controllers/json_hremp.php?orgID=<?= $orgID; ?>" data-pagination="true" data-page-size="All" data-click-to-select="true" data-page-list="[10, 25, 50, 100, ALL]" data-search="true" data-height="650" data-toolbar="#toolbar" data-show-export="true" data-show-refresh="true" data-show-columns="true">
    <thead>
        <tr>
            <th colspan="16" data-align="left"><strong>Savan Legend Resorts sole Company Limited.</strong></th>
        </tr>

        <tr>
            <!-- <th data-field="operate" data-align="center" data-sortable="true"  data-events="operateEvents" data-formatter="showName">EMP ID </th> -->
            <th data-field="HREMP_EMPCODE" data-sortable="true" >EMP ID</th>
            <th data-field="HREMP_FNAME" data-sortable="true" >First Name</th>
            <th data-field="HREMP_LNAME" data-sortable="true" >Last name</th>
            <th data-field="ASORG_ORGNAME" data-sortable="true" >Department</th>
            <th class="text-nowrap" data-field="HRJOB_JOBNAME" data-sortable="true" >Position</th>
            <th data-field="HREMP_HIREDAY" data-sortable="true" >Hired date</th>
            <th data-field="HREMP_SSN" data-sortable="true" >SSO</th>
            <th data-field="ADDRESS" data-sortable="true" >Address </th>
            <th data-field="HREMP_PHONEC" data-sortable="true" >Contact Number </th>
            <th data-field="HREMP_NATION" data-sortable="true" >Citizen </th>
            <th data-field="ASSCODE_DESCRIP" data-sortable="true" >Country </th>
            <th data-field="MSTATUS" data-sortable="true" >Marital Status </th>
            <th data-field="HREMP_LANGUAGE" data-sortable="true" >First Language </th>
            <th data-field="HREMPEDU_SCHOOL" data-sortable="true" >History of Education</th>
            <th > History of work experience </th>
           <!-- <th data-field="HREMP_DEGREE" data-sortable="true" >experience </th> -->
          <th data-field="operate" data-align="center"   data-events="operateEvents" data-formatter="operateFormatter">Photos</th>

        </tr>
    </thead>
</table>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format("isoDateTime");
        return 'SuccessData_' + today;
    }

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
        undefinedText: '',
        showExport: true,
        exportTypes: ['excel', 'csv'],
        exportOptions: {
            fileName: getCurDate()
        }
    });

    function operateFormatter(value, row, index) {
        return [
            '<a class="view-photo" href="javascript:void(0)" title="See Photo" data-unique-id="', row.id, '" data-toggle="modal" data-target=".photo-modal">', '<i class="fa fa-picture-o"></i>', '</a>  '

        ].join('');
    }

    function showName(value, row, index) {
        return [
            '<img src="http://172.16.98.81:8090/psa/files/' + row.FILENAME +'" class="img-circle" alt="User Image" style="height: 35px;width: 35px"> <p>'+ row.HREMP_EMPCODE +'</p>'
          
        ].join('');
    }

  
</script>