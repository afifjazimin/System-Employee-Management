<?php
include('../inc/topbar.php');
if(empty($_SESSION['admin-username']))
    {
      header("Location: login.php");
    }

function formatAdminLeaveDate($value) {
    if (empty($value)) {
        return 'N/A';
    }

    $timestamp = strtotime((string)$value);
    if ($timestamp === false) {
        return (string)$value;
    }

    return date('d M Y', $timestamp);
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Leave Record|<?php echo $sitename; ?></title>
  <link rel="icon" type="image/png" sizes="16x16" href="../image/employeesystem.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/admin-custom.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <script type="text/javascript">
		function approve(fullname){
if(confirm("ARE YOU SURE YOU WISH TO APPROVE THIS LEAVE APPLICATION" + " FOR " + fullname + "?"))

{
return  true;
}
else {return false;
}

}

</script>

<script type="text/javascript">
		function decline(fullname){
if(confirm("ARE YOU SURE YOU WISH TO DECLINE THIS LEAVE APPLICATION ?"))

{
return  true;
}
else {return false;
}

}

</script>
<script type="text/javascript">
		function deldata(fullname){
if(confirm("ARE YOU SURE YOU WISH TO DELETE THIS LEAVE FROM THE DATABASE?"))
{
return  true;
}
else {return false;
}

}

</script>
  <style type="text/css">
    .leave-review-card .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      flex-wrap: wrap;
    }

    .leave-review-summary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      min-height: 38px;
      padding: 0 14px;
      border-radius: 999px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      color: #475569;
      font-weight: 700;
      font-size: 0.92rem;
    }

    .leave-review-table {
      border-collapse: separate;
      border-spacing: 0;
    }

    .leave-review-table thead th {
      position: sticky;
      top: 0;
      z-index: 1;
      background: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0 !important;
      white-space: nowrap;
    }

    .leave-review-table tbody tr {
      transition: background-color 0.18s ease, box-shadow 0.18s ease;
    }

    .leave-review-table tbody tr:hover {
      background: #fcfdff;
      box-shadow: inset 0 0 0 9999px rgba(248, 250, 252, 0.45);
    }

    .leave-review-table tbody td {
      vertical-align: middle;
    }

    .leave-review-table .employee-cell {
      min-width: 230px;
    }

    .leave-review-table .leave-id-cell,
    .leave-review-table .status-cell,
    .leave-review-table .action-cell {
      white-space: nowrap;
    }

    .leave-review-table .date-chip {
      display: inline-flex;
      align-items: center;
      min-height: 36px;
      padding: 0 12px;
      border-radius: 10px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      color: #334155;
      font-weight: 700;
      font-size: 0.92rem;
    }

    .leave-review-table .reason-cell {
      min-width: 250px;
      max-width: 340px;
    }

    .leave-review-table .reason-box {
      display: block;
      padding: 12px 14px;
      border-radius: 12px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      color: #334155;
      line-height: 1.5;
      white-space: normal;
    }

    .leave-review-table .role-chip {
      display: inline-flex;
      align-items: center;
      min-height: 34px;
      padding: 0 12px;
      border-radius: 10px;
      background: #eff6ff;
      color: #1d4ed8;
      font-weight: 700;
      font-size: 0.9rem;
    }

    .leave-review-table .dept-text {
      font-weight: 600;
      color: #334155;
    }

    .leave-review-table .admin-inline-actions {
      gap: 10px;
      justify-content: flex-start;
    }

    .leave-review-table .admin-action-link {
      min-height: 40px;
      padding: 0 14px;
      border-radius: 12px;
      font-weight: 700;
      transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
    }

    .leave-review-table .admin-action-link:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
    }

    .leave-review-table .admin-action-link i {
      font-size: 0.92rem;
    }

    .leave-review-table .admin-action-link.delete-action {
      min-width: 40px;
      justify-content: center;
      padding: 0 12px;
    }

    .leave-review-table .admin-action-link.delete-action span {
      display: none;
    }

    @media (max-width: 991px) {
      .leave-review-table .reason-cell {
        min-width: 220px;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed admin-dashboard">
<div class="wrapper">

  <?php include('admin_header.php'); ?>

  <?php include('admin_sidebar_shell.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="admin-page-header">
          <div>
            <h1 class="admin-page-title">Leave Records</h1>
            <p class="admin-page-copy">Review leave applications, check current statuses, and take action from one organized record table.</p>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <?php
              $data = $dbh->query("select * FROM tblemployee,tblleave where tblemployee.email = tblleave.email order by tblleave.start_date DESC")->fetchAll();
              ?>
              <div class="card list-card leave-review-card">
                <div class="card-header">
                  <h3 class="card-title">Leave Applications</h3>
                  <span class="leave-review-summary"><?php echo count($data); ?> applications</span>
                </div>
                <div class="card-body">
                  <table class="table admin-data-table leave-review-table" id="example1">
                    <thead>
                    <tr>
                      <th>Employee</th>
                      <th>Leave ID</th>
                      <th>Role</th>
                      <th>Department</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Reason</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                  $cnt=1;
                  foreach ($data as $row) {
                    ?>
                      <tr class="gradeX">
                        <td class="employee-cell">
                          <div class="admin-row-user">
                            <img src="../<?php echo htmlspecialchars(safe_relative_image_path($row['photo']) ?: 'images/default_avatar.png', ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8'); ?>" class="table-avatar">
                            <div>
                              <div class="admin-row-title"><?php echo htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8'); ?></div>
                              <div class="admin-row-subtitle"><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                          </div>
                        </td>
                        <td class="leave-id-cell"><span class="admin-tag"><?php echo htmlspecialchars($row['leaveID'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><span class="role-chip"><?php echo htmlspecialchars($row['employee_type'], ENT_QUOTES, 'UTF-8'); ?> Staff</span></td>
                        <td><span class="dept-text"><?php echo htmlspecialchars($row['dept'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><span class="date-chip"><?php echo htmlspecialchars(formatAdminLeaveDate($row['start_date']), ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><span class="date-chip"><?php echo htmlspecialchars(formatAdminLeaveDate($row['end_date']), ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td class="reason-cell"><div class="reason-box"><?php echo nl2br(htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8')); ?></div></td>
                        <td class="status-cell">
                          <?php if(($row['status'])=="Pending")
						{ ?>
                          <span class="admin-status-pill warning">Pending</span>
                          <?php }else if(($row['status'])=="Approved") { ?>
                          <span class="admin-status-pill success">Approved</span>
                          <?php }else if(($row['status'])=="Declined") { ?>
                          <span class="admin-status-pill danger">Declined</span>
                          <?php } ?>		
                        </td>
			                  <td class="action-cell">
                          <div class="admin-inline-actions">
                            <form method="post" action="process_leave.php" class="d-inline" onsubmit="return approve(<?php echo htmlspecialchars(json_encode($row['fullname']), ENT_QUOTES, 'UTF-8'); ?>);">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="leave_id" value="<?php echo htmlspecialchars($row['leaveID'], ENT_QUOTES, 'UTF-8'); ?>">
                              <input type="hidden" name="action" value="approve">
                              <button type="submit" class="admin-action-link success">
                                <i class="fa fa-check" title="Approve Leave Application"></i><span>Approve</span>
                              </button>
                            </form>
                            <form method="post" action="process_leave.php" class="d-inline" onsubmit="return decline(<?php echo htmlspecialchars(json_encode($row['fullname']), ENT_QUOTES, 'UTF-8'); ?>);">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="leave_id" value="<?php echo htmlspecialchars($row['leaveID'], ENT_QUOTES, 'UTF-8'); ?>">
                              <input type="hidden" name="action" value="decline">
                              <button type="submit" class="admin-action-link warning">
                                <i class="fa fa-times" title="Decline Leave Application"></i><span>Decline</span>
                              </button>
                            </form>
                            <form method="post" action="delete-leave.php" class="d-inline" onsubmit="return deldata(<?php echo htmlspecialchars(json_encode($row['fullname']), ENT_QUOTES, 'UTF-8'); ?>);">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['leaveID'], ENT_QUOTES, 'UTF-8'); ?>">
                              <button type="submit" class="admin-action-link danger delete-action" title="Delete Leave Application">
                                <i class="fas fa-trash-alt"></i><span>Delete</span>
                              </button>
                            </form>
                          </div>
                        </td>
                    </tr>
                    <?php $cnt=$cnt+1;} ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>

                </div>
                <div class="table-footer">
                  <div>Showing <?php echo $cnt-1; ?> of <?php echo $cnt-1; ?> applications</div>
                  <div class="table-footer-pages">
                    <span>Prev</span>
                    <span class="page-pill">1</span>
                    <span>Next</span>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">

    </div>
 <?php  include('../inc/footer.php');   ?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
