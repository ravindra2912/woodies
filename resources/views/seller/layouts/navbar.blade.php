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
      <!-- a href="javascript:;" class="brand-link">
      <span class="brand-text font-weight-light text-dark">Bajarang</span>
    </a -->

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="javascript:;" class="d-block">Welcome {{ (isset(Auth::user()->first_name)) ? ucwords(Auth::user()->first_name) : '' }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="{{ route('seller.dashboard') }}" class="nav-link {{ request()->routeIs('seller.dashboard*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>


            @if(Auth::user()->role_id == 1)
            <li class="nav-item">
              <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>Categories</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('Users.index') }}" class="nav-link {{ request()->routeIs('Users*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="{{ route('contactus.index') }}" class="nav-link {{ request()->routeIs('contactus*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-address-card"></i>
                <p>Contact Us</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('product.index') }}" class="nav-link {{ request()->routeIs('product*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>Product</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('coupons.index') }}" class="nav-link {{ request()->routeIs('coupons*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tag"></i>
                <p>Coupons</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('Order.index') }}" class="nav-link {{ request()->routeIs('Order*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p>Orders</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('sellerprofile') }}" class="nav-link {{ request()->routeIs('sellerprofile*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
              </a>
            </li>

            @if(Auth::user()->role_id == 1)
            <li class="nav-item {{ (request()->routeIs('lagel-pages*') || request()->routeIs('faq*') || request()->routeIs('social_links*') || request()->routeIs('site_seo*') || request()->routeIs('homebanner*')) ? 'menu-is-opening menu-open ' : '' }}">
              <a href="javascript:;" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p> Setting <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="{{ (request()->routeIs('lagel-pages*') || request()->routeIs('faq*') || request()->routeIs('social_links*') || request()->routeIs('site_seo*') || request()->routeIs('homebanner*') ) ? 'display: block;' : 'display: none;' }}">
                <li class="nav-item">
                  <a href="{{ route('site_seo') }}" class="nav-link {{ (Request::segment(3) == 'site_seo') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-globe-asia"></i>
                    <p>SEO</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('homebanner.index') }}" class="nav-link {{ request()->routeIs('homebanner*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-images"></i>
                    <p>Home Banner</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('faq.index') }}" class="nav-link {{ request()->routeIs('faq*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-images"></i>
                    <p>FAQ</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('lagel-pages') }}" class="nav-link {{ request()->routeIs('lagel-pages*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-contract"></i>
                    <p> Lagel Pages </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('social_links') }}" class="nav-link {{ request()->routeIs('social_links*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-link"></i>
                    <p>Social Links</p>
                  </a>
                </li>

              </ul>
            </li>
            @endif

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