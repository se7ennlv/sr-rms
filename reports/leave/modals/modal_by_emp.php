<div class="modal fade empid" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 4px; text-align: center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-grain"></i> <strong>Search By Employee ID</strong> <i class="glyphicon glyphicon-grain"></i></h4>
            </div>
            <div class="modal-body">
                <form name="FrmEmpId" id="FrmEmpId" class="form-inline" novalidate="off">
                    <section class="text-center">
                        <div class="form-group">
                            <label for="">Employee ID:</label>
                            <input type="number" name="empID" class="form-control" required style="width: 120px;">
                        </div>
                        <div class="form-group">
                            <label for="">Form Date:</label>
                            <input type="text" name="fromDate" class="form-control datepicker input-sm" required readonly style="width: 120px;">
                        </div>
                        <div class="form-group">
                            <label for="">To Date:</label>
                            <input type="text" name="toDate" class="form-control datepicker input-sm" required readonly style="width: 120px;">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Go</button>
                        </div>
                    </section>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script src="./script.js" type="text/javascript"></script>