<?php
include('../inc/topbar.php');
if(empty($_SESSION['admin-username']))
    {
      header("Location: login.php");
    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User's Record|<?php echo $sitename; ?></title>
  <link rel="icon" type="image/png" sizes="16x16" href="../<?php echo $logo; ?>">
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
		function Activate(fullname){
if(confirm("ARE YOU SURE YOU WISH TO ACTIVATE " + " " + fullname+ " " + " FROM THE DATABASE?"))

{
return  true;
}
else {return false;
}

}

</script>

<script type="text/javascript">
		function Deactivate(fullname){
if(confirm("ARE YOU SURE YOU WISH TO DEACTIVATE " + " " + fullname+ " " + " FROM THE DATABASE?"))

{
return  true;
}
else {return false;
}

}

</script>
<script type="text/javascript">
		function deldata(fullname){
if(confirm("ARE YOU SURE YOU WISH TO DELETE " + " " + fullname+ " " + " FROM THE DATABASE?"))
{
return  true;
}
else {return false;
}

}

</script>
  <style type="text/css">
<!--
.style7 {vertical-align:middle; cursor:pointer; -webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none; border:1px solid transparent; padding:.375rem .75rem; line-height:1.5; border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; display: inline-block; color: #212529; text-align: center;}
-->
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed admin-dashboard">
<div class="wrapper">

  <?php include('admin_header.php'); ?>

  <!-- Main Sidebar Container -->
  <?php include('admin_sidebar_shell.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="admin-page-header">
          <div>
            <h1 class="admin-page-title">Admin Records</h1>
            <p class="admin-page-copy">Manage all administrator accounts, review profile details, and create new users from the same workspace.</p>
          </div>
          <div class="admin-page-actions">
            <a class="admin-action-button dark" href="add-admin.php"><i class="fas fa-plus-circle"></i><span>Add User</span></a>
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
              <div class="card list-card">
                <div class="card-header">
                  <h3 class="card-title">Administrator Accounts</h3>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped admin-data-table" id="example1">
                    <thead>
                    <tr>
                      <th>Employee</th>
                      <th>Role</th>
                      <th>Contact</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                  $data = $dbh->query("SELECT *  FROM users order by username DESC")->fetchAll();
                  $cnt=1;
                  foreach ($data as $row) {
                    ?>
                      <tr class="gradeX">
                        <td>
                          <div class="admin-row-user">
                            <img src="../<?php echo $row['photo']; ?>" alt="<?php echo htmlspecialchars($row['fullname']); ?>" class="table-avatar">
                            <div>
                              <div class="admin-row-title"><?php echo $row['fullname']; ?></div>
                              <div class="admin-row-subtitle"><?php echo $row['username']; ?></div>
                            </div>
                          </div>
                        </td>
                        <td>Administrator</td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><span class="admin-status-pill success">Active</span></td>
			                  <td>
                          <div class="admin-inline-actions">
                            <a class="admin-action-link danger" href="delete-user.php?uid=<?php echo $row['username'];?>" onClick="return deldata('<?php echo $row['fullname']; ?>');">
                            <i class="fas fa-trash-alt"></i>
                            <span>Delete</span>
                            </a>
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
                  <div>Showing <?php echo $cnt-1; ?> of <?php echo $cnt-1; ?> employees</div>
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
