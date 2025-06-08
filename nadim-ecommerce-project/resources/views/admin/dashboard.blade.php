<x-layout>
    <x-slot:title>
        Nadim E-Commerce Project Dashboard
    </x-slot:title>

<div class="row">
  <div class="col-xl-8">
      <div class="card">
          <div class="card-header border-0 align-items-center d-flex pb-0">
              <h4 class="card-title mb-0 flex-grow-1">Audiences Metrics</h4>
              <div>
                  <button type="button" class="btn btn-soft-secondary btn-sm">
                      ALL
                  </button>
                  <button type="button" class="btn btn-soft-secondary btn-sm">
                      1M
                  </button>
                  <button type="button" class="btn btn-soft-secondary btn-sm">
                      6M
                  </button>
                  <button type="button" class="btn btn-soft-primary btn-sm">
                      1Y
                  </button>
              </div>
          </div>
          <div class="card-body">
              <div class="row align-items-center">
                  <div class="col-xl-8 audiences-border">
                      <div id="column-chart" class="apex-charts"></div>
                  </div>
                  <div class="col-xl-4">
                      <div id="donut-chart" class="apex-charts"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="col-xl-4">
      <div class="card">
          <div class="card-header border-0 align-items-center d-flex pb-1">
              <h4 class="card-title mb-0 flex-grow-1">Live Users By Country</h4>
              <div>
                  <button type="button" class="btn btn-soft-primary btn-sm">
                      Export Report
                  </button>
              </div>
          </div>
          <div class="card-body">
              <div id="world-map-markers" style="height: 346px;"></div>
          </div>
      </div>
  </div>
</div>
<!-- END ROW -->

