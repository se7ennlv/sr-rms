<header class="main-header">
    <a href="./" class="logo">
        <span class="logo-mini"><b>RMS</b></span>
        <span class="logo-lg"><b>RMS</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <a href="http://172.16.98.171/rms_dev/" class="pull-left" style="margin-top: 15px; color: #fff">
            <i class="fa fa-home"></i> Home
        </a>
        <div class="navbar-custom-menu"> 
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="http://172.16.98.171/rms_dev/controllers/logout.php" class="pull-right">
                        <i class="fa fa-sign-out"></i> Sign out
                    </a>
                    <a href="#" class="dropdown-toggle pull-right" data-toggle="dropdown">
                        <i class="fa fa-user fa-1x"></i>
                        <span class="hidden-xs">[ <?= $_SESSION['fname']; ?>&ensp;<?= $_SESSION['lname']; ?> ]</span>
                        <span class="hidden-xs" id="deptName">[ <?= $_SESSION['deptName']; ?> ]</span>
                        <span class="hidden-xs">[ <?= $_SESSION['roleName']; ?> ]</span>
                        <span style="display: none" id="deptID"><?= $_SESSION['deptID']; ?></span>
                        <span style="display: none" id="userId"><?= $_SESSION['uid']; ?></span>
                        <span style="display: none" id="roleId"><?= $_SESSION['roleID']; ?></span> 
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p>
                                <?= $_SESSION['fname']; ?>&ensp;<?= $_SESSION['lname']; ?> 
                                <small>Member since (<?= $_SESSION['createdAt']; ?>)</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat" onclick="updatePwd()"><i class="fa fa-refresh"></i> Change Password</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>