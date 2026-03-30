<?php
$employeePageTitle = isset($employeePageTitle) ? $employeePageTitle : 'Employee Workspace';
$employeePageSubtitle = isset($employeePageSubtitle) ? $employeePageSubtitle : 'Manage your account and daily employee tasks from one clean workspace.';
$employeeHeaderButtonLink = isset($employeeHeaderButtonLink) ? $employeeHeaderButtonLink : 'profile.php';
$employeeHeaderButtonLabel = isset($employeeHeaderButtonLabel) ? $employeeHeaderButtonLabel : 'My Profile';
?>
<nav class="employee-header" role="navigation">
    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>

    <div class="header-actions">
        <div class="header-search">
            <input type="search" placeholder="Search workspace..." aria-label="Search workspace">
            <i class="fa fa-search"></i>
        </div>
        <a href="<?php echo htmlspecialchars($employeeHeaderButtonLink); ?>" class="header-button">
            <i class="fa fa-user"></i>
            <span><?php echo htmlspecialchars($employeeHeaderButtonLabel); ?></span>
        </a>
    </div>
</nav>

<section class="employee-page-hero-wrap">
    <div class="dashboard-hero employee-page-hero">
        <div>
            <h1><?php echo htmlspecialchars($employeePageTitle); ?></h1>
            <p><?php echo htmlspecialchars($employeePageSubtitle); ?></p>
        </div>
    </div>
</section>
