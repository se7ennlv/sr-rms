<?php
include '../../../config/db.php';

try {
    $sql = "SELECT LVLEAVE_LEAVECODE FROM LVLEAVE";
    $stmt = $psa_connect->prepare($sql);
    $stmt->execute();
} catch (Exception $ex) {
    
}
?>


<div class="modal fade search-leave" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 4px; text-align: center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-grain"></i> <strong>Search Roster by Period</strong> <i class="glyphicon glyphicon-grain"></i></h4>
            </div>
            <div class="modal-body">
                <form name="FrmSearchLeave" id="FrmSearchLeave" class="form-inline" novalidate="off">
                    <section class="text-center">
                        <div class="form-group">
                            <select class="form-control input-sm" name="leaveCode" required>
                                <option value="">Select Leave Code</option>

                                <?php while ($res = $stmt->fetch(PDO::FETCH_NUM)) {
                                    echo "<option value='$res[0]'>$res[0]</option>";
                                } ?>

                            </select>
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
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
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

