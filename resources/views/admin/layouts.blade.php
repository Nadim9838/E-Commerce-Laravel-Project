<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Nadim E-Commerce Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nadim E-Commerce Project" name="description" />
    <meta content="Nadim E-Commerce Project" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- plugin css -->
    <link href="{{ asset('admin//libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Layout Js -->
    <script src="{{ asset('admin//js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
  </head>

  <body data-sidebar="colored">
    <!-- Begin page -->
    <div id="layout-wrapper">
      <header id="page-topbar">
        <div class="navbar-header">
          <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
              <a href="{{route('dashboard')}}" class="logo logo-dark">
                <span class="logo-sm">
                  <img src="{{ asset('admin/images/situ_watch_logo_dark.png') }}" alt="logo-sm-dark" height="24">
                </span>
                <span class="logo-lg">
                  <img src="{{ asset('admin/images/situ_watch_logo_dark.png') }}" alt="logo-dark" height="25">
                </span>
              </a>

              <a href="{{route('dashboard')}}" class="logo logo-light">
                <span class="logo-sm">
                  <img src="{{ asset('admin/images/situ_watch_logo_light.png') }}" alt="logo-sm-light" height="24">
                </span>
                <span class="logo-lg">
                  <img src="{{ asset('admin/images/situ_watch_logo_light.png') }}" alt="logo-light" height="25">
                </span>
              </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>
  
            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
              <h4 class="page-title mb-0">@yield('title')</h4>
            </div>
            <!-- end page title -->
          </div>

          <div class="d-flex">
            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
              <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="ri-search-line"></span>
              </div>
            </form>

            <div class="dropdown d-inline-block d-lg-none ms-2">
              <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ri-search-line"></i>
              </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
        
                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Full screen button --}}
            <div class="dropdown d-none d-lg-inline-block ms-1">
              <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                <i class="ri-fullscreen-line"></i>
              </button>
            </div>

            {{-- Dark and Light Mode  Setting Button --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="ri-settings-2-line"></i>
                </button>
            </div>
          </div>
        </div>
      </header>

      <!-- ========== Left Sidebar Start ========== -->
      <div class="vertical-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <a href="{{route('dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
              <img src="{{ asset('admin/images/logo-sm-dark.png') }}" alt="logo-sm-dark" height="45">
            </span>
            <span class="logo-lg">
              <img src="{{ asset('admin/images/logo-dark.png') }}" alt="logo-dark" height="65">
            </span>
          </a>

          <a href="{{route('dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
              <img src="{{ asset('admin/images/situ_watch_logo_light.png') }}" alt="logo-sm-light" height="45">
            </span>
            <span class="logo-lg">
              <img src="{{ asset('admin/images/situ_watch_logo_light.png') }}" alt="logo-light" height="65">
            </span>
          </a>
        </div>

        {{-- Hide Sidebar button --}}
        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn" id="vertical-menu-btn">
          <i class="ri-menu-2-line align-middle"></i>
        </button>

        <div data-simplebar class="vertical-scroll">
          <!--- Sidemenu -->
          <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect">
                        {{-- <i class="uim uim-airplay"></i><span class="badge rounded-pill bg-success float-end">3</span> --}}
                        <span><i class="fa-solid fa-gauge"></i>Dashboard</span>
                    </a>
                </li>
                <li>
                  <a href="{{route('order_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-box-open"></i> Order Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('product_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-clipboard-list"></i> Product Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('category_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-tags"></i> Category Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('cart_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-cart-shopping"></i> Cart Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('wishlist_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-heart"></i> Wishlist Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('coupon_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-ticket-alt"></i> Coupon Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('branch_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-code-branch"></i> Branch Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('client_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-handshake"></i> Client Management</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('user_management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-users"></i> User Management</span>
                  </a>
                </li>
            </ul>
          </div>
          <!-- Sidebar -->
        </div>

        {{-- User Profile --}}
        <div class="dropdown px-3 sidebar-user sidebar-user-info">
          <button type="button" class="btn w-100 px-0 border-0" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <img src="{{ asset('admin/images/users/avatar-3.jpg') }}" class="img-fluid header-profile-user rounded-circle" alt="">
              </div>

              <div class="flex-grow-1 ms-2 text-start">
                <span class="ms-1 fw-medium user-name-text">Nadim Ahmad</span>
              </div>

              <div class="flex-shrink-0 text-end">
                <i class="mdi mdi-dots-vertical font-size-16"></i>
              </div>
            </span>
          </button>
        </div>
      </div>
      <!-- Left Sidebar End -->

      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="main-content">
        <div class="page-content">
          <div class="container-fluid">
            @yield('content')
          </div>
          <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
          
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Nadim E-Commerce Project.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                          <a href="https://www.mediatechtemple.com/web-design-and-development-services/" style="color:#919bae" target="_blank">Designed and developed by </a>
                          <a href="https://mediatechtemple.com/" style="color:#919bae" target="_blank">Media Tech Temple</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
      </div>
      <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
      <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
          <h5 class="m-0 me-2">Settings</h5>

          <a href="javascript:void(0)" class="right-bar-toggle ms-auto">
            <i class="mdi mdi-close noti-icon"></i>
          </a>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <h6 class="text-center mb-0">Choose Layouts</h6>

        <div class="p-4">
          <div class="mb-2">
            <img src="{{ asset('admin/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail" alt="layout-1">
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
            <label class="form-check-label" for="light-mode-switch">Light Mode</label>
          </div>

          <div class="mb-2">
            <img src="{{ asset('admin/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail" alt="layout-2">
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="{{ asset('admin/css/bootstrap-dark.min.css') }}" data-appStyle="{{ asset('admin/css/app-dark.min.html') }}">
            <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
          </div>            
        </div>
      </div>
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('admin/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <script src="{{ asset('admin/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin/js/app.js') }}"></script>
  </body>
</html>