<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">

                <div class="profile-element">
                    <img src="<?php echo base_url();?>inspinia_admin/img/logo/logo.png">
                    <h3 class="logo-sub"><?php echo $username; ?></h3>
                </div>
                <div class="logo-element">
                    KinPix
                </div>
            </li>

            <li <?php if ($side_menu == 'home') echo "class=\"active\""; ?>>
                <a href="<?php echo site_url("admin/search_user/0"); ?>"><i class="fa fa-home"></i> <span class="nav-label">Home </span></a>
            </li>

            <li <?php if ($side_menu == 'flag_photo') echo "class=\"active\""; ?>>
                <a href="<?php echo site_url("admin/flag_photo/0"); ?>"><i class="fa fa-exclamation-circle"></i> <span class="nav-label">Flag Photos </span></a>
            </li>

            <li <?php if ($side_menu == 'admins') echo "class=\"active\""; ?>>
                <a href="<?php echo site_url("admin/admins/0"); ?>"><i class="fa fa-users"></i> <span class="nav-label">Admin Users </span></a>
            </li>

            <li <?php if ($side_menu == 'setting') echo "class=\"active\""; ?>>
                <a href="<?php echo site_url("admin/setting"); ?>"><i class="fa fa-gears"></i><span class="nav-label">Admin Settings </span></a>
            </li>

            <li <?php if ($side_menu == 'about' || $side_menu == 'help' || $side_menu == 'feedback' || $side_menu == 'privacy' || $side_menu == 'terms') echo "class=\"active\""; ?>>
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span class="nav-label">Settings Screens </span>
                    <span class="fa arrow"></span>
                </a>

                <ul class="nav nav-second-level">
                    <li <?php if ($side_menu == 'about') echo "class=\"active\""; ?>>
                        <a href="<?php echo site_url("admin/about"); ?>">About Us</a>
                    </li>
                    <li <?php if ($side_menu == 'help') echo "class=\"active\""; ?>>
                        <a href="<?php echo site_url("admin/help"); ?>">Help</a>
                    </li>
                    <li <?php if ($side_menu == 'feedback') echo "class=\"active\""; ?>>
                        <a href="<?php echo site_url("admin/feedback"); ?>">Feedback</a>
                    </li>
                    <li <?php if ($side_menu == 'privacy') echo "class=\"active\""; ?>>
                        <a href="<?php echo site_url("admin/privacy"); ?>">Privacy</a>
                    </li>
                    <li <?php if ($side_menu == 'terms') echo "class=\"active\""; ?>>
                        <a href="<?php echo site_url("admin/terms"); ?>">Terms</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
