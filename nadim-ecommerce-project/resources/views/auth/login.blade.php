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
    <link href="{{ asset('admin/css/admin_style.css') }}" id="app-style" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
      <div class="bg-overlay bg-light"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="auth-full-page-content d-flex min-vh-100 py-4">
              <div class="w-100">
                <div class="d-flex flex-column h-100 py-0 py-xl-3">
                  <div class="text-center mb-4">
                      <h2 class="text-muted mt-2 animate-heading">Nadim E-Commerce Project</h2>
                  </div>
                  @if(session('status'))
                    <div class="alert alert-success mb-4">
                      {{ session('status') }}
                    </div>
                  @endif
                  
                  @if(session('error'))
                    <div class="alert alert-danger mb-4">
                      {{ session('error') }}
                    </div>
                  @endif
                  <div class="card my-auto overflow-hidden">
                    <div class="row g-0">
                      <div class="col-lg-6">
                          <div class="bg-overlay animate-bg-image bg-primary"></div>
                          <div class="h-100 bg-auth align-items-end">
                          </div>
                      </div>

                      <div class="col-lg-6 animate-login">
                        <div class="p-lg-5 p-4">
                          <div>
                            <div class="text-center mt-3">
                              <h4 class="font-size-18"><span class="wave-hand">👋</span> Welcome Back !</h4>
                              <p class="text-muted">Sign in to continue to Nadim E-Commerce Project.</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="auth-input">
                              @csrf
                              <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" autofocus>
                                @error('email')
                                  <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>

                              <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter password">
                                    <span class="position-absolute top-50 end-0 translate-middle-y me-2" style="cursor: pointer;" onclick="togglePassword()">
                                        <i class="mdi mdi-eye-outline" id="toggleIcon"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                              </div>
                              <div class="mt-5 mb-4">
                                <button class="btn btn-primary w-100" type="submit">Sign In</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>  
                    </div>
                  </div>
                  <!-- end card -->
                  
                  <div class="mt-5 text-center">
                      <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Nadim E-Commerce Project. <a href="https://www.mediatechtemple.com/web-design-and-development-services/" target="_blank">Designed and developed by </a>
                        <a href="https://mediatechtemple.com/" target="_blank">Media Tech Temple</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
    </div>
    
    <!-- JAVASCRIPT -->
    <script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/js/app.js') }}"></script>

    <script>
      function togglePassword() {
        var $passwordInput = $('#password');
        var $toggleIcon = $('#toggleIcon');

        if ($passwordInput.attr('type') === 'password') {
          $passwordInput.attr('type', 'text');
          $toggleIcon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
        } else {
          $passwordInput.attr('type', 'password');
          $toggleIcon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
        }
      }
    </script>
  </body>
</html>
