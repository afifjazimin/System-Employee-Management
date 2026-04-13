<?php 
session_start();
error_reporting(1);
include('../database/connect.php'); 
include('../database/connect2.php'); 

// Prevent authenticated pages from being served from browser cache after logout.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

//set time
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

//fetch user data
$email = $_SESSION["login_email"] ?? '';
$rowaccess = [];
$fullname = '';
$phone = '';
$photo = '';
$employeeID = '';
$leave_status = '';
$basic_salary = 0;
$gross_pay = 0;

if ($email !== '') {
    $stmt = $dbh->prepare("SELECT * FROM tblemployee WHERE email = ?");
    $stmt->execute([$email]);
    $rowaccess = $stmt->fetch() ?: [];
    $fullname = $rowaccess['fullname'] ?? '';
    $phone = $rowaccess['phone'] ?? '';
    $photo = $rowaccess['photo'] ?? '';
    $email = $rowaccess['email'] ?? $email;
    $employeeID = $rowaccess['employeeID'] ?? '';
    $leave_status = $rowaccess['leave_status'] ?? '';
    $basic_salary = $rowaccess['basic_salary'] ?? 0;
    $gross_pay = $rowaccess['gross_pay'] ?? 0;
}


$logo='image/logo.png';
$logo2='image/logo.jpeg';

//system setting
$sitename='Employee Management system';

//admin
$username = $_SESSION["admin-username"] ?? '';
$row_admin = [];
$admin_fullname = '';
$admin_photo = '';

if ($username !== '') {
    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $row_admin = $stmt->fetch() ?: [];
    $admin_fullname = $row_admin['fullname'] ?? '';
    $admin_photo = $row_admin['photo'] ?? '';
}

?>
