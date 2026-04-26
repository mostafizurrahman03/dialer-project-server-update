<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("dbconnect_mysqli.php");

$ADD = isset($_GET['ADD']) ? $_GET['ADD'] : '';
$admin_user = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : '';

$admin_user_group = '';
$admin_user_level = '';

if (!empty($admin_user)) {
    $admin_user_sql = mysqli_real_escape_string($link, $admin_user);
    $sql = "SELECT user_group, user_level FROM vicidial_users WHERE user='$admin_user_sql' LIMIT 1";
    $rslt = mysqli_query($link, $sql);

    if ($rslt && mysqli_num_rows($rslt) > 0) {
        $row = mysqli_fetch_assoc($rslt);
        $admin_user_group = strtoupper(trim($row['user_group']));
        $admin_user_level = trim($row['user_level']);

        $_SESSION['admin_user_group'] = $admin_user_group;
        $_SESSION['admin_user_level'] = $admin_user_level;
    }
}

$groupMenuMap = array(
    'ADMIN' => array('dashboard','users','campaigns','lists','inbound','reports','usergroups','remoteagents','admin'),
    'SUPERVISOR' => array('dashboard','users','campaigns','lists','inbound','reports'),
    'REPORTS' => array('dashboard','reports'),
    'OPERATIONS' => array('dashboard','users','campaigns','lists','inbound','usergroups','remoteagents')
);

$defaultMenus = array('dashboard');

$allowedMenus = isset($groupMenuMap[$admin_user_group]) ? $groupMenuMap[$admin_user_group] : $defaultMenus;

function menu_allowed($key, $allowedMenus) {
    return in_array($key, $allowedMenus);
}

function is_active_add($adds, $ADD) {
    if (!is_array($adds)) {
        $adds = array($adds);
    }
    return in_array($ADD, $adds);
}

$dashboardActive   = ($ADD == '');
$usersActive       = is_active_add(array('0A'), $ADD);
$campaignsActive   = is_active_add(array('10'), $ADD);
$listsActive       = is_active_add(array('100'), $ADD);
$inboundActive     = is_active_add(array('1001'), $ADD);
$usergroupsActive  = is_active_add(array('100000'), $ADD);
$remoteagentsActive= is_active_add(array('10000'), $ADD);
$adminActive       = is_active_add(array('999998'), $ADD);
$reportsActive     = is_active_add(array('999999'), $ADD);

$mainOpen       = $dashboardActive;
$managementOpen = ($usersActive || $campaignsActive || $listsActive || $inboundActive || $usergroupsActive || $remoteagentsActive || $adminActive);
$analyticsOpen  = $reportsActive;

function getSidebarPageTitle($ADD) {
    $titles = array(
        ''        => 'Dashboard',
        '0A'      => 'Users',
        '10'      => 'Campaigns',
        '100'     => 'Lists',
        '1001'    => 'Inbound',
        '999999'  => 'Reports',
        '100000'  => 'User Groups',
        '10000'   => 'Remote Agents',
        '999998'  => 'Admin'
    );
    return isset($titles[$ADD]) ? $titles[$ADD] : 'Dashboard';
}

?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <span class="nav-link font-weight-bold" style="font-size: 18px; color:#2c3e50;">
                <?php echo htmlspecialchars(getSidebarPageTitle($ADD)); ?>
            </span>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link">
                <i class="fas fa-user-circle"></i>
                <?php echo htmlspecialchars($admin_user); ?>
                <?php if (!empty($admin_user_group)) { ?>
                    <small class="text-muted">[<?php echo htmlspecialchars($admin_user_group); ?>]</small>
                <?php } ?>
            </span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="new_admin.php" class="brand-link">
        <span class="brand-text font-weight-light">ADMIN PORTAL</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" role="menu">

                <?php if (menu_allowed('dashboard', $allowedMenus)) { ?>
                <li class="nav-item has-treeview <?php echo $mainOpen ? 'menu-open' : ''; ?>">
                    <a href="javascript:void(0);" class="nav-link tree-toggle <?php echo $mainOpen ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Main
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="<?php echo $mainOpen ? 'display:block;' : 'display:none;'; ?>">
                        <li class="nav-item">
                            <a href="new_admin.php" class="nav-link <?php echo $dashboardActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

                <?php if (
                    menu_allowed('users', $allowedMenus) ||
                    menu_allowed('campaigns', $allowedMenus) ||
                    menu_allowed('lists', $allowedMenus) ||
                    menu_allowed('inbound', $allowedMenus) ||
                    menu_allowed('usergroups', $allowedMenus) ||
                    menu_allowed('remoteagents', $allowedMenus) ||
                    menu_allowed('admin', $allowedMenus)
                ) { ?>
                <li class="nav-item has-treeview <?php echo $managementOpen ? 'menu-open' : ''; ?>">
                    <a href="javascript:void(0);" class="nav-link tree-toggle <?php echo $managementOpen ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="<?php echo $managementOpen ? 'display:block;' : 'display:none;'; ?>">

                        <?php if (menu_allowed('users', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=0A" class="nav-link <?php echo $usersActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (menu_allowed('campaigns', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=10" class="nav-link <?php echo $campaignsActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Campaigns</p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (menu_allowed('lists', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=100" class="nav-link <?php echo $listsActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lists</p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (menu_allowed('inbound', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=1001" class="nav-link <?php echo $inboundActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inbound</p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (menu_allowed('usergroups', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=100000" class="nav-link <?php echo $usergroupsActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Groups</p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (menu_allowed('remoteagents', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=10000" class="nav-link <?php echo $remoteagentsActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Remote Agents</p>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (menu_allowed('admin', $allowedMenus)) { ?>
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=999998" class="nav-link <?php echo $adminActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>
                <?php } ?>

                <?php if (menu_allowed('reports', $allowedMenus)) { ?>
                <li class="nav-item has-treeview <?php echo $analyticsOpen ? 'menu-open' : ''; ?>">
                    <a href="javascript:void(0);" class="nav-link tree-toggle <?php echo $analyticsOpen ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Analytics
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="<?php echo $analyticsOpen ? 'display:block;' : 'display:none;'; ?>">
                        <li class="nav-item">
                            <a href="new_admin.php?ADD=999999" class="nav-link <?php echo $reportsActive ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>

            </ul>
        </nav>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggles = document.querySelectorAll('.tree-toggle');

    for (var i = 0; i < toggles.length; i++) {
        toggles[i].addEventListener('click', function (e) {
            e.preventDefault();

            var parent = this.closest('.has-treeview');
            var submenu = parent.querySelector('.nav-treeview');

            if (parent.classList.contains('menu-open')) {
                parent.classList.remove('menu-open');
                this.classList.remove('active');
                if (submenu) submenu.style.display = 'none';
            } else {
                parent.classList.add('menu-open');
                this.classList.add('active');
                if (submenu) submenu.style.display = 'block';
            }
        });
    }
});
</script>