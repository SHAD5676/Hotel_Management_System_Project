<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Hotel Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Pages -->
        <li class="nav-item">
          <a href="room.php" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Rooms</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="room_categories.php" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Room Categories</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="booking.php" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Bookings</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="payment.php" class="nav-link">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>Payments/Bills</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="customer.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Customers</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="check.php" class="nav-link">
            <i class="nav-icon fas fa-door-open"></i>
            <p>Check-in/Check-out</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="feedback.php" class="nav-link">
            <i class="nav-icon fas fa-comment-dots"></i>
            <p>Feedbacks/Reports</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="stuff.php" class="nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Users/Stuffs</p>
          </a>
        </li>

        <!-- Services with submenu -->
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Services
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="service_new.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="all_service.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Services</p>
                </a>
              </li>


            </ul>
          </li>
        </ul>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>