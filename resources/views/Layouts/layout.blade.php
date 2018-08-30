<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="shortcut icon" href="img/favicon.ico">

  <title>@yield('pageTitle') - theBroCode</title>
 
  <!-- CSS-->
  <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/custom/custom.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/custom/broCode.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

  <!--JS-->
  <script type="text/javascript"  src="{{ URL::asset('js/jquery-1.12.4.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>       
  <script type="text/javascript" src="{{ URL::asset('js/impl.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/typeahead.bundle.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/k/custom.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('canvas/canvasjs.min.js') }}"></script>


  @yield('js-libs')

  <script>
    var APP_URL = "<?php echo config('app.url'); ?>";
    var APP_PUBLIC_URL = "<?php echo config('app.url'); ?>";
  </script>

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <div class="col-md-3 left_col">
                  <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="glyphicon glyphicon-home"></i> <span>theBroCode</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="img/barney.jpg" alt="profile picture" class="img-circle profile_img" style="height: 50px;width: 50px">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>Barney Stinson</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="form.html">General Form</a></li>
                      <li><a href="form_advanced.html">Advanced Components</a></li>
                      <li><a href="form_validation.html">Form Validation</a></li>
                      <li><a href="form_wizards.html">Form Wizard</a></li>
                      <li><a href="form_upload.html">Form Upload</a></li>
                      <li><a href="form_buttons.html">Form Buttons</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="general_elements.html">General Elements</a></li>
                      <li><a href="media_gallery.html">Media Gallery</a></li>
                      <li><a href="typography.html">Typography</a></li>
                      <li><a href="icons.html">Icons</a></li>
                      <li><a href="glyphicons.html">Glyphicons</a></li>
                      <li><a href="widgets.html">Widgets</a></li>
                      <li><a href="invoice.html">Invoice</a></li>
                      <li><a href="inbox.html">Inbox</a></li>
                      <li><a href="calendar.html">Calendar</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="tables.html">Tables</a></li>
                      <li><a href="tables_dynamic.html">Table Dynamic</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="chartjs.html">Chart JS</a></li>
                      <li><a href="chartjs2.html">Chart JS2</a></li>
                      <li><a href="morisjs.html">Moris JS</a></li>
                      <li><a href="echarts.html">ECharts</a></li>
                      <li><a href="other_charts.html">Other Charts</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                      <li><a href="fixed_footer.html">Fixed Footer</a></li>
                    </ul>
                  </li>
                </ul>
              </div>         
            </div>
            <!-- /sidebar menu -->

           
            <!-- /menu footer buttons -->
          </div>

      </div>

      <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="img/barney.jpg" alt="">Barney Stinson
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

      <!-- page content -->
        <div class="right_col" role="main">
          @yield('content')         
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>


    </div>
  </div>

</body>
@yield('js-scripts')

</html>
