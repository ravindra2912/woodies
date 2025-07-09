<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link">
      <span class="brand-text font-weight-light">Bajarang</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="javascript:;" class="d-block">Welcome {{ (isset(Auth::user()->name)) ? ucwords(Auth::user()->name) : '' }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="{{ route('seller.dashboard') }}" class="nav-link {{ (Request::segment(2) == 'dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="javascript:;" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link {{ (Request::segment(2) == 'category') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-book"></i><p>Main Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('subcategory.index') }}" class="nav-link {{ (Request::segment(2) == 'subcategory') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-book"></i><p>Sub Category1</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('subcategory2.index') }}" class="nav-link {{ (Request::segment(2) == 'subcategory2') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-book"></i><p>Sub Category2</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('product.index') }}" class="nav-link {{ (Request::segment(2) == 'product') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i><p>Product</p>
            </a>
          </li>

		  <li class="nav-item">
            <a href="{{ route('coupons.index') }}" class="nav-link {{ (Request::segment(2) == 'coupons') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tag"></i><p>Coupons</p>
            </a>
          </li>
		  
		  <li class="nav-item">
            <a href="{{ route('Order.index') }}" class="nav-link {{ (Request::segment(2) == 'Order') ? 'active' : '' }}">
              <i class="nav-icon fas fa-box"></i><p>Orders</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>