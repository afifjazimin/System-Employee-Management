<?php
include('../inc/topbar.php');
if (empty($_SESSION['login_email'])) {
    header("Location: ../Account/login.php");
}

if (isset($_POST["btnedit"])) {
    $sql = " update tblemployee set fullname='".$_POST['txtfullname']."',sex='".$_POST['cmdsex']."',dob='".$_POST['txtdob']."',phone='".$_POST['txtphone']."',address='".$_POST['txtaddress']."',qualification='".$_POST['txtqualification']."',dept='".$_POST['cmddept']."',employee_type='".$_POST['cmdemployeetype']."',date_appointment='".$_POST['txtappointment']."',basic_salary='".$_POST['txtbasic_salary']."',gross_pay='".$_POST['txtgross_pay']."' where email='$email'";
    if (mysqli_query($conn, $sql)) {
        header("Location: profile.php");
    } else {
        $_SESSION['error'] = 'Editing Was Not Successful';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Profile | <?php echo htmlspecialchars($sitename); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="../<?php echo htmlspecialchars($logo); ?>">

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
            max-width: 800px;
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
        }

        .modern-btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
            color: #fff;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 20px;
        }

        @media (max-width: 767px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .modern-form-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body class="employee-dashboard">
    <div id="wrapper">
        <?php include('employee_sidebar_shell.php'); ?>

        <div id="page-wrapper" class="gray-bg">
            <?php
            $employeePageTitle = 'Edit Profile';
            $employeePageSubtitle = 'Update your employee details, department information, and payroll fields from one organized form.';
            $employeeHeaderButtonLink = 'profile.php';
            $employeeHeaderButtonLabel = 'My Profile';
            include('employee_header.php');
            
            $sql = "select * from tblemployee where email='$email'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            ?>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="modern-form-container">
                    <div class="modern-form-card">
                        <h2 class="form-title">Edit Employee Profile</h2>
                        <form action="" method="POST">
                            
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="txtfullname" value="<?php echo htmlspecialchars($row['fullname'] ?? ''); ?>" class="form-control" required="">
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Sex</label>
                                    <select name="cmdsex" id="cmdsex" class="form-control" required="">
                                        <option value="<?php echo htmlspecialchars($row['sex'] ?? ''); ?>"><?php echo htmlspecialchars($row['sex'] ?? ''); ?></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Date of Birth</label> 
                                    <input type="text" name="txtdob" value="<?php echo htmlspecialchars($row['dob'] ?? ''); ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Phone Number</label> 
                                    <input type="text" name="txtphone" value="<?php echo htmlspecialchars($row['phone'] ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Address</label> 
                                    <input type="text" name="txtaddress" value="<?php echo htmlspecialchars($row['address'] ?? ''); ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Qualification</label> 
                                <input type="text" name="txtqualification" value="<?php echo htmlspecialchars($row['qualification'] ?? ''); ?>" class="form-control">
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select name="cmddept" id="cmddept" class="form-control" required="">
                                        <option value="<?php echo htmlspecialchars($row['dept'] ?? ''); ?>"><?php echo htmlspecialchars($row['dept'] ?? ''); ?></option>
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

                                <div class="form-group">
                                    <label>Employee Type</label>
                                    <select name="cmdemployeetype" id="cmdemployeetype" class="form-control" required="">
                                        <option value="<?php echo htmlspecialchars($row['employee_type'] ?? ''); ?>"><?php echo htmlspecialchars($row['employee_type'] ?? ''); ?></option>
                                        <option value="Academic">Academic</option>
                                        <option value="Non-Academic">Non-Academic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Date of Appointment</label> 
                                <input type="text" name="txtappointment" value="<?php echo htmlspecialchars($row['date_appointment'] ?? ''); ?>" class="form-control">
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Basic Salary (N)</label> 
                                    <input type="number" name="txtbasic_salary" value="<?php echo htmlspecialchars($row['basic_salary'] ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Gross Pay (N)</label> 
                                    <input type="number" name="txtgross_pay" value="<?php echo htmlspecialchars($row['gross_pay'] ?? ''); ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 2rem;">
                                <button class="modern-btn-primary" type="submit" name="btnedit">
                                    <i class="fa fa-save"></i> Save Changes
                                </button>
                            </div>
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
    <?php if (!empty($_SESSION['success'])) {  ?>
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
    <?php unset($_SESSION["success"]);
    } ?>
    <?php if (!empty($_SESSION['error'])) {  ?>
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
    <?php unset($_SESSION["error"]);
    } ?>
    <script>
        var addButtonTrigger = function addButtonTrigger(el) {
            el.addEventListener('click', function() {
                var popupEl = document.querySelector('.' + el.dataset.for);
                if (popupEl) popupEl.classList.toggle('popup--visible');
            });
        };
        Array.from(document.querySelectorAll('button[data-for]')).forEach(addButtonTrigger);
    </script>
</body>
</html>
