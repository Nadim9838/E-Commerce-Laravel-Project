<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Nadim E-Commerce Project')</title>
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  @stack('styles')
</head>
<body>   
  <button onclick="scrollToTop()" id="scrollTopBtn" title="Go to top"><i class="fa-solid fa-arrow-up"></i></button>
  <!-- Header -->
  <div class="upperheader">
    <div class="container">
      <div class="upperheader-box">
        <div class="socialmedia-upper">
          <a href="https://wa.me/919782473777" target="_blank">
            <i class="fa-brands fa-whatsapp"></i>+91 9782473777
          </a>
          <a href="mailto:titanbharatpur@gmail.com">
            <i class="fa-regular fa-envelope"></i>titanbharatpur@gmail.com
          </a>
        </div>
        <div class="socialmedia-upper">
          <a href="https://www.google.com/maps/search/?api=1&query=Situ+watch+%26+eyewear" target="_blank">
            <i class="fa-solid fa-location-dot"></i>Find a Store
          </a>
        </div>
      </div>  
    </div>
  </div>
  <div class="container-fluid">
    <header class="navbar">
    <button class="hamburger" id="menuToggle"><i class="fa-solid fa-bars"></i></button>
    <div class="logo"><a href="#"><img src="{{ asset('frontend/images/c2 logo 2-01.png') }}" alt=""></a></div>
    <nav class="menu" id="navMenu">
      <ul>
        <li class="dropdown">
          <a href="#">Brands <i class="fa-solid fa-angle-down"></i></a>
          <div class="mega-dropdown">
            <!-- Full width dropdown content here -->
            <div class="mega-content">
              <div class="dropdown-list1">
                <h4>Top Brands</h4>
                @foreach($Brands->chunk(7) as $chunks)
                  <ul>
                      @foreach($chunks as $brand)
                        <li class="brand-lists"><a href="{{ route('brand.collection', $brand->slug) }}">{{ $brand->brand_name }}</a></li>
                      @endforeach
                  </ul>
                @endforeach
              </div>
            </div>
          </div>
        </li>
        <li class="dropdown">
          <a href="#">Accessories <i class="fa-solid fa-angle-down"></i></a>
          <div class="mega-dropdown">
            <!-- Full width dropdown content here -->
            <div class="mega-content">
              <div class="dropdown-list">
                <h4>Top Brands</h4>
                @foreach($Brands->chunk(2) as $chunks)
                  <ul>
                      @foreach($chunks as $brand)
                        <li class="brand-list"><a href="{{ route('brand.collection', $brand->slug) }}">{{ $brand->brand_name }}</a></li>
                      @endforeach
                  </ul>
                @endforeach
              </div>
              <div class="dropdown-list">
                <h4>Luxury</h4>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
              </div>
              <div class="dropdown-list">
                <h4>Luxury</h4>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
              </div>
              <div class="dropdown-list">
                <h4>Luxury</h4>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li class="dropdown"><a href="#">Watch Finder <i class="fa-solid fa-angle-down"></i></a>
          <div class="mega-dropdown">
            <!-- Full width dropdown content here -->
            <div class="mega-content">
              <div>
                <h4>Top Brands</h4>
                <ul>
                  <li><a href="#">Rolex</a></li>
                  <li><a href="#">Fossil</a></li>
                  <li><a href="#">Tissot</a></li>
                </ul>
                <ul>
                  <li><a href="#">Rolex</a></li>
                  <li><a href="#">Fossil</a></li>
                  <li><a href="#">Tissot</a></li>
                </ul>
                <ul>
                  <li><a href="#">Rolex</a></li>
                  <li><a href="#">Fossil</a></li>
                  <li><a href="#">Tissot</a></li>
                </ul>
                <ul>
                  <li><a href="#">Rolex</a></li>
                  <li><a href="#">Fossil</a></li>
                  <li><a href="#">Tissot</a></li>
                </ul>
                <ul>
                  <li><a href="#">Rolex</a></li>
                  <li><a href="#">Fossil</a></li>
                  <li><a href="#">Tissot</a></li>
                </ul>
              </div>
              <div>
                <h4>Luxury</h4>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
              </div>
              <div>
                <h4>Luxury</h4>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
              </div>
              <div>
                <h4>Luxury</h4>
                <ul>
                  <li><a href="#">Omega</a></li>
                  <li><a href="#">Cartier</a></li>
                  <li><a href="#">Rado</a></li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li><a href="#">Smart Watch <i class="fa-solid fa-angle-down"></i></a></li>
        <li><a href="#">Special Offer <i class="fa-solid fa-angle-down"></i></a></li>
      </ul>
    </nav>



    <div class="nav-actions">
      <!-- Watchlist Icon -->
       <button id="searchBtn"><i class="fa-solid fa-magnifying-glass"></i></button>
      <button id="watchlistBtn"><i class="fa-solid fa-heart"></i></button>
      <!-- Cart Icon -->
      <button id="cartBtn" title="Cart">
        <i class="fa-solid fa-cart-shopping"></i>
      </button>
      <!-- Modal -->
      <!-- Cart Modal -->
      <div id="cartModal" class="cart-modal">
        <div class="cart-modal-content">
          <span class="closeBtn"><i class="fa-solid fa-xmark"></i></span>
          <h2>Shopping Cart</h2>
          <!-- Product Item -->
          <div class="cart-item">
            <img src="{{ asset('frontend/images/day-date-softest-silicone-strap-analog-watch (1).jpg') }}" alt="Watch">
            <div class="item-details">
              <h4>BALMAIN Classic R B41013162 Watch for Men</h4>
              <p>₹ 45,200</p>
              <div class="qty-remove">
                <div class="quantity-control">
                  <button>-</button>
                  <span>3</span>
                  <button>+</button>
                </div>
                <a href="#">Remove</a>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="cart-footer">
            <div class="extras">
              <div><i class="fa-solid fa-pen"></i> Note</div>
              <div><i class="fa-solid fa-ticket"></i> Coupon</div>
            </div>
            <div class="subtotal">
              <span>Subtotal</span>
              <strong>₹ 135,600</strong>
            </div>
            <button class="checkout-btn">Check out</button>
            <a href="#" class="view-cart-link">View Cart</a>
          </div>
        </div>
      </div>

      <div class="profile-dropdown-wrapper">
        <button id="profileBtn" title="Profile">
          <i class="fa-solid fa-user"></i>
        </button>
        <div class="profile-dropdown" id="profileDropdown">
          @if(auth()->guard('client')->check())
            <a href="{{ route('user-profile') }}"><i class="fas fa-user-circle"></i> Profile</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          @else
            <a href="{{ route('user-login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="{{ route('user-register') }}"><i class="fas fa-user-plus"></i> Register</a>
          @endif
        </div>
      </div>
    </div>
  </header>

  </div>
  <div id="searchBar" class="hidden">
    <input type="text" placeholder="Search..." />
  </div>
  <div id="watchlist" class="hidden">
    <p>Watchlist is empty.</p>
  </div>
  <!-- Header end -->

  {{ $slot }}

  <!-- Footer -->
  <footer class="custom-footer">
    <div class="container">
      <div class="footer-top">
        <div class="footer-col">
          <h4>Let’s get in touch</h4>
          <p>Sign up for our newsletter and receive 10% off your</p>
          <div class="newsletter">
            <span class="email-icon">&#9993;</span>
            <input type="email" placeholder="Enter your email" />
            <button>&#8594;</button>
          </div>
        </div>
        <div class="footer-col sides">
          <h4>Main menu</h4>
          <ul>
            <li><a href="#">Brands</a></li>
            <li><a href="#">Accessories</a></li>
            <li><a href="#">Watch Finder</a></li>
            <li><a href="#">Smartwatches</a></li>
            <li><a href="#">Special Offer</a></li>
          </ul>
        </div>
        <div class="footer-col sides">
          <h4>Information</h4>
          <ul>
            <li><a href="#">Corporate Sales</a></li>
            <li><a href="#">Service</a></li>
            <li><a href="#">Repair & Services</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Cancellation</a></li>
          </ul>
        </div>
        <div class="footer-col sides">
          <h4>Legal</h4>
          <ul>
            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
            <li><a href="{{ route('terms-conditions') }}">Terms of Use</a></li>
            <li><a href="{{ route('privacy-policy') }}">Shipping Policy</a></li>
          </ul>
        </div>
        <div class="footer-col store">
          <h4>Our store</h4>
          <div class="social-icons">
            <a href="#" class="icons facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="icons instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="icons whatsapp"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p><script>document.write(new Date().getFullYear())</script> <i class="fa-regular fa-copyright"></i> Nadim E-Commerce Project. 
          <a href="https://www.mediatechtemple.com/web-design-and-development-services/" target="_blank">Website Developed By </a>
          <a href="https://mediatechtemple.com/" target="_blank">Media Tech Temple</a>
        </p>
      </div>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend/js/script.js') }}"></script>
  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  @stack('scripts')
  <script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };
    
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
  </script>
</body>
</html>
