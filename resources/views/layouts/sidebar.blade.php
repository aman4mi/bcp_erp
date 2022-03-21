<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link text-decoration-none py-3">
    <img src="{{ asset('images/bcps.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">BCPS ERP</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('exam-dashboard') }}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('list-exam-info-update') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Exam Info Update</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>