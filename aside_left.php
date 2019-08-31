<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <i class="fa fa-user fa-3x" style="color: #fff;"></i>
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['EmpFname']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <?php if ($_SESSION['roleID'] == 1) { ?>
                <li class="active"><a><span><i class="fa fa-lock"></i> Admin</span></a></li>
                <li><a href="#" onclick="AddUser()"><span>Users Managiment</span></a></li>
                <li><a href="#" onclick="LogAccessSystem()"><span>Log</span></a></li>
            <?php } ?>
        </ul>
    </section>
</aside>