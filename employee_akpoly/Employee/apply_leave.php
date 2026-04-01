<?php
include('../inc/topbar.php'); 
if(empty($_SESSION['login_email']))
    {   
      header("Location: ../Account/login.php"); 
    }
 

 if(isset($_POST["btnapply"])){
    $leaveID= date("Y").rand(100,509);  

//check if leave is still pending 
$selectquery="SELECT * FROM tblleave ORDER BY leaveID DESC LIMIT 1";
$result = $conn->query($selectquery);
$row = $result->fetch_assoc();
$status= $row['status'] ?? '';

if ($status == 'Pending') {
    $_SESSION['error'] ='Previous Leave Application is still pending';
} else {
    $sql = 'INSERT INTO tblleave(email,leaveID,start_date,end_date,reason,status) VALUES(:email,:leaveID,:start_date,:end_date,:reason,:status)';
    $statement = $dbh->prepare($sql);
    $statement->execute([
    ':email' => $email ,
    ':leaveID' => $leaveID,
    ':start_date' => $_POST['txtstart_date'],
    ':end_date' => $_POST['txtend_date'],
    ':reason' => $_POST['cmdreason'],
    ':status' => 'Pending'

    ]);
    if ($statement){
        $_SESSION['success']='Leave ID: '.$leaveID. ' '.'.Leave Application Was successful but pending Approval.';
    } else {
     $_SESSION['error']='Something went Wrong';
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application | <?php echo htmlspecialchars($sitename); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="../image/employeesystem.png">

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
            max-width: 600px;
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
        $employeePageTitle = 'Leave Application';
        $employeePageSubtitle = 'Plan your time away and submit a leave request with the same streamlined dashboard layout.';
        $employeeHeaderButtonLink = 'leave_history.php';
        $employeeHeaderButtonLabel = 'Leave History';
        include('employee_header.php');
        ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="modern-form-container">
                <div class="modern-form-card">
                    <h2 class="form-title">Apply For Leave</h2>
                    <form role="form" method="POST">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="txtstart_date" value="<?php echo isset($_POST['txtstart_date']) ? htmlspecialchars($_POST['txtstart_date']) : ''; ?>" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="txtend_date" value="<?php echo isset($_POST['txtend_date']) ? htmlspecialchars($_POST['txtend_date']) : ''; ?>" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Reason</label>
                            <select class="form-control" id="cmdreason" name="cmdreason" required>
                                <option value="">Select Reason</option>
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Study Leave">Study Leave</option>
                                <option value="Monthly Leave">Monthly Leave</option>
                                <option value="Maternity Leave">Maternity Leave</option>
                            </select>                                   
                        </div>
                        
                        <button class="modern-btn-primary" type="submit" name="btnapply">
                            <i class="fa fa-calendar-plus-o"></i> Submit Application
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
