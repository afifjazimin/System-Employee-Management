<?php
include('../inc/topbar.php'); 
if(empty($_SESSION['login_email']))
    {   
      header("Location: ../Account/login.php"); 
    }

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($fullname); ?>'s Profile | <?php echo htmlspecialchars($sitename); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="../<?php echo htmlspecialchars($logo);?>">
    <style>
        :root {
            --surface: #ffffff;
            --border: #e6eaf2;
            --text: #0f172a;
            --muted: #64748b;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
            --primary: #0f172a;
            --primary-hover: #1e293b;
            --bg: #f6f7fb;
        }

        body.employee-dashboard {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--text);
        }
        
        #page-wrapper.gray-bg,
        #wrapper {
            background: var(--bg);
        }

        .profile-page-wrapper {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 991px) {
            .profile-page-wrapper {
                grid-template-columns: 1fr;
            }
        }

        .modern-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header-styled {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
        }

        .card-header-styled h3 {
            margin: 0;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
        }

        .profile-card-inner {
            text-align: center;
            padding: 2.5rem 1.5rem 2rem;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.12);
            margin-bottom: 1.5rem;
        }

        .profile-name {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text);
            margin: 0 0 0.35rem;
            line-height: 1.2;
        }

        .profile-role {
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 1.75rem;
        }
        
        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px dashed var(--border);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            font-weight: 700;
        }

        .stat-value {
            font-weight: 800;
            color: var(--text);
            font-size: 1.15rem;
        }

        .modern-edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .modern-edit-btn:hover {
            background: var(--primary-hover);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.15);
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-item {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid var(--border);
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item:hover {
            background: #f8fafc;
        }

        .info-label {
            color: var(--muted);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-label i {
            color: #94a3b8;
            width: 18px;
            text-align: center;
            font-size: 1.1rem;
        }

        .info-detail {
            color: var(--text);
            font-weight: 600;
            font-size: 1.05rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            background: #e2e8f0;
            color: #475569;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-warning {
            background: #fff7ed;
            color: #c2410c;
        }
        
        .status-danger {
            background: #fef2f2;
            color: #b91c1c;
        }

        @media (max-width: 767px) {
            .info-item {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 1rem 1.25rem;
            }
        }
    </style>
</head>

<body class="employee-dashboard">
    <div id="wrapper">
        <?php include('employee_sidebar_shell.php'); ?>
        <div id="page-wrapper" class="gray-bg">
        <?php
        $employeePageTitle = 'My Profile';
        $employeePageSubtitle = 'Review your personal details, payroll information, and current employment record in one place.';
        $employeeHeaderButtonLink = 'edit-profile.php';
        $employeeHeaderButtonLabel = 'Edit Profile';
        include('employee_header.php');
        ?>

        <div class="wrapper wrapper-content">
            <div class="profile-page-wrapper animated fadeInRight">
                
                <!-- Left Column: Profile Card -->
                <div class="modern-card">
                    <div class="profile-card-inner">
                        <img src="../<?php echo !empty($photo) ? htmlspecialchars($photo) : 'images/default_avatar.png'; ?>" alt="Profile avatar" class="profile-avatar">
                        <h2 class="profile-name"><?php echo htmlspecialchars($fullname); ?></h2>
                        <div class="profile-role"><?php echo htmlspecialchars(!empty($rowaccess['dept']) ? $rowaccess['dept'] : 'Staff'); ?> Department</div>
                        
                        <div class="profile-stats">
                            <div class="stat-item">
                                <span class="stat-label">Employee ID</span>
                                <span class="stat-value"><?php echo htmlspecialchars($employeeID); ?></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Status</span>
                                <span class="stat-value"><span class="status-badge status-active">Active</span></span>
                            </div>
                        </div>

                        <form method="post" action="edit-profile.php">
                            <button type="submit" class="modern-edit-btn">
                                <i class="fa fa-edit"></i> Edit Profile
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Personal Details -->
                <div class="modern-card">
                    <div class="card-header-styled">
                        <h3>Personal Information</h3>
                    </div>
                    <ul class="info-list">
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-user-circle"></i> Full Name</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['fullname'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-envelope"></i> Email Address</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['email'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-phone"></i> Phone Number</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['phone'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-venus-mars"></i> Sex</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['sex'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-birthday-cake"></i> Date of Birth</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['dob'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-map-marker"></i> Address</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['address'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-graduation-cap"></i> Qualification</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['qualification'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-building"></i> Department</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['dept'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-calendar-check-o"></i> Date of Appointment</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['date_appointment'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-briefcase"></i> Employee Type</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['employee_type'] ?? ''); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-money"></i> Basic Salary</div>
                            <div class="info-detail">N<?php echo number_format((float) $basic_salary, 2); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-credit-card"></i> Gross Pay</div>
                            <div class="info-detail">N<?php echo number_format((float) $gross_pay, 2); ?></div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-rocket"></i> Leave Status</div>
                            <div class="info-detail">
                                <?php 
                                    $leaveStatus = $rowaccess['leave_status'] ?? '';
                                    $leaveClass = 'status-badge';
                                    if ($leaveStatus === 'Approved') {
                                        $leaveClass .= ' status-active';
                                    } elseif ($leaveStatus === 'Pending') {
                                        $leaveClass .= ' status-warning';
                                    } elseif ($leaveStatus !== 'Not Available' && $leaveStatus !== '') {
                                        $leaveClass .= ' status-danger';
                                    }
                                ?>
                                <span class="<?php echo $leaveClass; ?>"><?php echo htmlspecialchars(!empty($leaveStatus) ? $leaveStatus : 'None'); ?></span>
                            </div>
                        </li>
                        <li class="info-item">
                            <div class="info-label"><i class="fa fa-lock"></i> Password</div>
                            <div class="info-detail"><?php echo htmlspecialchars($rowaccess['password'] ?? ''); ?></div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
            </div>
            <div>
            <?php include('../inc/footer.php');  ?>
            </div>
        </div>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Peity -->
    <script src="js/demo/peity-demo.js"></script>

</body>

</html>
