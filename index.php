<?php include './config/session.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title>RMS</title>
        <?php include 'head.php' ?>
    </head>
    <body class="hold-transition skin-green sidebar-collapse">
        <div class="wrapper">
            <?php include 'header.php'; ?>

            <?php include 'aside_left.php'; ?>

            <div class="content-wrapper" id="mainContent">
                <section class="content-header">
                    <h1>
                        Reports Management System 
                    </h1>
                </section>

                <!-- Main content -->
                <?php include 'dasboard.php'; ?>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs" style="color: red">
                    <strong>Developed By IT</strong>
                </div>
                <strong>Version 1.0.3</strong> 
            </footer>
        </div>

        <?php include 'footer.php' ?>

    </body>
</html>