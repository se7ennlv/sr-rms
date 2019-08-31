<!-- Edit modal -->
<div class="modal fade edit-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Data </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form name="frmEdit" id="frmEdit" class="form-horizontal" novalidate="off">
                        <div class="form-group">
                            <label for="">Phone Number</label>
                            <input type="number" name="TeleNumber" class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="">Department</label>
                            <input type="text" name="TeleDept" class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" name="TeleLocation" class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="TeleUsername" class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>