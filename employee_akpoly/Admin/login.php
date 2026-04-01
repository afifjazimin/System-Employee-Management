<?php
include('../inc/topbar.php');

if(isset($_POST['btnlogin']))
{
    $username = $_POST['txtusername'];
    $password = $_POST['txtpassword'];

    $sql = "SELECT * FROM users WHERE username='".$username."' and password = '".$password."'";
    $result = mysqli_query($conn,$sql);
    $row  = mysqli_fetch_array($result);

    $_SESSION["admin-username"] = $row['username'];

    $count = mysqli_num_rows($result);
    if(isset($_SESSION["admin-username"])) {
        header("Location: index.php");
    } else {
        $_SESSION['error'] = ' Wrong Username and Password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login | <?php echo $sitename; ?></title>

  <link rel="icon" type="image/png" sizes="16x16" href="../image/employeesystem.png">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
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

    body.login-page {
      min-height: 100vh;
      margin: 0;
      color: var(--login-text);
      background:
        radial-gradient(circle at top, rgba(255, 255, 255, 0.98), rgba(249, 250, 251, 0.96)),
        linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
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
      border-radius: 18px;
      box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
      padding: 38px 36px;
    }

    .login-card-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 16px;
      margin-bottom: 10px;
    }

    .login-card h2 {
      margin: 0;
      font-size: 2.1rem;
      font-weight: 600;
      color: var(--login-text);
      letter-spacing: -0.03em;
    }

    .home-button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 44px;
      height: 44px;
      padding: 0 16px;
      border: 1px solid var(--login-border);
      border-radius: 999px;
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

    .login-form .form-group {
      margin-bottom: 22px;
    }

    .login-label {
      display: block;
      font-size: 0.95rem;
      font-weight: 600;
      color: #1f2937;
      margin: 0 0 8px;
    }

    .login-form .form-control {
      width: 100%;
      height: 50px;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
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
      border-radius: 12px;
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

    @media (max-width: 576px) {
      .login-card {
        padding: 30px 22px;
        border-radius: 16px;
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
<body class="hold-transition login-page">
<div class="login-shell">
  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-card-top">
        <h2>Admin Login</h2>
        <a href="../index.php" class="home-button">Home</a>
      </div>
      <p class="login-subtitle">Enter your admin username and password to continue.</p>

      <form action="" method="post" class="login-form">
        <div class="form-group">
          <label class="login-label" for="txtusername">Username</label>
          <input type="text" class="form-control" name="txtusername" id="txtusername" placeholder="Enter username" required>
        </div>
        <div class="form-group">
          <label class="login-label" for="txtpassword">Password</label>
          <input type="password" class="form-control" name="txtpassword" id="txtpassword" placeholder="Enter password" required>
        </div>
        <button type="submit" name="btnlogin" class="login-submit">Continue <span aria-hidden="true">&rarr;</span></button>
      </form>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

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

  Array.from(document.querySelectorAll('button[data-for]')).forEach(addButtonTrigger);
</script>
</body>
</html>
