<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$userManagementPages = ['add-admin.php', 'edit_profile.php', 'edit-photo.php', 'user-record.php'];
$userMenuOpen = in_array($currentPage, $userManagementPages, true);
?>
<li class="nav-item">
  <a href="index.php" class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-chart-pie"></i>
    <p>Overview</p>
  </a>
</li>

<li class="nav-item has-treeview <?php echo $userMenuOpen ? 'menu-open' : ''; ?>">
  <a href="#" class="nav-link <?php echo $userMenuOpen ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-users-cog"></i>
    <p>
      User Management
      <i class="right fas fa-angle-right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="add-admin.php" class="nav-link <?php echo $currentPage === 'add-admin.php' ? 'active' : ''; ?>">
        <i class="far fa-plus-square nav-icon"></i>
        <p>Add User</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="edit_profile.php" class="nav-link <?php echo $currentPage === 'edit_profile.php' ? 'active' : ''; ?>">
        <i class="far fa-id-card nav-icon"></i>
        <p>Edit Profile</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="edit-photo.php" class="nav-link <?php echo $currentPage === 'edit-photo.php' ? 'active' : ''; ?>">
        <i class="far fa-image nav-icon"></i>
        <p>Edit Photo</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="user-record.php" class="nav-link <?php echo $currentPage === 'user-record.php' ? 'active' : ''; ?>">
        <i class="far fa-address-book nav-icon"></i>
        <p>Admin Record</p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item">
  <a href="leave_record.php" class="nav-link <?php echo $currentPage === 'leave_record.php' ? 'active' : ''; ?>">
    <i class="nav-icon far fa-calendar-check"></i>
    <p>Leave Management</p>
  </a>
</li>

<li class="nav-item">
  <a href="changepassword.php" class="nav-link <?php echo $currentPage === 'changepassword.php' ? 'active' : ''; ?>">
    <i class="nav-icon fas fa-key"></i>
    <p>Change Password</p>
  </a>
</li>

<li class="nav-item nav-item-spacer"></li>

<li class="nav-item">
  <a href="logout.php" class="nav-link logout-link">
    <i class="nav-icon fas fa-sign-out-alt"></i>
    <p>Logout</p>
  </a>
</li>
