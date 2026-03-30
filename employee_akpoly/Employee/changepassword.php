<?php
include('../inc/topbar.php'); 
if(empty($_SESSION['login_email']))
    {   
      header("Location: ../Account/login.php"); 
    }
  $q = "select * from tblemployee where email = '$email'";
  $q1 = $conn->query($q);
  while($row = mysqli_fetch_array($q1)){
    extract($row);
    $db_pass = $row['password'];
	$fullname = $row['fullname'];
  }

 if(isset($_POST["btnchange"])){
$old = mysqli_real_escape_string($conn,$_POST['txtold_password']);
$pass_new = mysqli_real_escape_string($conn,$_POST['txtnew_password']);
$confirm_new = mysqli_real_escape_string($conn,$_POST['txtconfirm_password']);
 
  if($db_pass!=$old){  
     $_SESSION['error']='Old Password not matched';

   } else if(strlen($pass_new) < 8){ 
     $_SESSION['error']='Password should be at least 8 characters in length';

  } else if($pass_new!=$confirm_new){ 
    $_SESSION['error']='NEW Password and CONFIRM password not Matched';
 
  } else {
    
   $sql = "update  tblemployee set `password`='$confirm_new' where email= '$email'";
  $res = $conn->query($sql);	
header( "refresh:2;url= ../Account/login.php" ); 
   $_SESSION['success']='Password changed Successfully...';
    }
  }
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password | <?php echo htmlspecialchars($sitename); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
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
        
        #page-wrapper.gray-bg {
            background: var(--bg);
        }

        .modern-form-container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .modern-form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
            margin-top: 0;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .modern-form-card label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .modern-form-card .form-control {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            height: auto;
            transition: all 0.2s;
            box-shadow: none;
            color: var(--text);
        }

        .modern-form-card .form-control:focus {
            border-color: #94a3b8;
            box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.15);
        }
        
        .modern-btn-primary {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 1rem;
        }

        .modern-btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
            color: #fff;
        }
    </style>
</head>

<body class="employee-dashboard">
 <div id="wrapper">
    <?php include('employee_sidebar_shell.php'); ?>

        <div id="page-wrapper" class="gray-bg">
        <?php
        $employeePageTitle = 'Change Password';
        $employeePageSubtitle = 'Update your account password with the same clean dashboard experience.';
        $employeeHeaderButtonLink = 'profile.php';
        $employeeHeaderButtonLabel = 'My Profile';
        include('employee_header.php');
        ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="modern-form-container">
                <div class="modern-form-card">
                    <h2 class="form-title">Change Password</h2>
                    <form role="form" method="POST">
                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" name="txtold_password" value="<?php echo isset($_POST['txtold_password']) ? htmlspecialchars($_POST['txtold_password']) : ''; ?>" placeholder="Enter Old Password" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="txtnew_password" value="<?php echo isset($_POST['txtnew_password']) ? htmlspecialchars($_POST['txtnew_password']) : ''; ?>" placeholder="Enter New Password" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="txtconfirm_password" value="<?php echo isset($_POST['txtconfirm_password']) ? htmlspecialchars($_POST['txtconfirm_password']) : ''; ?>" placeholder="Confirm New Password" class="form-control" required="">
                        </div>
                        
                        <button class="modern-btn-primary" type="submit" name="btnchange">
                            <i class="fa fa-key"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="pull-right"></div>
            <div><?php include('../inc/footer.php');  ?></div>
        </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <link rel="stylesheet" href="../css/popup_style.css">
    <?php if(!empty($_SESSION['success'])) {  ?>
    <div class="popup popup--icon -success js_success-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                <strong>Success</strong> 
            </h3>
            <p><?php echo $_SESSION['success']; ?></p>
            <p>
                <button class="button button--success" data-for="js_success-popup">Close</button>
            </p>
        </div>
    </div>
    <?php unset($_SESSION["success"]);  } ?>
    
    <?php if(!empty($_SESSION['error'])) {  ?>
    <div class="popup popup--icon -error js_error-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">
                <strong>Error</strong> 
            </h3>
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
                if (popupEl) popupEl.classList.toggle('popup--visible');
            });
        };
        Array.from(document.querySelectorAll('button[data-for]')).forEach(addButtonTrigger);
    </script>
</body>
</html>
