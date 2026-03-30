<?php
include('../inc/topbar.php');

if(isset($_POST["btnsubmit"])){

    $employeeID = 'STAFF/FKP/'.date("Y").'/'.rand(1000,5009);
    $sql = 'INSERT INTO tblemployee(employeeID,fullname,password,sex,email,dob,phone,address,qualification,dept,employee_type,date_appointment,basic_salary,gross_pay,status,leave_status,photo) VALUES(:employeeID,:fullname,:password,:sex,:email,:dob,:phone,:address,:qualification,:dept,:employee_type,:date_appointment,:basic_salary,:gross_pay,:status,:leave_status,:photo)';
    $statement = $dbh->prepare($sql);
    $statement->execute([
        ':employeeID' => $employeeID,
        ':fullname' => $_POST['txtfullname'],
        ':password' => $_POST['txtpassword'],
        ':sex' => $_POST['cmdsex'],
        ':email' => $_POST['txtemail'],
        ':dob' => '',
        ':phone' => $_POST['txtphone'],
        ':address' => '',
        ':qualification' => '',
        ':dept' => $_POST['cmddept'],
        ':employee_type' => $_POST['cmdemployeetype'],
        ':date_appointment' => '',
        ':basic_salary' => $_POST['txtbasic_salary'],
        ':gross_pay' => $_POST['txtgross_pay'],
        ':status' => '1',
        ':leave_status' => 'Not Available',
        ':photo' => 'uploadImage/Profile/default.png'
    ]);
    if ($statement){
        $_SESSION['success'] = 'Registration was Successful';
    } else {
        $_SESSION['error'] = 'Something went Wrong';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from verify.waeconline.org.ng/Individual/IndividualRegistration by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Nov 2023 15:21:15 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration - <?php echo $sitename ;?></title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="../css/iofrm-theme13.css">
    <link href="../css/auth.css" rel="stylesheet" />
    <link href="../plugin/TelPlugin/build/css/intlTelInput.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/switchery.min.css">
    <link href="../css/doublesided.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="16x16" href="../image/logo.jpeg">
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

        * {
            box-sizing: border-box;
        }

        body.registration-page {
            min-height: 100vh;
            margin: 0;
            color: var(--login-text);
            background:
                radial-gradient(circle at top, rgba(255, 255, 255, 0.98), rgba(249, 250, 251, 0.96)),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            font-family: "Inter", sans-serif;
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
            max-width: 760px;
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
            letter-spacing: -0.03em;
            color: var(--login-text);
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
            line-height: 1.6;
        }

        .login-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group-full {
            grid-column: 1 / -1;
        }

        .login-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
        }

        .form-control {
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

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:focus {
            outline: none;
            border-color: #000000;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
        }

        select.form-control {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #6b7280 50%), linear-gradient(135deg, #6b7280 50%, transparent 50%);
            background-position: calc(100% - 18px) calc(50% - 3px), calc(100% - 12px) calc(50% - 3px);
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
            padding-right: 40px;
        }

        .login-submit {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 10px;
            background: var(--login-accent);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
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

        .hide {
            display: none;
        }

        @media (max-width: 767px) {
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

            .login-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-group-full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body class="registration-page">
    <div class="login-shell">
            <div class="login-wrapper">
                <div class="login-card">
                    <div class="login-card-top">
                        <h2>Employee Registration</h2>
                        <a href="../index.php" class="home-button">Home</a>
                    </div>
                <p class="login-subtitle">Create your employee account with the same refined interface used across the admin portal.</p>
                <form method="post" id="regForm" class="login-form" novalidate autocomplete="off" action="">
                    <div class="login-grid">
                        <div class="form-group">
                            <label class="login-label" for="txtsurname">Full name</label>
                            <div class="controls">
                                <input class="form-control" type="text" placeholder="Enter your full name" required data-validation-required-message="Fullname is required" data-val="true" data-val-required="The Fullname field is required." id="txtsurname" name="txtfullname" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="txtphone">Mobile number</label>
                            <div class="controls">
                                <input class="form-control" type="text" placeholder="Enter your mobile number" required data-validation-required-message="Mobile Number is required" data-val="true" data-val-required="The Phone field is required." id="txtphone" name="txtphone" value="">
                                <span id="error-msg" class="hide"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="cmdsex">Sex</label>
                            <div class="controls">
                                <select class="form-control" required data-validation-required-message="Select Sex " data-val="true" data-val-required="The Sex field is required." id="cmdsex" name="cmdsex">
                                    <option value="">Select sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="txtemail">Email address</label>
                            <div class="controls">
                                <input type="text" autocomplete="off" class="form-control" required data-validation-required-message="Email Address is required" data-validation-regex-regex="([a-zA-Z0-9_\.-]+)@([\da-zA-Z\.-]+)\.([a-zA-Z\.]{2,6})" data-validation-regex-message="Email Address not valid" placeholder="name@example.com" data-val="true" data-val-required="The Email field is required." id="txtemail" name="txtemail" value="">
                                <span id="error-msg" class="hide"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="txtpassword">Password</label>
                            <div class="controls">
                                <input class="form-control" type="Password" placeholder="Create a password" autocomplete="off" required data-validation-regex-regex="^(?=.*[A-z])(?=.*[A-Z])(?=.*[0-9])\S{6,12}$" data-validation-regex-message="Password must contain at least an Uppercase, Lowercase and a Number and must be between 6 and 12 digits" data-val="true" data-val-length="You must specify a password between 6 and 12 characters" data-val-length-max="12" data-val-length-min="6" data-val-required="The Password field is required." id="txtpassword" maxlength="12" name="txtpassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="cmddept">Department</label>
                            <div class="controls">
                                <select class="form-control" required data-validation-required-message="Select Employee Department" data-val="true" data-val-required="The Employee Department field is required." id="cmddept" name="cmddept">
                                    <option value="">Select department</option>
                                    <option value="Security">Security</option>
                                    <option value="Bursary">Bursary</option>
                                    <option value="Student Affairs">Student Affairs</option>
                                    <option value="Clinic">Clinic</option>
                                    <option value="ICT">ICT</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Science & Technology">Science & Technology</option>
                                    <option value="Management Technolgy">Management Technolgy</option>
                                    <option value="Engineering Technology">Engineering Technology</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="cmdemployeetype">Employee type</label>
                            <div class="controls">
                                <select class="form-control" required data-validation-required-message="Select Emplooyee Type" data-val="true" data-val-required="The Employee Type field is required." id="cmdemployeetype" name="cmdemployeetype">
                                    <option value="">Select employee type</option>
                                    <option value="Academic">Academic</option>
                                    <option value="Non-Academic">Non-Academic</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="txtbasic_salary">Basic salary</label>
                            <div class="controls">
                                <input class="form-control" type="number" placeholder="Enter basic salary" required data-validation-required-message="Basic Salary is required" data-val="true" data-val-required="The Basic Salary field is required." id="txtbasic_salary" name="txtbasic_salary" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="login-label" for="txtgross_pay">Gross pay</label>
                            <div class="controls">
                                <input class="form-control" type="number" placeholder="Enter gross pay" required data-validation-required-message="Gross Pay is required" data-val="true" data-val-required="The Gross Pay field is required." id="txtgross_pay" name="txtgross_pay" value="">
                            </div>
                        </div>
                        <div class="form-group form-group-full">
                            <button name="btnsubmit" type="submit" class="btn login-submit">Create account</button>
                        </div>
                    </div>
                    <p class="login-footer">Already have an account? <a href="Login.php">Sign in</a></p>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script src="../app-assets/vendors/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/jqBootstrapValidation.js" type="text/javascript"></script>
    <script src="../app-assets/js/form-validation.js" type="text/javascript"></script>
    <script src="../../www.google.com/recaptcha/api6979.js?render=6Lf3z9wUAAAAAPTC6tPRnbU73Vnq_OGvNHzEgFxi"></script>
    <script src="../plugin/TelPlugin/build/js/intlTelInput.min.js"></script>
    <script src="../plugin/TelPlugin/build/js/intlTelInput-jquery.min.js"></script>
    <script src="../app-assets/vendors/js/switchery.min.js" type="text/javascript"></script>
    <script src="../app-assets/js/switch.min.js" type="text/javascript"></script>
    <script src="../js/doublesided.js"></script>
    <script src="../js/IndividualRegistration.js"></script>

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

<!-- Mirrored from verify.waeconline.org.ng/Individual/IndividualRegistration by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Nov 2023 15:21:31 GMT -->

</html>
