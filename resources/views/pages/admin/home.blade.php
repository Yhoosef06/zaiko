<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zaiko.</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @auth
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <h1>Zaiko.</h1>
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                    {{-- <li class="nav-item">
                        <form action="#" method="GET">
                            <input type="text" name="search" required />
                            <button type="submit">Search</button>
                        </form>
                    </li> --}}
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <span class="float-right text-muted text-sm">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                                <span class="float-right text-muted text-sm">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signin') }}" role="button">
                            <strong>Logout</strong>
                        </a>
                    </li>
                    <li class="nav-item">


                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <span class="brand-text text-center font-weight-light">
                        <H1>Zaiko.</H1>
                    </span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            @auth
                                <a href="#" class="d-block">{{ auth()->user()->first_name }}
                                    {{ auth()->user()->last_name }}</a>
                            @endauth
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                                   with font-awesome or any other icon font library -->
                            <li class="nav-item menu-open">
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-circle nav-icon"></i>
                                            <p>Dashboard</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Inventory
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('add_item') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add New Item</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('view_items') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View All Items</p>
                                                </a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Manage Borrowings
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="far fa-dot-circle nav-icon"></i>
                                                            <p>Option 1</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="far fa-dot-circle nav-icon"></i>
                                                            <p>Option 2</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="far fa-dot-circle nav-icon"></i>
                                                            <p>Option 3</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li> --}}
                                            <li class="nav-item">
                                                <a href="{{ route('generate_report') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Generate Report</p>
                                                </a>
                                                {{-- <li class="nav-item">
                                                    <a href="#" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Download LIAMS</p>
                                                    </a>
                                                </li> --}}
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-circle"></i>
                                            <p>
                                                Manage Users
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('add_user') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Add New User</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('view_users') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>View All Users</p>
                                                </a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Users
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="far fa-dot-circle nav-icon"></i>
                                                            <p>Option 1</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="far fa-dot-circle nav-icon"></i>
                                                            <p>Option 2</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i class="far fa-dot-circle nav-icon"></i>
                                                            <p>Option 3</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li> --}}
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-circle nav-icon"></i>
                                            <p>
                                                Manage Borrowings
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Option 1</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Option 2</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Option 3</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-circle nav-icon"></i>
                                            <p>Master List</p>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper p-5">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        {{-- <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Dashboard</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard v1</li>
                                </ol>
                            </div>
                        </div> --}}
                        @yield('content')
                    </div>
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                {{-- <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section> --}}
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2022-2023 Zaiko.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
    @endauth

    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>
