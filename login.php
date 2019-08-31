<?php
include 'config/db.php';

try {
    $sql = "SELECT SysStatus FROM tbl_system_control WHERE SysID = 2";

    $stmt = $norm_connect->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchColumn();
} catch (Exception $ex) {
    echo 'Error ' . $ex->getMessage();
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        
        <?php include 'head.php'; ?>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <img src="images/logo.png" class="img img-responsive center-block">
                <a href="#"><b>RMS (v.1.0.3)</b></a>     
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Report Management System (v.1.0.3)</p>
                <?php if ($res == 0) { ?>
                    <h2 style="text-align: center">Sorry!</h2>
                    <h6 style="text-align: center">The system will be available soon</h6>
                <?php } else { ?>

                    <form name="frmLogin" id="frmLogin"  method="POST">
                        <div class="form-group has-feedback">
                            <input type="text" name="Username" class="form-control" placeholder="Username EX:(sev.nin)" required>
                            <span class="fa fa-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="UserPassword" class="form-control" placeholder="Password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-success btn-lg btn-block btn-flat">Login</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>

            </div>
        </div>

        <?php include 'footer.php'; ?>
    </body>
</html>
