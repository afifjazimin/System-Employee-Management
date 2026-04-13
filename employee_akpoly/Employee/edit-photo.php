<?php
include('../inc/topbar.php'); 
if(empty($_SESSION['login_email']))
    {   
      header("Location: login.php"); 
    }

if(isset($_POST["btnedit"]))
{
$image= addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$image_name= addslashes($_FILES['userImage']['name']);
$image_size= getimagesize($_FILES['userImage']['tmp_name']);
move_uploaded_file($_FILES["userImage"]["tmp_name"],"../uploadImage/Profile/" . $_FILES["userImage"]["name"]);			
$location="uploadImage/Profile/" . $_FILES["userImage"]["name"];
			
$sql = " update tblemployee set photo='$location' where email='$email'";
   
   if (mysqli_query($conn, $sql)) {
header("Location: profile.php");
}else{
$_SESSION['error']='Editing Was Not Successful';
}
}
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Employee Photo | <?php echo htmlspecialchars($sitename); ?></title>
    
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
            text-align: center;
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

        .photo-preview {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.12);
            margin: 0 auto 2rem;
            background: #f1f5f9;
        }

        .file-input-wrapper {
            margin-bottom: 2rem;
            text-align: left;
        }

        .modern-form-card label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.75rem;
            display: inline-block;
            text-align: left;
            width: 100%;
        }

        .modern-form-card .form-control {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            height: auto;
            transition: all 0.2s;
            box-shadow: none;
            width: 100%;
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
            cursor: pointer;
        }

        .modern-btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
            color: #fff;
        }
        
        /* Stylize file input */
        input[type="file"].inputFile {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background: #f8fafc;
            color: var(--text);
            cursor: pointer;
            transition: border 0.3s;
        }
        
        input[type="file"].inputFile:hover {
            border-color: var(--muted);
        }
    </style>
</head>

<body class="employee-dashboard">
   <div id="wrapper">
    <?php include('employee_sidebar_shell.php'); ?>

        <div id="page-wrapper" class="gray-bg">
        <?php
        $employeePageTitle = 'Edit Photo';
        $employeePageSubtitle = 'Refresh your profile image while keeping the rest of your employee record unchanged.';
        $employeeHeaderButtonLink = 'profile.php';
        $employeeHeaderButtonLabel = 'My Profile';
        include('employee_header.php');
        
        $sql = "select * from tblemployee where email='$email'"; 
        $result = $conn->query($sql);
        $row= mysqli_fetch_array($result);
        ?>
        
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="modern-form-container">
                <div class="modern-form-card">
                    <h2 class="form-title">Edit Employee Photo</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <img src="../<?php echo !empty($rowaccess['photo']) ? htmlspecialchars($rowaccess['photo']) : 'images/default_avatar.png'; ?>" alt="user image" class="photo-preview" id="logo-img">
                        
                        <div class="file-input-wrapper">
                            <label>Upload New Photo (JPG, PNG)</label>
                            <input name="userImage" type="file" class="inputFile" accept="image/png,image/jpeg,image/jpg" onChange="display_img(this)"/>
                        </div>
                        
                        <button class="modern-btn-primary" type="submit" name="btnedit">
                            <i class="fa fa-cloud-upload"></i> Upload & Save
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
