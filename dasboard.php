<?php
include './config/db.php';
try {
    $sql = "SELECT * FROM ReportGroups ";
    $stmt = $rms_connect->prepare($sql);
    $stmt->execute();
    $dataArray = array();

    while ($res = $stmt->fetch(PDO::FETCH_NUM)) {
        $dataArray[] = $res;
    }
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}
$rms_connect = null;
?>
<section class="content">
    <div class="col-md-12">
        <div class="row">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <?php
                        $datas = array(1, 3, 4);
                        
                        foreach ($dataArray as $menu) { ?>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="media box-rpt" onclick="reportAction('<?= $menu[0] ?>','<?= $menu[5] ?>');">
                                            <div class="media-left media-middle">
                                                <a href="#">
                                                    <i class="<?= $menu[3] ?>"></i>
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading"> <?= $menu[2] ?> </h5><br>
                                                <a href="#" class="small-box-footer">Released on <?= $menu[4] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .fa-5x {
        font-size: 7em;
    }
</style>