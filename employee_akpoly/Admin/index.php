<?php
include('../inc/topbar.php');
if (empty($_SESSION['admin-username'])) {
    header("Location: login.php");
}

function dashboardCount(mysqli $conn, $query) {
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_num_rows($result) : 0;
}

function dashboardInitials($name) {
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
    return $initials !== '' ? $initials : 'NA';
}

$row_no_employee = dashboardCount($conn, "SELECT * FROM tblemployee");
$row_no_leave = dashboardCount($conn, "SELECT * FROM tblleave");
$row_no_leave_approved = dashboardCount($conn, "SELECT * FROM tblleave WHERE status = 'Approved'");
$row_no_leave_declined = dashboardCount($conn, "SELECT * FROM tblleave WHERE status = 'Declined'");

$employeeRows = [];
$employeeResult = mysqli_query($conn, "SELECT fullname, email, dept, employee_type, status, leave_status, photo FROM tblemployee ORDER BY employeeID DESC LIMIT 5");
if ($employeeResult) {
    while ($row = mysqli_fetch_assoc($employeeResult)) {
        $employeeRows[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard | <?php echo $sitename ; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/admin-custom.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <link rel="shortcut icon" href="../<?php echo $logo ;  ?>" type="image/x-png" />
  <style>
    :root {
      --dashboard-bg: #f6f7fb;
      --surface: #ffffff;
      --surface-soft: #f8fafc;
      --border: #e6eaf2;
      --text: #0f172a;
      --muted: #64748b;
      --shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
      --success-bg: #ecfdf3;
      --success-text: #16a34a;
      --warning-bg: #fff7ed;
      --warning-text: #d97706;
      --danger-bg: #fef2f2;
      --danger-text: #dc2626;
      --dark: #111111;
    }

    body.admin-dashboard {
      background: var(--dashboard-bg);
      font-family: "Source Sans Pro", sans-serif;
    }

    body.admin-dashboard .wrapper {
      min-height: 100vh;
      background: var(--dashboard-bg);
    }

    body.admin-dashboard .main-header {
      background: rgba(255, 255, 255, 0.88);
      border-bottom: 1px solid rgba(230, 234, 242, 0.95);
      backdrop-filter: blur(12px);
      box-shadow: none;
      padding: 0.8rem 1.35rem;
    }

    body.admin-dashboard .main-header .nav-link {
      color: var(--muted);
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

    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-left: auto;
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

    body.admin-dashboard .main-sidebar {
      background: rgba(255, 255, 255, 0.96);
      border-right: 1px solid rgba(230, 234, 242, 0.95);
      box-shadow: none;
    }

    body.admin-dashboard .brand-link {
      border-bottom: 1px solid var(--border);
      padding: 1rem 1.2rem;
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--text);
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

    body.admin-dashboard .sidebar {
      padding: 1rem 0.85rem;
      display: flex;
      flex-direction: column;
      height: calc(100% - 74px);
    }

    .sidebar-profile {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.2rem 0.4rem 1rem;
      margin-bottom: 1rem;
      border-bottom: 1px solid var(--border);
    }

    .sidebar-profile img {
      width: 48px;
      height: 48px;
      object-fit: cover;
      border-radius: 16px;
      border: 2px solid #fff;
      box-shadow: 0 8px 16px rgba(15, 23, 42, 0.08);
    }

    .sidebar-profile small {
      display: block;
      color: var(--muted);
      font-size: 0.82rem;
    }

    body.admin-dashboard .form-control-sidebar,
    body.admin-dashboard .btn-sidebar {
      border-radius: 14px;
      border-color: var(--border);
      background: var(--surface-soft);
      color: var(--text);
    }

    body.admin-dashboard .form-control-sidebar::placeholder {
      color: #94a3b8;
    }

    body.admin-dashboard .nav-sidebar .nav-link {
      border-radius: 14px;
      color: #475569;
      font-weight: 600;
      padding: 0.82rem 0.95rem;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 6px;
    }

    body.admin-dashboard .nav-sidebar .nav-link .nav-icon {
      margin-right: 0;
      width: 1.25rem;
      text-align: center;
      font-size: 1rem;
    }

    body.admin-dashboard .nav-sidebar .nav-link.active,
    body.admin-dashboard .nav-sidebar .nav-link:hover {
      background: #f1f5f9;
      color: var(--text);
      box-shadow: none;
    }

    body.admin-dashboard .nav-treeview {
      padding-left: 0.65rem;
    }

    body.admin-dashboard .nav-treeview > .nav-item > .nav-link {
      font-weight: 500;
      padding: 0.72rem 0.9rem;
    }

    .nav-item-spacer {
      flex: 1 1 auto;
      min-height: 14px;
    }

    .logout-link {
      color: #b91c1c !important;
      background: #fff5f5;
    }

    .logout-link:hover {
      background: #fee2e2 !important;
      color: #991b1b !important;
    }

    body.admin-dashboard .content-wrapper {
      background: var(--dashboard-bg);
      padding: 1.2rem;
    }

    body.admin-dashboard .content-header {
      padding: 0 0 1rem;
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

    .dashboard-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 12px;
      box-shadow: var(--shadow);
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 20px;
      margin-bottom: 1.4rem;
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
      font-size: 2.4rem;
      line-height: 1;
      font-weight: 700;
      color: var(--text);
    }

    .stat-pill {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 28px;
      padding: 0 10px;
      border-radius: 999px;
      font-size: 0.88rem;
      font-weight: 700;
    }

    .pill-success {
      background: var(--success-bg);
      color: var(--success-text);
    }

    .pill-warning {
      background: var(--warning-bg);
      color: var(--warning-text);
    }

    .toolbar-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      margin-bottom: 1.25rem;
    }

    .toolbar-filters {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .toolbar-chip {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
      min-height: 44px;
      padding: 0 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--text);
      font-weight: 600;
      box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }

    .employee-table-card {
      overflow: hidden;
    }

    .table-responsive {
      margin: 0;
    }

    .employee-table {
      width: 100%;
      margin-bottom: 0;
    }

    .employee-table thead th {
      border-bottom: 1px solid var(--border);
      border-top: 0;
      color: var(--muted);
      font-size: 0.95rem;
      font-weight: 700;
      padding: 1rem 1.3rem;
    }

    .employee-table tbody td {
      border-top: 1px solid #eef2f7;
      padding: 1rem 1.3rem;
      vertical-align: middle;
      color: var(--text);
      font-size: 1rem;
    }

    .employee-meta {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .employee-avatar,
    .employee-avatar-fallback {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      flex: 0 0 auto;
    }

    .employee-avatar {
      object-fit: cover;
    }

    .employee-avatar-fallback {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #e2e8f0;
      color: #334155;
      font-weight: 700;
    }

    .employee-name {
      font-weight: 700;
      color: var(--text);
      line-height: 1.15;
    }

    .employee-email {
      color: var(--muted);
      margin-top: 2px;
      font-size: 0.95rem;
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      min-height: 30px;
      padding: 0 12px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 0.92rem;
    }

    .status-badge::before {
      content: "";
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: currentColor;
    }

    .status-active {
      background: var(--success-bg);
      color: var(--success-text);
    }

    .status-leave {
      background: var(--warning-bg);
      color: var(--warning-text);
    }

    .status-inactive {
      background: var(--danger-bg);
      color: var(--danger-text);
    }

    .table-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      padding: 1.2rem 1.3rem 1.35rem;
      border-top: 1px solid var(--border);
      color: var(--muted);
      font-weight: 600;
    }

    .table-pagination {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .table-page {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background: #fff;
      color: var(--text);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
    }

    body.admin-dashboard .main-footer {
      background: transparent;
      border-top: 0;
      color: var(--muted);
      padding: 1rem 1.2rem 1.5rem;
    }

    @media (max-width: 1199px) {
      .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }

    @media (max-width: 991.98px) {
      .dashboard-hero,
      .toolbar-row {
        flex-direction: column;
        align-items: stretch;
      }

      .header-actions {
        width: 100%;
      }

      .header-search {
        width: 100%;
      }
    }

    @media (max-width: 767.98px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }

      .table-footer {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed admin-dashboard">
<div class="wrapper">

  <?php include('admin_header.php'); ?>

  <?php include('admin_sidebar_shell.php'); ?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="dashboard-hero">
        <div>
          <h1>Team Overview</h1>
          <p>Track employee volume, leave activity, and the latest staff records from one clean dashboard.</p>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid px-0">
        <div class="stats-grid">
          <div class="dashboard-card stat-card">
            <div class="stat-head">
              <span class="stat-icon"><i class="fas fa-users"></i></span>
              <span>Total Employees</span>
            </div>
            <div class="stat-value"><?php echo $row_no_employee; ?></div>
          </div>

          <div class="dashboard-card stat-card">
            <div class="stat-head">
              <span class="stat-icon"><i class="far fa-calendar-alt"></i></span>
              <span>Leave Requests</span>
            </div>
            <div class="stat-value">
              <?php echo $row_no_leave; ?>
              <span class="stat-pill pill-success">All time</span>
            </div>
          </div>

          <div class="dashboard-card stat-card">
            <div class="stat-head">
              <span class="stat-icon"><i class="fas fa-check-circle"></i></span>
              <span>Approved Leave</span>
            </div>
            <div class="stat-value">
              <?php echo $row_no_leave_approved; ?>
              <span class="stat-pill pill-success">Approved</span>
            </div>
          </div>

          <div class="dashboard-card stat-card">
            <div class="stat-head">
              <span class="stat-icon"><i class="fas fa-times-circle"></i></span>
              <span>Declined Leave</span>
            </div>
            <div class="stat-value">
              <?php echo $row_no_leave_declined; ?>
              <span class="stat-pill pill-warning">Declined</span>
            </div>
          </div>
        </div>

        <div class="toolbar-row">
          <div class="toolbar-filters">
            <div class="toolbar-chip"><span>Employees</span> <i class="fas fa-angle-down text-muted"></i></div>
            <div class="toolbar-chip"><span>Status</span> <i class="fas fa-angle-down text-muted"></i></div>
          </div>
          <a href="leave_record.php" class="toolbar-chip text-decoration-none">
            <i class="fas fa-external-link-alt text-muted"></i>
            <span>Open Leave Records</span>
          </a>
        </div>

        <div class="dashboard-card employee-table-card">
          <div class="table-responsive">
            <table class="table employee-table">
              <thead>
                <tr>
                  <th>Employee</th>
                  <th>Role</th>
                  <th>Department</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($employeeRows)) { ?>
                  <?php foreach ($employeeRows as $employee) { ?>
                    <?php
                      $statusClass = 'status-inactive';
                      $statusLabel = 'Inactive';
                      if (!empty($employee['leave_status']) && $employee['leave_status'] !== 'Not Available') {
                          $statusClass = 'status-leave';
                          $statusLabel = 'On Leave';
                      } elseif ((string)$employee['status'] === '1') {
                          $statusClass = 'status-active';
                          $statusLabel = 'Active';
                      }
                    ?>
                    <tr>
                      <td>
                        <div class="employee-meta">
                          <?php if (!empty($employee['photo'])) { ?>
                            <img src="../<?php echo htmlspecialchars($employee['photo']); ?>" alt="<?php echo htmlspecialchars($employee['fullname']); ?>" class="employee-avatar">
                          <?php } else { ?>
                            <span class="employee-avatar-fallback"><?php echo dashboardInitials($employee['fullname']); ?></span>
                          <?php } ?>
                          <div>
                            <div class="employee-name"><?php echo htmlspecialchars($employee['fullname']); ?></div>
                            <div class="employee-email"><?php echo htmlspecialchars($employee['email']); ?></div>
                          </div>
                        </div>
                      </td>
                      <td><?php echo htmlspecialchars($employee['employee_type']); ?> Staff</td>
                      <td><?php echo htmlspecialchars($employee['dept']); ?></td>
                      <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusLabel; ?></span></td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="4" class="text-center text-muted py-4">No employee records found.</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="table-footer">
            <div>Showing <?php echo count($employeeRows); ?> of <?php echo $row_no_employee; ?> employees</div>
            <div class="table-pagination">
              <span>Prev</span>
              <span class="table-page">1</span>
              <span>Next</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <?php include('../inc/footer.php'); ?>
    <div class="float-right d-none d-sm-inline-block"></div>
  </footer>

  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
