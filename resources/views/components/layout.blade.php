<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Nadim E-Commerce Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Nadim E-Commerce Project" name="description" />
    <meta content="Nadim E-Commerce Project" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- plugin css -->
    <link href="{{ asset('admin/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Layout Js -->
    <script src="{{ asset('admin/js/layout.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    {{-- DataTable --}}
    <link href="{{ asset('admin/DataTables/datatables.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    {{-- Admin Style --}}
    <link href="{{ asset('admin/css/admin_style.css') }}" id="app-style" rel="stylesheet" type="text/css" />
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
              <h4 class="page-title mb-0 text-primary">{{ $title ?? "Dashboard"}}</h4>
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
                        <span><i class="fa-solid fa-gauge"></i>Main Dashboard</span>
                    </a>
                </li>
                @if(session('user_permissions')['order']['view'] ?? false)
                <li>
                  <a href="{{route('order-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-box-open"></i> Order Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['product']['view'] ?? false)
                <li>
                  <a href="{{route('product-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-clipboard-list"></i> Product Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['brand']['view'] ?? false)
                <li>
                  <a href="{{route('brand-management')}}" class="waves-effect">
                      <span><i class="fa fa-building"></i> Brand Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['category']['view'] ?? false)
                <li>
                  <a href="javascript: void(0);" class="waves-effect has-arrow">
                  <span><i class="fa-solid fa-tags"></i> Category</span></a>
                  <ul class="sub-menu" aria-expanded="false">
                      <li><a href="{{route('category-management')}}">Main Category</a></li>
                      <li><a href="{{route('sub-category-management')}}">Sub Category</a></li>
                  </ul>
                </li>
                @endif

                @if(session('user_permissions')['cart']['view'] ?? false)
                <li>
                  <a href="{{route('cart-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-cart-shopping"></i> Cart Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['wishlist']['view'] ?? false)
                <li>
                  <a href="{{route('wishlist-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-heart"></i> Wishlist Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['client']['view'] ?? false)
                <li>
                  <a href="{{route('client-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-handshake"></i> Client Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['coupon']['view'] ?? false)
                <li>
                  <a href="{{route('coupon-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-ticket-alt"></i> Coupon Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['branch']['view'] ?? false)
                <li>
                  <a href="{{route('branch-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-code-branch"></i> Branch Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['user']['view'] ?? false)
                <li>
                  <a href="{{route('user-management')}}" class="waves-effect">
                      <span><i class="fa-solid fa-users"></i> User Management</span>
                  </a>
                </li>
                @endif

                @if(session('user_permissions')['website']['view'] ?? false)
                <li>
                  <a href="javascript: void(0);" class="waves-effect has-arrow">
                      <span><i class="fa-solid fa-globe"></i> Website Settings</span></a>
                      <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('tax-slab-settings')}}">Tax Slab Settings</a></li>
                        <li><a href="{{route('banner-image-settings')}}">Banner Image Settings</a></li>
                        <li><a href="{{route('special-offer-settings')}}">Special Offer Settings</a></li>
                        <li><a href="{{route('client-review-settings')}}">Client Review Settings</a></li>
                  </ul>
                  </a>
                </li>
                @endif
            </ul>
          </div>
          <!-- Sidebar -->
        </div>

        {{-- User Profile --}}
        <div class="dropdown px-3 sidebar-user sidebar-user-info">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit"
            class="btn border-0 bg-transparent d-flex align-items-center logout-btn"
            style="cursor: pointer;"
            onmouseover="this.querySelector('span').innerText = 'Click to logout';"
            onmouseout="this.querySelector('span').innerText = '{{ auth()->user()->name }}';">
        
        <img src="{{ auth()->user()->user_image ? asset('storage/' . auth()->user()->user_image) : asset('admin/images/users/avatar-3.jpg') }}"
             alt="User Image"
             class="rounded-circle me-2"
             width="40"
             height="40">

        <span class="fw-medium user-name-text">{{ auth()->user()->name }}</span>
    </button>
</form>
        </div>
      </div>
      <!-- Left Sidebar End -->

      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="main-content">
        <div class="page-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xl-12">
                @if (session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
            
                @if (session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                {{ $slot }}
              </div>
            </div>
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
    <script src="{{ asset('admin/DataTables/datatables.min.js') }}"></script>

    <!-- DataTables Buttons JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/3.2.0/js/dataTables.buttons.min.js" integrity="sha512-/iOthDtoEAAT8XBHzVM0DDacmcGS/3C2QRrGW5Q10S3W8RpeEbK65/WBdjeJtmzVcg1dAwnDceqCuP92HV4Kyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>

    <!-- Select Picker js --> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('admin/js/app.js') }}"></script>

    <!-- User Management js -->
    <script src="{{ asset('admin/js/admin_script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>