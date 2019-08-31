<section class="content-header">
    <form name="FrmSearchLog" id="FrmSearchLog" class="form-horizontal" autocomplete="off">
        <div class="col-lg-2" style="padding-left: 0">
            <div class="input-group">
                <input type="text" name="logDate" id="logDate" class="form-control datepicker" required>
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button" onclick="SearchLog()"><i class="fa fa-search"></i> Search</button>
                </span>
            </div>
        </div>
    </form>
</section>
<hr>
<section class="content">
    <div class="col-md-12">
        <div class="row">
            <div class="box box-success">
                <div class="box-header with-border" id="dataRespones">

                </div>
            </div>
        </div>
    </div>

</section>

<script type="text/javascript">
    function getCurDate() {
        var now = new Date();
        var today = now.format('yyyy-mm-dd');

        return today;
    }

    function SearchLog() {
        $.ajax({
            url: 'pages/SearchLog.php?logDate=' + $("#logDate").val(),
            success: function(data) {
                $("#dataRespones").html(data);
            }
        });

        return false;
    }

    $(document).ready(function() {
        $("#logDate").val(getCurDate());

        SearchLog()
    });

    var $url = "./script.js";
    $.getScript($url);
</script>