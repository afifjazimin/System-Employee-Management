<?php
session_start();
error_reporting(1);

include('../database/connect.php');
include('../database/connect2.php');

$sitename = 'Employee Management System';

function employeePasswordColumnTooShort(PDOException $exception): bool
{
    return $exception->getCode() === '22001'
        || stripos($exception->getMessage(), "Data too long for column 'password'") !== false;
}

if (!empty($_SESSION['login_email'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['btnlogin'])) {
    $email = trim($_POST['txtemail'] ?? '');
    $password = $_POST['txtpassword'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Enter a valid email address.';
    } else {
        $stmt = $dbh->prepare("SELECT * FROM tblemployee WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee) {
            $storedPassword = (string) ($employee['password'] ?? '');
            $status = (string) ($employee['status'] ?? '1');
            $isActive = $status === '' || $status === '1' || strcasecmp($status, 'active') === 0;
            $isValidPassword = $storedPassword !== '' && (password_verify($password, $storedPassword) || hash_equals($storedPassword, $password));

            if ($isActive && $isValidPassword) {
                $needsDatabaseUpgrade = false;
                if (password_get_info($storedPassword)['algo'] === 0 || password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                    try {
                        $upgradeStmt = $dbh->prepare("UPDATE tblemployee SET password = ? WHERE email = ?");
                        $upgradeStmt->execute([password_hash($password, PASSWORD_DEFAULT), $employee['email']]);
                    } catch (PDOException $exception) {
                        if (employeePasswordColumnTooShort($exception)) {
                            $needsDatabaseUpgrade = true;
                        } else {
                            throw $exception;
                        }
                    }
                }

                session_regenerate_id(true);
                $_SESSION['login_email'] = $employee['email'];
                $_SESSION['logged'] = time();
                if ($needsDatabaseUpgrade) {
                    $_SESSION['success'] = 'Login worked, but the database password column is still too short for hashed passwords. Update the database schema next.';
                }

                header('Location: index.php');
                exit;
            }
        }

        $_SESSION['error'] = 'Wrong email or password.';
    }

    header('Location: login.php');
    exit;
}

$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login | <?php echo htmlspecialchars($sitename); ?></title>
    <meta name="description" content="Official employee login portal for the Employee Management System.">
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
            --success-bg: #ecfdf3;
            --success-border: #86efac;
            --success-text: #166534;
            --error-bg: #fef2f2;
            --error-border: #fca5a5;
            --error-text: #b91c1c;
        }

        * {
            box-sizing: border-box;
        }

        body.login-page {
            margin: 0;
            min-height: 100vh;
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
            max-width: 560px;
        }

        .login-card {
            width: 100%;
            background: var(--login-surface);
            border: 1px solid var(--login-border);
            border-radius: 12px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.05);
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
            letter-spacing: -0.03em;
            color: var(--login-text);
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

        .login-form {
            display: grid;
            gap: 0;
        }

        .alert {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 10px;
            border: 1px solid;
            font-size: 0.95rem;
        }

        .alert-success {
            background: var(--success-bg);
            border-color: var(--success-border);
            color: var(--success-text);
        }

        .alert-error {
            background: var(--error-bg);
            border-color: var(--error-border);
            color: var(--error-text);
        }

        .form-group {
            margin-bottom: 22px;
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
            padding: 0 16px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            color: var(--login-text);
            font-size: 0.98rem;
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
                <p class="login-subtitle">Sign in with your employee email and password using the same clean layout as the registration page.</p>

                <?php if ($successMessage !== '') { ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                <?php } ?>

                <?php if ($errorMessage !== '') { ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($errorMessage); ?></div>
                <?php } ?>

                <form method="POST" action="" class="login-form" autocomplete="off">
                    <div class="form-group">
                        <label class="login-label" for="txtemail">Email address</label>
                        <input type="email" class="form-control" name="txtemail" id="txtemail" placeholder="name@example.com" required>
                    </div>

                    <div class="form-group">
                        <label class="login-label" for="txtpassword">Password</label>
                        <input type="password" class="form-control" name="txtpassword" id="txtpassword" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" name="btnlogin" class="login-submit">Sign in</button>
                </form>

                <p class="login-footer">Need an account? <a href="../Account/registration.php">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
