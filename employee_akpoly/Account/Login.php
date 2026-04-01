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
    <link rel="icon" type="image/png" sizes="16x16" href="../image/employeesystem.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        :root {
            --login-bg: #f9fafb;
            --login-surface: #ffffff;
            --login-border: #e5e7eb;
            --login-text: #111827;
            --login-muted: #6b7280;
            --login-accent: #000000;
            --login-accent-hover: #1f2937;
        }

        body.login-page {
            min-height: 100vh;
            margin: 0;
            color: var(--login-text);
            background:
                radial-gradient(circle at top, rgba(255, 255, 255, 0.98), rgba(249, 250, 251, 0.96)),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            font-family: "Inter", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .login-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .login-card {
            width: 100%;
            background: var(--login-surface);
            border: 1px solid var(--login-border);
            border-radius: 12px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.05);
            padding: 38px 36px;
        }

        .login-card h2 {
            margin: 0 0 10px;
            font-size: 2.1rem;
            font-weight: 600;
            color: var(--login-text);
            text-align: left;
            letter-spacing: -0.03em;
        }

        .login-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 10px;
        }

        .login-card-top h2 {
            margin-bottom: 0;
        }

        .home-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: 0 16px;
            border: 1px solid var(--login-border);
            border-radius: 10px;
            color: var(--login-text);
            background: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .home-button:hover {
            color: var(--login-text);
            background: #f8fafc;
            border-color: #d1d5db;
            text-decoration: none;
        }

        .login-subtitle {
            margin: 0 0 34px;
            font-size: 1rem;
            color: var(--login-muted);
            text-align: left;
            line-height: 1.6;
        }

        .login-form .form-group {
            margin-bottom: 22px;
        }

        .login-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .login-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }
        
        .forgot-password {
            font-size: 0.9rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: #0f172a;
            text-decoration: none;
        }

        .input-wrapper {
            position: relative;
        }

        .login-form .form-control {
            width: 100%;
            height: 50px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            color: var(--login-text);
            font-size: 0.98rem;
            padding: 0 16px;
            box-shadow: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .login-form .form-control::placeholder {
            color: #9ca3af;
        }

        .login-form .form-control:focus {
            outline: none;
            border-color: #000000;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
        }

        .login-submit {
            width: 100%;
            height: 52px;
            margin-top: 4px;
            border: 0;
            border-radius: 10px;
            background: var(--login-accent);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out, transform 0.15s ease-in-out;
        }

        .login-submit:hover,
        .login-submit:focus {
            background: var(--login-accent-hover);
            outline: none;
            transform: translateY(-1px);
        }

        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 1rem;
            color: var(--login-muted);
        }

        .login-footer a {
            color: var(--login-text);
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 30px 22px;
                border-radius: 12px;
            }

            .login-card h2 {
                font-size: 1.75rem;
            }

            .login-card-top {
                align-items: center;
            }
        }
    </style>

</head>
<body class="login-page">
        <div class="login-shell">
            <div class="login-wrapper">
                <div class="login-card">
                    <div class="login-card-top">
                        <h2>Employee Login</h2>
                        <a href="../index.php" class="home-button">Home</a>
                    </div>
                    <p class="login-subtitle">Sign in to access your employee dashboard with the same clean experience as the admin portal.</p>
                    <form method="post" action="" class="login-form">
                        <div class="form-group">
                            <label class="login-label" for="txtemail">Email address</label>
                            <div class="input-wrapper">
                                <input class="form-control" type="email" placeholder="name@example.com" required id="txtemail" name="txtemail" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="login-label-row">
                                <label class="login-label" for="txtpassword">Password</label>
                                <a href="registration.php" class="forgot-password">Need an account?</a>
                            </div>
                            <div class="input-wrapper">
                                <input class="form-control" type="password" placeholder="Enter your password" required id="txtpassword" name="txtpassword">
                            </div>
                        </div>
                        <button name="btnlogin" type="submit" class="btn login-submit">Continue <span aria-hidden="true">&rarr;</span></button>
                        <p class="login-footer">Don't have an account? <a href="registration.php">Sign up</a></p>
                    </form>
                </div>
            </div>
        </div>
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
