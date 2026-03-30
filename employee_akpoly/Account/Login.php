<?php
include('../inc/topbar.php'); 


if(isset($_POST['btnlogin'])){


//Get Date
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d h:i:s');


$email = $_POST['txtemail'];
$password = $_POST['txtpassword'];
$status = '1';


 $sql = "SELECT * FROM tblemployee WHERE email='" .$email. "' and password = '".$password."'  and status = '".$status."'";
  $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
 ($row = mysqli_fetch_assoc($result));
	 $_SESSION["login_email"] = $row['email'];
		
header("Location: ../Employee/index.php"); 
}else { 
$_SESSION['error']=' Wrong Email Address and Password';
}
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from verify.waeconline.org.ng/Individual/Login by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Nov 2023 15:20:35 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login - Foundation Polytechnic, Ikot Ekpene</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-theme13.css">
    <link href="../css/auth.css" rel="stylesheet" />
    <link href="../css/singlesided.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="16x16" href="../image/logo.jpeg">
    <style>
        :root {
            --login-bg: #f3f6fb;
            --login-surface: rgba(255, 255, 255, 0.9);
            --login-border: rgba(15, 23, 42, 0.08);
            --login-text: #0f172a;
            --login-muted: #64748b;
            --login-accent: #0f766e;
            --login-accent-hover: #115e59;
            --login-shadow: 0 24px 60px rgba(15, 23, 42, 0.14);
        }

        body.login-page {
            min-height: 100vh;
            margin: 0;
            color: var(--login-text);
            background:
                radial-gradient(circle at top left, rgba(15, 118, 110, 0.16), transparent 32%),
                radial-gradient(circle at bottom right, rgba(30, 64, 175, 0.16), transparent 28%),
                linear-gradient(135deg, #eff6ff 0%, #f8fafc 45%, #ecfeff 100%);
        }

        .form-body {
            min-height: calc(100vh - 72px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
        }

        .form-body .row {
            width: 100%;
            margin: 0;
            justify-content: center;
        }

        .form-holder {
            margin-left: 0;
            width: 100%;
            max-width: 480px;
        }

        .form-holder .aa,
        .form-holder .bb {
            display: none;
        }

        .form-holder .form-content {
            height: auto;
            min-height: auto;
            padding: 0;
        }

        .login-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--login-border);
            border-radius: 28px;
            background: var(--login-surface);
            box-shadow: var(--login-shadow);
            backdrop-filter: blur(16px);
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            background: linear-gradient(90deg, #0f766e 0%, #14b8a6 55%, #38bdf8 100%);
        }

        .login-card .card-header,
        .login-card .card-body {
            position: relative;
            z-index: 1;
            background: transparent;
            border: 0;
        }

        .login-card .card-header {
            padding: 28px 28px 12px;
        }

        .login-card .card-body {
            padding: 0 28px 28px;
        }

        .login-home {
            width: 44px;
            height: 44px;
            padding: 0;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(15, 118, 110, 0.14);
            color: var(--login-accent);
            background: rgba(255, 255, 255, 0.78);
        }

        .login-home:hover {
            color: var(--login-accent-hover);
            background: #ffffff;
        }

        .login-eyebrow {
            margin-bottom: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--login-accent);
        }

        .login-card h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .login-subtitle {
            margin: 10px 0 0;
            color: var(--login-muted);
            line-height: 1.6;
        }

        .login-form .form-group {
            margin-bottom: 18px;
        }

        .login-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #334155;
        }

        .login-form .form-control {
            height: 56px;
            border: 1px solid rgba(148, 163, 184, 0.32);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.96);
            color: var(--login-text);
            font-size: 1rem;
            padding: 0 18px;
            box-shadow: none;
        }

        .login-form .form-control:focus {
            border-color: rgba(15, 118, 110, 0.48);
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.12);
        }

        .login-submit {
            width: 100%;
            height: 56px;
            border: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--login-accent) 0%, #14b8a6 100%);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            box-shadow: 0 16px 30px rgba(15, 118, 110, 0.25);
        }

        .login-submit:hover,
        .login-submit:focus {
            background: linear-gradient(135deg, var(--login-accent-hover) 0%, #0f766e 100%);
            color: #ffffff;
        }

        .login-footer {
            margin-top: 20px;
            text-align: center;
            color: var(--login-muted);
        }

        .login-footer a {
            color: var(--login-accent);
            font-weight: 600;
        }

        .footer.bg-dark {
            background: #0f172a !important;
        }

        @media (max-width: 576px) {
            .form-body {
                padding: 24px 16px;
            }

            .login-card .card-header,
            .login-card .card-body {
                padding-left: 20px;
                padding-right: 20px;
            }

            .login-card h2 {
                font-size: 1.7rem;
            }
        }
    </style>

</head>
<body class="login-page d-flex flex-column">
        <div class="form-body">
            <div class="row">
                <div class="form-holder">
                    <div class="form-content">
                        <div class="form-items card login-card">
                            <div class="card-header">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="login-eyebrow">Employee Portal</p>
                                        <h2>Welcome back</h2>
                                        <p class="login-subtitle">Sign in with your employee email to access your dashboard.</p>
                                    </div>
                                    <a href="../index.php" class="btn login-home" aria-label="Back to home">
                                        <i class="fas fa-home"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                            <form method="post" action="" class="login-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="login-label" for="txtemail">Email Address</label>
                                            <input class="form-control" type="email" placeholder="name@example.com" required id="txtemail" name="txtemail" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="login-label" for="txtpassword">Password</label>
                                            <input class="form-control" type="password" placeholder="Enter your password" required id="txtpassword" name="txtpassword">
                                        </div>
                                    </div>
                                </div>
                                <button name="btnlogin" type="submit" class="btn login-submit">Sign In</button>
                                <p class="login-footer">Not an employee yet? <a href="registration.php">Register here</a></p>

                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <section class="footer pt-0 mt-auto bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center footer-alt my-1">
                        <p class="f-15">
                        <?php include('../inc/footer2.php') ; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>




    <link rel="stylesheet" href="../css/popup_style.css">
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

</body>
</html>
