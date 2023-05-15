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
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/scs.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info"> --}}
        {{-- @auth
                    <a href="#" class="d-block">{{Auth::user()->first_name}}  {{Auth::user()->last_name}}</a>
                @endauth --}}
        {{-- </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                @if (Auth::user()->account_type == 'student')
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}" class="nav-link">
                            <i class="fas fa-circle nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- <a href="./index3.html" class="nav-link">
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>Borrow Item</p>
                                </a> --}}
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-circle"></i>
                            <p>
                                Borrowing Manager
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('student.items') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Items List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('cart.list') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cart</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('borrow_list') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Borrowing List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::user()->account_type == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('add_item') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    Add New Item
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_items') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View All Items</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('generate_report') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate Report</p>
                                </a>
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
                        <ul class="nav nav-treeview ml-4">
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('pending') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('borrowed') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Borrowed Items</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('returned') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Returned Items</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-circle nav-icon"></i>
                            <p>
                                Controls
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="/colleges" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Colleges</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/departments" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Departments</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('view_rooms') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rooms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_item_categories') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Item Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_brands') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Brands</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- <li class="nav-item">
                            <a href="/qr-reader" class="nav-link">
                                <i class="bi bi-qr-code-scan nav-icon"></i>
                                <p>QR Code Scanner</p>
                            </a>
                        </li> --}}
                @elseif (Auth::user()->account_type == 'reads')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('add_item') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    Add New Item
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_items') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View All Items</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('generate_report') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate Report</p>
                                </a>
                            </li>
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('pending') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('borrowed') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Borrowed Items</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('returned') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Returned Items</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif (Auth::user()->account_type == 'faculty')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('add_item') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    Add New Item
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_items') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View All Items</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('generate_report') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate Report</p>
                                </a>
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
                        <ul class="nav nav-treeview ml-4">
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
                        <ul class="nav nav-treeview ml-4">
                            <li class="nav-item">
                                <a href="{{ route('pending') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pending</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('borrowed') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Borrowed Items</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('returned') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Returned Items</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>

<script src="plugins/jquery/jquery.min.js"></script>
{{-- <!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
{{-- <!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>  --}}

<script>
    $(function() {
        // Get the current page's URL
        var url = window.location.href;

        // Loop through each navigation link
        $('a.nav-link').each(function() {
            // Check if the link's href matches the current URL
            if ($(this).attr('href') == url) {
                // Add the 'active' class to the link
                $(this).addClass('active');

                // Keep the parent 'ul' element open
                $(this).parents('.nav-item').addClass('menu-open');

                // Check if the link is a child of the Borrowing dropdown
                // if ($(this).parents('.nav-treeview').length > 0) {
                //     // Add the 'active' class to the Borrowing dropdown
                //     $('.nav-item > a.nav-link').filter(function() {
                //         return $(this).text().trim() == 'Borrowing';
                //     }).addClass('active');
                // }
            }
        });

        // Show/hide dropdown on click
        $('a.nav-link.dropdown-toggle').click(function() {
            $(this).next('.nav-treeview').toggleClass('show');
        });
    });

    $(function() {
        // Add active class to clicked link
        $('a#dashboard-link').click(function() {
            // Remove active class from all navigation links
            $('a.nav-link').removeClass('active');

            // Add active class to clicked link
            $(this).addClass('active');
        });
    });
</script>
