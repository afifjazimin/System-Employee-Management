<?php
include('../inc/topbar.php');
if(empty($_SESSION['admin-username']))
    {
      header("Location: login.php");
    }

if(isset($_POST["btnsave"]))
{
$file_type = $_FILES['avatar']['type']; //returns the mimetype
$allowed = array("image/jpeg", "image/gif","image/jpeg", "image/webp","image/png");
if(!in_array($file_type, $allowed)) {
$error = 'Only jpeg,Webp, gif, and png files are allowed.';
 // exit();

}else{
$image= addslashes(file_get_contents($_FILES['avatar']['tmp_name']));
$image_name= addslashes($_FILES['avatar']['name']);
$image_size= getimagesize($_FILES['avatar']['tmp_name']);
move_uploaded_file($_FILES["avatar"]["tmp_name"],"../uploadImage/" . $_FILES["avatar"]["name"]);
$location="uploadImage/" . $_FILES["avatar"]["name"];


//edit profile details
$sql = "UPDATE users SET photo=? where username=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$location,$username]);
if($stmt) {

header( "refresh:2;url= edit-photo.php" );
 $_SESSION['success'] ='Photo Edited Successfully...';

}else{
$error='Problem Editing Photo ';
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profile - <?php echo $sitename; ?></title>
  <link rel="shortcut icon" href="../image/employeesystem.png" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
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
</head>
<body class="hold-transition sidebar-mini layout-fixed admin-dashboard">
<div class="wrapper">

  <?php include('admin_header.php'); ?>

  <?php include('admin_sidebar_shell.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="admin-page-header">
          <div>
            <h1 class="admin-page-title">Edit Profile Photo</h1>
            <p class="admin-page-copy">Refresh your administrator photo and preview the result before saving the update.</p>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline admin-profile-card">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../<?php echo $row_admin['photo'];    ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row_admin['fullname'];  ?></h3>

                <p class="text-muted text-center"><?php echo $row_admin['username'];  ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Phone:</b> <a class="float-right"><?php echo $row_admin['phone'];  ?></a>
                  </li>


                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Profile Photo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">

           <div class="form-group">
                    <label for="exampleInputPassword1">Image</label>
                    <p class="text-center">
                        <input type="file" name="avatar" id="avatar" required class="form-control" accept="image/png,image/jpeg,image/jpg" onChange="display_img(this)">
                       </p>

                    <p class="text-center">
                      <span class="admin-avatar-preview">
                        <img src="../<?php echo $row_admin['photo'];    ?>" alt="user image" id="logo-img">
                      </span>
				    </p>
              </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="btnsave" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">

    </div>
 <?php  include('footer.php');   ?>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Success</strong>
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Error</strong>
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>
      <script>
    function display_img(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#logo-img').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

</script>
</body>
</html>
