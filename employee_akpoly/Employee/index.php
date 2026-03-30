<?php
include('../inc/topbar.php');
if (empty($_SESSION['login_email'])) {
    header("Location: ../Account/login.php");
}

function employeeInitials($name) {
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

$employeeName = !empty($fullname) ? $fullname : (!empty($email) ? $email : 'Employee');
$leaveClass = 'status-danger';
$leaveIcon = 'fa-times-circle';
$leaveLabel = $leave_status;

if ($leave_status === 'Pending') {
    $leaveClass = 'status-warning';
    $leaveIcon = 'fa-clock';
} elseif ($leave_status !== 'Not Available') {
    $leaveClass = 'status-success';
    $leaveIcon = 'fa-check-circle';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard | <?php echo $sitename ;?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="../image/logo.jpeg">
    <style>
        :root {
            --dashboard-bg: #f6f7fb;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --border: #e6eaf2;
            --text: #0f172a;
            --muted: #64748b;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.05);
            --success-bg: #ecfdf3;
            --success-text: #16a34a;
            --warning-bg: #fff7ed;
            --warning-text: #d97706;
            --danger-bg: #fef2f2;
            --danger-text: #dc2626;
            --dark: #111111;
        }

        * {
            box-sizing: border-box;
        }

        body.employee-dashboard {
            background: var(--dashboard-bg);
            font-family: "Inter", sans-serif;
            color: var(--text);
            margin: 0;
        }

        #wrapper {
            min-height: 100vh;
            background: var(--dashboard-bg);
        }

        .navbar-default.navbar-static-side {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.96);
            border-right: 1px solid rgba(230, 234, 242, 0.95);
            box-shadow: none;
            transition: width 0.2s ease;
        }

        .sidebar-collapse {
            height: 100%;
        }

        .employee-sidebar {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 1.25rem 1.5rem;
            overflow-y: auto;
            overflow-x: hidden;
            transition: padding 0.2s ease;
        }

        .employee-brand {
            border-bottom: 1px solid var(--border);
            padding: 0 0.4rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #111827, #334155);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .brand-copy strong {
            font-size: 1rem;
            color: var(--text);
        }

        .brand-copy span {
            color: var(--muted);
            font-size: 0.85rem;
        }

        .employee-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.2rem 0.4rem 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .employee-profile img,
        .employee-avatar-fallback {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            flex: 0 0 auto;
        }

        .employee-profile img {
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.08);
        }

        .employee-avatar-fallback {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e2e8f0;
            color: #334155;
            font-weight: 700;
        }

        .employee-profile small {
            display: block;
            color: var(--muted);
            font-size: 0.82rem;
        }

        #side-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #side-menu > li {
            width: 100%;
            position: relative;
        }

        #side-menu > li > a {
            border-radius: 14px;
            color: #475569;
            font-weight: 600;
            font-size: 14px;
            line-height: 1.2;
            padding: 0.82rem 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
            text-decoration: none;
        }

        #side-menu > li > a .nav-label {
            font-size: inherit;
            line-height: inherit;
        }

        #side-menu > li > a:hover,
        #side-menu > li.active > a {
            background: #f1f5f9;
            color: var(--text);
        }

        #side-menu > li.active {
            background: transparent;
        }

        #side-menu > li.active > a {
            box-shadow: none;
        }

        #side-menu > li > a i {
            width: 1.25rem;
            text-align: center;
            font-size: 16px;
        }

        #side-menu > li > a .arrow {
            margin-left: auto;
            width: auto;
            font-size: 0.9rem;
        }

        #side-menu .nav-second-level {
            list-style: none;
            padding-left: 0.9rem;
            margin: 0 0 6px;
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        #side-menu .nav-second-level.collapse {
            display: none;
        }

        #side-menu .nav-second-level.collapse.in {
            display: block;
        }

        #side-menu .nav-second-level li a {
            display: block;
            color: var(--muted);
            padding: 0.7rem 0.95rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            background: transparent;
        }

        #side-menu .nav-second-level li a:hover {
            background: #f8fafc;
            color: var(--text);
        }

        #side-menu .nav-second-level li.active a,
        #side-menu .nav-second-level li a:focus {
            background: #f1f5f9;
            color: var(--text);
        }

        .metismenu .collapse.in {
            background: transparent !important;
        }

        .metismenu .collapse.in > li,
        .metismenu .collapsing > li {
            background: transparent !important;
        }

        .metismenu .collapsing {
            background: transparent !important;
        }

        .employee-sidebar-footer {
            margin-top: auto;
            padding: 0.75rem 0.4rem 0;
        }

        .employee-sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 44px;
            padding: 0 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            color: #b91c1c;
            background: #fff5f5;
            border: 1px solid #fecaca;
        }

        body.mini-navbar .navbar-default.navbar-static-side {
            width: 82px;
        }

        body.mini-navbar #page-wrapper {
            margin-left: 82px;
        }

        body.mini-navbar .employee-sidebar {
            padding: 1rem 0.85rem;
        }

        body.mini-navbar .brand-copy,
        body.mini-navbar .employee-profile > div,
        body.mini-navbar #side-menu > li > a .nav-label,
        body.mini-navbar #side-menu > li > a .arrow,
        body.mini-navbar .employee-sidebar-footer a span {
            display: none;
        }


        body.mini-navbar #side-menu > li > a i {
            width: 1.25rem;
            min-width: 1.25rem;
            margin: 0;
            font-size: 16px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:not(:hover) #side-menu .nav-second-level {
            position: absolute;
            top: 0;
            left: calc(100% - 8px);
            z-index: 1005;
            min-width: 220px;
            margin: 0;
            padding: 0.7rem;
            background: #ffffff !important;
            border: 1px solid var(--border) !important;
            border-radius: 16px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12) !important;
        }

        body.mini-navbar .navbar-default.navbar-static-side:not(:hover) #side-menu .nav-second-level.collapse {
            display: none !important;
        }

        body.mini-navbar .navbar-default.navbar-static-side:not(:hover) #side-menu > li:hover > .nav-second-level,
        body.mini-navbar .navbar-default.navbar-static-side:not(:hover) #side-menu > li:focus-within > .nav-second-level,
        body.mini-navbar .navbar-default.navbar-static-side:not(:hover) #side-menu > li.active > .nav-second-level.in {
            display: block !important;
        }

        body.mini-navbar .navbar-default.navbar-static-side:not(:hover) #side-menu .nav-second-level li a {
            padding-left: 0.85rem;
            padding-right: 0.85rem;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover {
            width: 250px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover + #page-wrapper {
            margin-left: 250px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover .brand-copy,
        body.mini-navbar .navbar-default.navbar-static-side:hover .employee-profile > div,
        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu > li > a .nav-label,
        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu > li > a .arrow,
        body.mini-navbar .navbar-default.navbar-static-side:hover .employee-sidebar-footer a span {
            display: inline-block;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover .employee-sidebar {
            padding: 1.25rem 1.5rem;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover .brand-copy {
            display: flex;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover .employee-brand,
        body.mini-navbar .navbar-default.navbar-static-side:hover .employee-profile {
            justify-content: flex-start;
            width: 100%;
            padding-left: 0.4rem;
            padding-right: 0.4rem;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu > li > a {
            justify-content: flex-start;
            width: 100%;
            padding: 0.82rem 0.95rem;
            margin-left: 0;
            margin-right: 0;
            min-height: 0;
            font-size: 14px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover .employee-sidebar-footer a {
            justify-content: flex-start;
            width: 100%;
            padding: 0 14px;
            margin-left: 0;
            margin-right: 0;
            min-height: 44px;
            font-size: 14px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu > li > a i,
        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu > li > a .nav-label {
            font-size: 14px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu > li > a i {
            font-size: 16px;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu .nav-second-level.in {
            display: block !important;
        }

        body.mini-navbar .navbar-default.navbar-static-side:hover #side-menu .nav-second-level {
            position: static;
            left: auto;
            top: auto;
            min-width: 0;
            padding-left: 0.9rem;
            padding-right: 0;
            border: 0 !important;
            border-radius: 0;
            box-shadow: none !important;
        }

        #page-wrapper {
            margin: 0 0 0 250px;
            min-height: 100vh;
            flex: 1;
            background: var(--dashboard-bg);
            overflow-x: hidden;
            transition: margin-left 0.2s ease;
        }

        .employee-header {
            background: rgba(255, 255, 255, 0.88);
            border-bottom: 1px solid rgba(230, 234, 242, 0.95);
            backdrop-filter: blur(12px);
            box-shadow: none;
            padding: 0.8rem 1.35rem;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .employee-header .minimalize-styl-2 {
            margin: 0;
            width: 54px;
            height: 46px;
            padding: 0;
            background: #ffffff !important;
            border: 1px solid #d7e0eb !important;
            border-radius: 10px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .employee-header .minimalize-styl-2 i {
            margin: 0;
            color: #5f7494;
            font-size: 1.35rem;
        }

        .employee-header .minimalize-styl-2:hover,
        .employee-header .minimalize-styl-2:focus {
            background: #f8fbff !important;
            border-color: #c8d5e4 !important;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        .header-search {
            position: relative;
            width: min(100%, 320px);
        }

        .header-search input {
            width: 100%;
            height: 46px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #fff;
            padding: 0 46px 0 18px;
            color: var(--text);
        }

        .header-search i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .header-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            padding: 0 18px;
            border-radius: 10px;
            background: var(--dark);
            color: #fff;
            font-weight: 700;
            text-decoration: none;
            border: 0;
            white-space: nowrap;
        }

        .header-button:hover {
            color: #fff;
            text-decoration: none;
            background: #222;
        }

        .wrapper.wrapper-content {
            padding: 1.2rem;
        }

        .dashboard-hero {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 1.25rem;
        }

        .dashboard-hero h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: var(--text);
        }

        .dashboard-hero p {
            margin: 0.35rem 0 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 1.4rem;
        }

        .dashboard-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .stat-card {
            padding: 1.4rem 1.45rem;
        }

        .stat-head {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #f8fafc;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-value {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 2.1rem;
            line-height: 1.1;
            font-weight: 700;
            color: var(--text);
        }

        .stat-note {
            margin-top: 8px;
            font-size: 0.95rem;
            color: var(--muted);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 36px;
            padding: 0 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .status-pill::before {
            content: "";
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-success {
            color: var(--success-text);
            background: var(--success-bg);
        }

        .status-warning {
            color: var(--warning-text);
            background: var(--warning-bg);
        }

        .status-danger {
            color: var(--danger-text);
            background: var(--danger-bg);
        }

        .employee-summary {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 20px;
        }

        .profile-card {
            padding: 1.45rem;
        }

        .profile-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 1rem;
        }

        .profile-top img,
        .profile-fallback {
            width: 68px;
            height: 68px;
            border-radius: 16px;
            object-fit: cover;
            flex: 0 0 auto;
        }

        .profile-fallback {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e2e8f0;
            color: #334155;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .profile-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .profile-email {
            color: var(--muted);
            margin-top: 4px;
        }

        .profile-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0 0;
        }

        .profile-list li {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 0.95rem 0;
            border-top: 1px solid #eef2f7;
            color: var(--muted);
        }

        .profile-list li strong {
            color: var(--text);
            font-weight: 700;
        }

        .quick-actions {
            padding: 1.45rem;
        }

        .quick-actions h3 {
            margin: 0 0 1rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
        }

        .quick-links {
            display: grid;
            gap: 12px;
        }

        .quick-links a {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 52px;
            padding: 0 16px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            border: 1px solid var(--border);
            background: #fff;
        }

        .quick-links a:hover {
            background: #f8fafc;
        }

        .page-footer {
            padding: 1rem 1.2rem 1.5rem;
            color: var(--muted);
        }

        @media (max-width: 1199px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .employee-summary {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 991px) {
            .employee-header {
                flex-wrap: wrap;
            }

            .header-actions,
            .header-search {
                width: 100%;
            }

            #wrapper {
                display: block;
            }

            .navbar-default.navbar-static-side {
                width: 100%;
                position: relative;
                border-right: 0;
                border-bottom: 1px solid rgba(230, 234, 242, 0.95);
            }

            #page-wrapper,
            body.mini-navbar #page-wrapper,
            body.mini-navbar .navbar-default.navbar-static-side:hover + #page-wrapper {
                margin-left: 0;
            }

            body.mini-navbar .navbar-default.navbar-static-side,
            body.mini-navbar .navbar-default.navbar-static-side:hover {
                width: 100%;
            }

            body.mini-navbar .brand-copy,
            body.mini-navbar .employee-profile > div,
            body.mini-navbar #side-menu > li > a .nav-label,
            body.mini-navbar #side-menu > li > a .arrow,
            body.mini-navbar .employee-sidebar-footer a span {
                display: inline;
            }

            body.mini-navbar .employee-brand,
            body.mini-navbar .employee-profile,
            body.mini-navbar #side-menu > li > a,
            body.mini-navbar .employee-sidebar-footer a {
                justify-content: flex-start;
            }

            body.mini-navbar #side-menu .nav-second-level.in {
                display: block !important;
            }
        }

        @media (max-width: 767px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .wrapper.wrapper-content {
                padding: 1rem;
            }

            .dashboard-hero {
                flex-direction: column;
            }
        }
    </style>
</head>
<body class="employee-dashboard">
    <div id="wrapper">
        <?php include('employee_sidebar_shell.php'); ?>

        <div id="page-wrapper">
            <?php
            $employeePageTitle = 'Employee Overview';
            $employeePageSubtitle = 'Review your payroll details, track leave status, and manage your employee account from one modern dashboard.';
            $employeeHeaderButtonLink = 'profile.php';
            $employeeHeaderButtonLabel = 'My Profile';
            include('employee_header.php');
            ?>

            <div class="wrapper wrapper-content">
                <div class="stats-grid">
                    <div class="dashboard-card stat-card">
                        <div class="stat-head">
                            <span class="stat-icon"><i class="fa fa-id-card-o"></i></span>
                            <span>Employee ID</span>
                        </div>
                        <div class="stat-value"><?php echo $employeeID; ?></div>
                        <div class="stat-note">Your unique staff reference</div>
                    </div>

                    <div class="dashboard-card stat-card">
                        <div class="stat-head">
                            <span class="stat-icon"><i class="fa fa-money"></i></span>
                            <span>Basic Salary</span>
                        </div>
                        <div class="stat-value">N<?php echo number_format((float) $basic_salary, 2); ?></div>
                        <div class="stat-note">Monthly base compensation</div>
                    </div>

                    <div class="dashboard-card stat-card">
                        <div class="stat-head">
                            <span class="stat-icon"><i class="fa fa-credit-card"></i></span>
                            <span>Gross Pay</span>
                        </div>
                        <div class="stat-value">N<?php echo number_format((float) $gross_pay, 2); ?></div>
                        <div class="stat-note">Total earnings before deductions</div>
                    </div>

                    <div class="dashboard-card stat-card">
                        <div class="stat-head">
                            <span class="stat-icon"><i class="fa <?php echo $leaveIcon; ?>"></i></span>
                            <span>Leave Status</span>
                        </div>
                        <div class="status-pill <?php echo $leaveClass; ?>"><?php echo $leaveLabel; ?></div>
                        <div class="stat-note">Current leave application state</div>
                    </div>
                </div>

                <div class="employee-summary">
                    <div class="dashboard-card profile-card">
                        <div class="profile-top">
                            <?php if (!empty($photo)) { ?>
                                <img src="../<?php echo $photo; ?>" alt="<?php echo htmlspecialchars($employeeName); ?>">
                            <?php } else { ?>
                                <span class="profile-fallback"><?php echo employeeInitials($employeeName); ?></span>
                            <?php } ?>
                            <div>
                                <h2 class="profile-name"><?php echo htmlspecialchars($employeeName); ?></h2>
                                <div class="profile-email"><?php echo htmlspecialchars($email); ?></div>
                            </div>
                        </div>

                        <ul class="profile-list">
                            <li>
                                <span>Employee ID</span>
                                <strong><?php echo $employeeID; ?></strong>
                            </li>
                            <li>
                                <span>Basic Salary</span>
                                <strong>N<?php echo number_format((float) $basic_salary, 2); ?></strong>
                            </li>
                            <li>
                                <span>Gross Pay</span>
                                <strong>N<?php echo number_format((float) $gross_pay, 2); ?></strong>
                            </li>
                            <li>
                                <span>Leave Status</span>
                                <strong><?php echo $leave_status; ?></strong>
                            </li>
                        </ul>
                    </div>

                    <div class="dashboard-card quick-actions">
                        <h3>Quick Actions</h3>
                        <div class="quick-links">
                            <a href="profile.php"><i class="fa fa-user"></i><span>View Profile</span></a>
                            <a href="edit-profile.php"><i class="fa fa-edit"></i><span>Edit Profile</span></a>
                            <a href="apply_leave.php"><i class="fa fa-calendar-plus-o"></i><span>Apply for Leave</span></a>
                            <a href="leave_history.php"><i class="fa fa-history"></i><span>Leave History</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-footer">
                <?php include('../inc/footer.php'); ?>
            </div>
        </div>
    </div>

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
</body>
</html>
