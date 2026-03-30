<?php
$sidebarPhoto = '';
$sidebarName = 'Administrator';

if (!empty($admin_photo)) {
    $sidebarPhoto = '../' . $admin_photo;
} elseif (!empty($row_admin['photo'])) {
    $sidebarPhoto = '../' . $row_admin['photo'];
}

if (!empty($admin_fullname)) {
    $sidebarName = $admin_fullname;
} elseif (!empty($row_admin['fullname'])) {
    $sidebarName = $row_admin['fullname'];
}
?>
<aside class="main-sidebar elevation-0">
  <a href="index.php" class="brand-link">
    <span class="brand-mark"><i class="fas fa-layer-group"></i></span>
    <span class="brand-copy">
      <strong>AKPOLY Admin</strong>
      <span>Control center</span>
    </span>
  </a>

  <div class="sidebar">
    <div class="sidebar-profile">
      <?php if ($sidebarPhoto !== '') { ?>
        <img src="<?php echo $sidebarPhoto; ?>" alt="Admin profile">
      <?php } else { ?>
        <div class="sidebar-profile-fallback"><i class="fas fa-user"></i></div>
      <?php } ?>
      <div>
        <div class="font-weight-bold"><?php echo htmlspecialchars($sidebarName); ?></div>
        <small>Administrator</small>
      </div>
    </div>

    <div class="form-inline mb-3">
      <div class="input-group w-100" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search menu" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav class="mt-1 d-flex flex-column h-100">
      <ul class="nav nav-pills nav-sidebar flex-column h-100" data-widget="treeview" role="menu" data-accordion="false">
        <?php include('sidebar.php'); ?>
      </ul>
    </nav>
  </div>
</aside>
