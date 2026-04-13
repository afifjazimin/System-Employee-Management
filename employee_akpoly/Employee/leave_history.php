<?php
include('../inc/topbar.php'); 
if(empty($_SESSION['login_email']))
    {   
      header("Location: login.php"); 
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave History | <?php echo htmlspecialchars($sitename); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="../image/employeesystem.png">

    <style>
        :root {
            --surface: #ffffff;
            --border: #f1f5f9;
            --text: #334155;
            --muted: #64748b;
            --primary: #0f172a;
            --bg: #f8fafc;
        }

        body.employee-dashboard {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--text);
        }
        
        #page-wrapper.gray-bg, #wrapper {
            background: var(--bg);
        }

        /* Modern Table Container Frame */
        .modern-table-card {
            background: var(--surface);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 2.5rem;
            border: 1px solid #e2e8f0;
        }

        .table-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 25px 0;
        }

        /* Top Controls matching reference */
        .dataTables_wrapper {
            font-size: 0.95rem;
            color: #475569;
        }
        .dataTables_filter input {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 8px 14px;
            margin-left: 8px;
            outline: none;
            transition: border-color 0.2s;
            width: 200px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        .dataTables_filter input:focus {
            border-color: #94a3b8;
        }
        .dataTables_length select {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 8px 25px 8px 12px;
            outline: none;
            margin: 0 5px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .dataTables_wrapper .row:first-child {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        /* The Actual Grid Layout */
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 0 !important;
            margin-bottom: 30px !important;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        table.dataTable thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 18px 24px !important;
            position: relative;
        }
        table.dataTable tbody td {
            vertical-align: middle !important;
            padding: 18px 24px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        table.dataTable.table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #ffffff;
        }
        table.dataTable.table-striped > tbody > tr:nth-of-type(even) {
            background-color: #f8fafc;
        }
        table.dataTable.table-hover > tbody > tr:hover {
            background-color: #f1f5f9;
        }

        /* Employee Cell Styling */
        .emp-profile-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .emp-avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            background: #e2e8f0;
            border: 1px solid #cbd5e1;
        }
        .emp-details {
            display: flex;
            flex-direction: column;
            line-height: 1.4;
        }
        .emp-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 1rem;
        }
        .emp-email {
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 400;
        }

        /* Leave ID Format */
        .leave-id-badge {
            background: #ffffff;
            color: #334155;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        /* Dots Pill */
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            gap: 8px;
            letter-spacing: 0.3px;
        }
        .status-pill::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        /* Pill variants matching image exact colors */
        .status-approved {
            background: #dcfce7;
            color: #16a34a;
        }
        .status-approved::before { background: #16a34a; }
        
        .status-pending {
            background: #fff7ed;
            color: #ea580c;
        }
        .status-pending::before { background: #ea580c; }
        
        .status-declined {
            background: #fef2f2;
            color: #dc2626;
        }
        .status-declined::before { background: #dc2626; }

        /* Actions */
        .action-btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
            color: #ef4444;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }
        .action-btn-danger:hover {
            background: #fee2e2;
            color: #dc2626;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
        }
        
        /* Remove default framework borders inside grid */
        .table-bordered { border: none; }
        .table-bordered > tbody > tr > td, 
        .table-bordered > thead > tr > th { border-left: none; border-right: none; }

        /* Pagination Clean Up */
        .dataTables_paginate {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pagination {
            margin: 0;
        }
        .pagination > li > a {
            border: none;
            color: #64748b;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 16px;
            margin: 0 4px;
            background: transparent;
        }
        .pagination > li > a:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .pagination > .active > a, 
        .pagination > .active > a:focus, 
        .pagination > .active > a:hover {
            background-color: #ffffff;
            color: #0f172a;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        /* Hide Default Sorting Icons (they clash with beautiful fonts) */
        table.dataTable thead .sorting { background-image: none !important; }
        table.dataTable thead .sorting_asc { background-image: none !important; }
        table.dataTable thead .sorting_desc { background-image: none !important; }

        /* Custom Sort Icons using FontAwesome */
        table.dataTable thead th {
             padding-right: 30px !important;
        }
        table.dataTable thead th:after {
            content: "\f0dc";
            font-family: FontAwesome;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            font-size: 0.9rem;
            font-weight: normal;
        }
        table.dataTable thead th.sorting_asc:after {
            content: "\f0de";
            color: #3b82f6;
        }
        table.dataTable thead th.sorting_desc:after {
            content: "\f0dd";
            color: #3b82f6;
        }

    </style>

    <script type="text/javascript">
		function deldata(){
            if(confirm("Are you sure you wish to delete this leave application from your record?")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>

<body class="employee-dashboard">

  <div id="wrapper">
    <?php include('employee_sidebar_shell.php'); ?>

         <div id="page-wrapper" class="gray-bg">
        <?php
        $employeePageTitle = 'Leave History';
        $employeePageSubtitle = 'Review your leave requests, status updates, and previous applications.';
        $employeeHeaderButtonLink = 'apply_leave.php';
        $employeeHeaderButtonLabel = 'Apply Leave';
        include('employee_header.php');
        ?>
        
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="modern-table-card">
                        
                        <h3 class="table-title">Leave Applications</h3>
                        
                        <div class="table-responsive">
                            <table class="table dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave ID</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM tblleave WHERE email='$email' ORDER BY start_date DESC";
                                $result = $conn->query($sql);
                                while($row = $result->fetch_assoc()) { 
                                ?>
                                    <tr>
                                        <td>
                                            <div class="emp-profile-cell">
                                                <img src="../<?php echo !empty($rowaccess['photo']) ? htmlspecialchars($rowaccess['photo']) : 'images/default_avatar.png'; ?>" alt="avatar" class="emp-avatar">
                                                <div class="emp-details">
                                                    <span class="emp-name"><?php echo htmlspecialchars($rowaccess['fullname']); ?></span>
                                                    <span class="emp-email"><?php echo htmlspecialchars($rowaccess['email']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="leave-id-badge"><?php echo htmlspecialchars($row['leaveID']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['start_date']);  ?></td>
                                        <td><?php echo htmlspecialchars($row['end_date']);  ?></td>
                                        <td><?php echo htmlspecialchars($row['reason']);  ?></td>
                                        <td>
                                            <?php if($row['status'] == "Pending") { ?>
                                                <span class="status-pill status-pending">Pending</span>
                                            <?php } else if($row['status'] == "Approved") { ?>
                                                <span class="status-pill status-approved">Approved</span>
                                            <?php } else if($row['status'] == "Declined") { ?>
                                                <span class="status-pill status-declined">Declined</span>
                                            <?php } else { ?>
                                                <span class="status-pill"><?php echo htmlspecialchars($row['status']); ?></span>
                                            <?php } ?>		
                                        </td>
                                        <td>
                                            <a class="action-btn-danger" href="delete_leave.php?id=<?php echo urlencode($row['leaveID']);?>" onClick="return deldata();">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
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

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            var table = $('.dataTables-example').DataTable({
                responsive: true,
                "bAutoWidth": false,
                "language": {
                    "lengthMenu": "Show   _MENU_   entries",
                    "search": "Search: ",
                    "info": "Showing _START_ to _END_ of _TOTAL_ employees",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next"
                    }
                }
            });

            // Float positioning to match the design flawlessly
            $('.dataTables_length').css('float', 'left');
            $('.dataTables_filter').css('float', 'right');
            $('.dataTables_info').css('float', 'left');
            $('.dataTables_info').css('color', '#64748b');
            $('.dataTables_info').css('font-weight', '500');
            $('.dataTables_paginate').css('float', 'right');
            
            // Flex styling for the top row elements
            $('.dataTables_wrapper > .row:first-child').css({
                'display': 'flex',
                'justify-content': 'space-between',
                'align-items': 'center',
                'width': '100%'
            });
            // Flex styling for bottom row elements
            $('.dataTables_wrapper > .row:last-child').css({
                'display': 'flex',
                'justify-content': 'space-between',
                'align-items': 'center',
                'width': '100%',
                'margin-top': '20px'
            });
        });
    </script>
</body>
</html>
