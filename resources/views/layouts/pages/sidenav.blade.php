<!-- Main Sidebar Container -->
<style>
    .sidebar,
    .brand-link {
        background-color: rgb(29, 44, 29);
    }
</style>
<aside class="main-sidebar sidebar-dark-olive elevation-4" style="background-color: rgb(29, 44, 29)">
    <!-- Brand Logo -->
    <a @if (Auth::user()->password_updated == false || Auth::user()->security_question_id == null) href="#"
    @elseif (Auth::user()->role == 'borrower')
        href="{{ route('borrower.dashboard') }}"
    @else
    href="{{ route('admin.dashboard') }}" @endif
        class="brand-link">
        <span class="brand-text text-center font-weight-light">
            <H1>Zaiko.</H1>
        </span>
    </a>

    <!-- Sidebar -->
    @if (Auth::user()->password_updated == true && Auth::user()->security_question_id != null)
        <div class="sidebar sidebar-dark-olive" style="height: calc(100vh - 100px); overflow: auto;">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                    @if (Auth::user()->roles->contains('name', 'borrower'))
                        <li class="nav-item">
                            <a href="{{ route('borrower.dashboard') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('borrower.items') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Browse Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cart.list') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Cart</p>
                                @if ($cartcount != 0)
                                    <span class="badge badge-danger right">{{ $cartcount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pending-order') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Pending</p>
                                @if ($pendingcount != 0)
                                    <span class="badge badge-danger right">{{ $pendingcount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('borrowed-items') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Borrowed Items</p>
                                @if ($borrowedcount != 0)
                                    <span class="badge badge-danger right">{{ $borrowedcount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('history') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>History</p>
                                @if ($historycount != 0)
                                    <span class="badge badge-danger right">{{ $historycount }}</span>
                                @endif
                            </a>
                        </li>
                    @elseif(Auth::user()->roles->contains('name', 'admin') || Auth::user()->roles->contains('name', 'manager'))
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
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('add_item') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            Add New Item
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('view_items') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View All Items</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('generate_report') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Generate Report</p>
                                        </div>
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
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('add_user') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Add New User</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('view_users') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>View All Users</p>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('upload_csv_file') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Upload a CSV File</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->roles->contains('name', 'manager'))
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
                                    <a href="{{ route('pending') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pending</p>
                                            {{-- @if ($itemcount != 0)
                                                <span class="badge badge-warning right">{{ $itemcount }}</span>
                                            @endif --}}
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('borrowed') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Borrowed</p>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('overdue') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Overdue</p>
                                            {{-- @if ($itemcount != 0)
                                                <span class="badge badge-danger right">{{ $itemcount }}</span>
                                            @endif --}}
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('returned') }}" class="nav-link">
                                        <div class="ml-3">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Returned</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->roles->contains('name', 'admin'))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>
                                        Settings
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('view_terms') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Term</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_colleges') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Colleges</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_departments') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Departments</p>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('view_rooms') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Rooms</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_item_categories') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Item Categories</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_brands') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Brands</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_models') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Models</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_roles') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Roles</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_permissions') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Permissions</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                        @endif

                    @endif
                </ul>
            </nav>
        </div>
    @endif
</aside>

<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
{{-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
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
