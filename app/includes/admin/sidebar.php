<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://ui-avatars.com/api/?name=<?php echo $user->getFullName() ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="" class="d-block"><?php echo $user->getFullName() ?></a>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
            <?php if ($_SESSION['position_id'] === 1) : ?>
                <li class="nav-item menu-open
                <?php echo (strpos(CURRENT_URL, 'dashboard') !== false) ? 'active' : '' ?>
                ">
                    <a href="<?php echo 'dashboard.php' ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open
            <?php echo (strpos(CURRENT_URL, 'admin_user') !== false) ? 'active' : '' ?>
            ">
                    <a href="<?php echo 'admin_users.php' ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open
            <?php echo (strpos(CURRENT_URL, 'subject') !== false) ? 'active' : '' ?>
            ">
                    <a href="<?php echo 'subjects.php' ?>" class="nav-link ">
                        <i class="nav-icon fa fa-list-alt"></i>
                        <p>
                            Subjects
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-open
            <?php echo (strpos(CURRENT_URL, 'department') !== false) ? 'active' : '' ?>
            ">
                    <a href="<?php echo  'departments.php' ?>" class="nav-link">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Departments
                        </p>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION['position_id'] === 2) : ?>
                <li class="nav-item menu-open
                <?php echo (strpos(CURRENT_URL, 'faculty_dashboard') !== false) ? 'active' : '' ?>
                ">
                    <a href="faculty_dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open
                <?php echo (strpos(CURRENT_URL, 'profile') !== false) ? 'active' : '' ?>
                ">

                    <a href="setup_profile.php" class=" nav-link ">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open
                <?php echo (strpos(CURRENT_URL, 'result') !== false) ? 'active' : '' ?>
                ">
                    <a href="result.php" class=" nav-link ">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Monitoring Result
                        </p>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION['position_id'] === 3) : ?>
                <li class="nav-item menu-open
                <?php echo (strpos(CURRENT_URL, 'monitoring_dashboard.php') !== false) ? 'active' : '' ?>
                ">
                    <a href="faculty_dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="setup_profile.php" class=" nav-link
                    <?php echo (strpos(CURRENT_URL, 'profile.php') !== false) ? 'active' : '' ?>
                    ">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="analytics.php" class=" nav-link
                    <?php echo (strpos(CURRENT_URL, 'analytic.php') !== false) ? 'active' : '' ?>
                    ">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Analytics
                        </p>
                    </a>
                </li>
            <?php endif; ?>


        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>