<div class="row">
  <div class="col-xl-7">
      <div class="row">

          <div class="col-xl-6">
              <div class="card">
                  <div class="card-header border-0 align-items-center d-flex pb-0">
                      <h4 class="card-title mb-0 flex-grow-1">Source of Purchases</h4>
                      <div>
                          <div class="dropdown">
                              <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false">
                                  <span class="fw-semibold">Sort By:</span>
                                  <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end">
                                  <a class="dropdown-item" href="#">Yearly</a>
                                  <a class="dropdown-item" href="#">Monthly</a>
                                  <a class="dropdown-item" href="#">Weekly</a>
                                  <a class="dropdown-item" href="#">Today</a>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body pt-0">
                      <div id="social-source" class="apex-charts"></div>
                      <div class="social-content text-center">
                          <p class="text-uppercase mb-1">Total Sales</p>
                          <h3 class="mb-0">5,685</h3>
                      </div>
                      <p class="text-muted text-center w-75 mx-auto mt-4 mb-0">Magnis dis parturient montes
                          nascetur ridiculus tincidunt lobortis.</p>
                      <div class="row gx-4 mt-1">
                          <div class="col-md-4">
                              <div class="mt-4">
                                  <div class="progress" style="height: 7px;">
                                      <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="85">
                                      </div>
                                  </div>
                                  <p class="text-muted mt-2 pt-2 mb-0 text-uppercase font-size-13 text-truncate">E-Commerce
                                  </p>
                                  <h4 class="mt-1 mb-0 font-size-20">52,524</h4>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="mt-4">
                                  <div class="progress" style="height: 7px;">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                      </div>
                                  </div>
                                  <p class="text-muted mt-2 pt-2 mb-0 text-uppercase font-size-13 text-truncate">Facebook
                                  </p>
                                  <h4 class="mt-1 mb-0 font-size-20">48,625</h4>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="mt-4">
                                  <div class="progress" style="height: 7px;">
                                      <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="60">
                                      </div>
                                  </div>
                                  <p class="text-muted mt-2 pt-2 mb-0 text-uppercase font-size-13 text-truncate">Instagram
                                  </p>
                                  <h4 class="mt-1 mb-0 font-size-20">85,745</h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-6">
              <div class="card">
                  <div class="card-header border-0 align-items-center d-flex pb-0">
                      <h4 class="card-title mb-0 flex-grow-1">Sales Statistics</h4>
                      <div>
                          <div class="dropdown">
                              <a class="dropdown-toggle text-muted" href="#"
                                  data-bs-toggle="dropdown" aria-haspopup="true"
                                  aria-expanded="false">
                                  Today<i class="mdi mdi-chevron-down ms-1"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end">
                                  <a class="dropdown-item" href="#">Yearly</a>
                                  <a class="dropdown-item" href="#">Monthly</a>
                                  <a class="dropdown-item" href="#">Weekly</a>
                                  <a class="dropdown-item" href="#">Today</a>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body">
                      <h4 class="mb-0 mt-2">725,800</h4>
                      <p class="mb-0 mt-2 text-muted">
                          <span class="badge badge-soft-success mb-0">
                                <i class="ri-arrow-up-line align-middle"></i>
                      15.72 % </span> vs. previous month</p>

                      <div class="mt-3 pt-1">
                          <div class="progress progress-lg rounded-pill px-0">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                              <div class="progress-bar bg-success" role="progressbar" style="width: 26%" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>

                      <div class="table-responsive mt-3">
                          <table class="table align-middle table-centered table-nowrap mb-0">
                              <thead>
                                  <tr>
                                      <th scope="col">Order Status</th>
                                      <th scope="col">Orders</th>
                                      <th scope="col">Returns</th>
                                      <th scope="col">Earnings</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>
                                          <a href="javascript:void(0);" class="text-dark">Product Pending</a>
                                      </td>
                                      <td>17,351</td>
                                      <td>2,123</td>
                                      <td><span class="badge bg-subtle-primary text-primary font-size-11 ms-1"><i class="mdi mdi-arrow-up"></i> 45.3%</span></td>
                                  </tr><!-- end -->

                                  <tr>
                                      <td>
                                          <a href="javascript:void(0);" class="text-dark">Product Cancelled</a>
                                      </td>
                                      <td>67,356</td>
                                      <td>3,652</td>
                                      <td><span class="badge bg-subtle-danger text-danger font-size-11 ms-1"><i class="mdi mdi-arrow-down"></i> 14.6%</span></td>
                                  </tr><!-- end -->


                                  <tr>
                                      <td>
                                          <a href="javascript:void(0);" class="text-dark">Product Delivered</a>
                                      </td>
                                      <td>67,356</td>
                                      <td>3,652</td>
                                      <td><span class="badge bg-subtle-primary text-primary font-size-11 ms-1"><i class="mdi mdi-arrow-up"></i> 14.6%</span></td>
                                  </tr><!-- end -->
                              </tbody><!-- end tbody -->
                          </table><!-- end table -->
                      </div>

                      <div class="text-center mt-4"><a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ms-1"></i></a></div>

                  </div>
              </div>
          </div>

          
      </div>
  </div>

  <div class="col-xl-5">
      <div class="card">
          <div class="card-header border-0 align-items-center d-flex pb-0">
              <h4 class="card-title mb-0 flex-grow-1">Top Users</h4>
              <div>
                  <div class="dropdown">
                      <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false">
                          <span class="fw-semibold">Sort By:</span>
                          <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end">
                          <a class="dropdown-item" href="#">Yearly</a>
                          <a class="dropdown-item" href="#">Monthly</a>
                          <a class="dropdown-item" href="#">Weekly</a>
                          <a class="dropdown-item" href="#">Today</a>
                      </div>
                  </div>
              </div>
          </div>
          <div class="card-body pt-2">
              <div class="table-responsive" data-simplebar style="max-height: 358px;">
                  <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                      <tbody>
                          <tr>
                              <td style="width: 20px;"><img src="{{ asset('admin/') }}/images/users/avatar-4.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Glenn Holden</h6>
                                  <p class="text-muted mb-0 font-size-14">glennholden@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-up text-success font-size-18 align-middle me-1"></i>$250.00</td>
                              <td><span class="badge badge-soft-danger font-size-12">Cancel</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><img src="{{ asset('admin/') }}/images/users/avatar-5.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Lolita Hamill</h6>
                                  <p class="text-muted mb-0 font-size-14">lolitahamill@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-down text-danger font-size-18 align-middle me-1"></i>$110.00</td>
                              <td><span class="badge badge-soft-success font-size-12">Success</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><img src="{{ asset('admin/') }}/images/users/avatar-6.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Robert Mercer</h6>
                                  <p class="text-muted mb-0 font-size-14">robertmercer@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-up text-success font-size-18 align-middle me-1"></i>$420.00</td>
                              <td><span class="badge badge-soft-info font-size-12">Active</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><img src="{{ asset('admin/') }}/images/users/avatar-7.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Marie Kim</h6>
                                  <p class="text-muted mb-0 font-size-14">mariekim@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-down text-danger font-size-18 align-middle me-1"></i>$120.00</td>
                              <td><span class="badge badge-soft-warning font-size-12">Pending</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><img src="{{ asset('admin/') }}/images/users/avatar-8.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Sonya Henshaw</h6>
                                  <p class="text-muted mb-0 font-size-14">sonyahenshaw@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-up text-success font-size-18 align-middle me-1"></i>$112.00</td>
                              <td><span class="badge badge-soft-info font-size-12">Active</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><img src="{{ asset('admin/') }}/images/users/avatar-2.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Marie Kim</h6>
                                  <p class="text-muted mb-0 font-size-14">marikim@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-down text-danger font-size-18 align-middle me-1"></i>$120.00</td>
                              <td><span class="badge badge-soft-success font-size-12">Success</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td><img src="{{ asset('admin/') }}/images/users/avatar-1.jpg" class="avatar-sm rounded-circle " alt="..."></td>
                              <td>
                                  <h6 class="font-size-15 mb-1">Sonya Henshaw</h6>
                                  <p class="text-muted mb-0 font-size-14">sonyahenshaw@tocly.com</p>
                              </td>
                              <td class="text-muted"><i class="mdi mdi-trending-up text-success font-size-18 align-middle me-1"></i>$112.00</td>
                              <td><span class="badge badge-soft-danger font-size-12">Cancel</span></td>
                              <td>
                                  <div class="dropdown">
                                      <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                          <i class="mdi mdi-dots-vertical"></i>
                                      </a>

                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div> <!-- enbd table-responsive-->
          </div>
      </div>
  </div>
</div>
<!-- END ROW -->
    <!-- apexcharts -->
    <script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Vector map-->
    <script src="{{ asset('admin/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('admin/js/pages/dashboard.init.js') }}"></script>
    
</x-layout>