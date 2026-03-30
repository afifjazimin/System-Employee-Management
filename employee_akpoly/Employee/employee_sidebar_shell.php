<?php
$employeeShellName = !empty($fullname) ? $fullname : (!empty($rowaccess['fullname']) ? $rowaccess['fullname'] : (!empty($email) ? $email : 'Employee'));
$employeeShellEmail = !empty($email) ? $email : (!empty($rowaccess['email']) ? $rowaccess['email'] : 'employee@example.com');
$employeeShellPhoto = !empty($photo) ? $photo : (!empty($rowaccess['photo']) ? $rowaccess['photo'] : '');
$employeeSidebarAssetPrefix = isset($employeeSidebarAssetPrefix) ? $employeeSidebarAssetPrefix : '../';
$employeeSidebarMenuPath = isset($employeeSidebarMenuPath) ? $employeeSidebarMenuPath : __DIR__ . DIRECTORY_SEPARATOR . 'sidebar.php';
$employeeSidebarLogoutHref = isset($employeeSidebarLogoutHref) ? $employeeSidebarLogoutHref : 'logout.php';
$employeeSidebarPortalTitle = isset($employeeSidebarPortalTitle) ? $employeeSidebarPortalTitle : 'Employee Portal';
$employeeSidebarSiteName = !empty($sitename) ? $sitename : (isset($employeeSidebarSiteName) ? $employeeSidebarSiteName : 'Employee Workspace');

if (!function_exists('employeeSidebarInitials')) {
    function employeeSidebarInitials($name) {
        $parts = preg_split('/\s+/', trim((string)$name));
        $initials = '';
        foreach ($parts as $part) {
            if ($part !== '') {
                $initials .= strtoupper(substr($part, 0, 1));
            }
            if (strlen($initials) === 2) {
                break;
            }
        }
        return $initials !== '' ? $initials : 'EM';
    }
}
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse employee-sidebar">
        <div class="employee-brand">
            <span class="brand-mark"><i class="fa fa-th-large"></i></span>
            <span class="brand-copy">
                <strong><?php echo htmlspecialchars($employeeSidebarPortalTitle); ?></strong>
                <span><?php echo htmlspecialchars($employeeSidebarSiteName); ?></span>
            </span>
        </div>

        <div class="employee-profile">
            <?php if (!empty($employeeShellPhoto)) { ?>
                <img src="<?php echo htmlspecialchars($employeeSidebarAssetPrefix . $employeeShellPhoto); ?>" alt="<?php echo htmlspecialchars($employeeShellName); ?>">
            <?php } else { ?>
                <span class="employee-avatar-fallback"><?php echo employeeSidebarInitials($employeeShellName); ?></span>
            <?php } ?>
            <div>
                <div class="font-weight-bold"><?php echo htmlspecialchars($employeeShellName); ?></div>
                <small><?php echo htmlspecialchars($employeeShellEmail); ?></small>
            </div>
        </div>

        <ul class="nav metismenu" id="side-menu">
            <?php include($employeeSidebarMenuPath); ?>
        </ul>

        <div class="employee-sidebar-footer">
            <a href="<?php echo htmlspecialchars($employeeSidebarLogoutHref); ?>">
                <i class="fa fa-sign-out"></i>
                <span>Log out</span>
            </a>
        </div>
    </div>
</nav>
