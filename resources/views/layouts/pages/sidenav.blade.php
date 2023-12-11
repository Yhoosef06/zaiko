<!-- Main Sidebar Container -->
<style>
    .sidebar,
    .brand-link {
        background-color: rgb(29, 44, 29);
    }
</style>
<aside class="main-sidebar sidebar-dark-olive elevation-4" style="background-color: rgb(29, 44, 29)">
    <!-- Brand Logo -->
    <a @if (Auth::user()->password_updated == false ||
            Auth::user()->security_question_id == null ||
            Auth::user()->isAgreed == false) href="#"
    @elseif (Auth::user()->role == 'borrower')
        href="{{ route('browse.items') }}"
    @else
    href="{{ route('admin.dashboard') }}" @endif
        class="brand-link">
        <span class="brand-text text-center font-weight-light">
            <H1>Zaiko.</H1>

        </span>
    </a>
    @if (Auth::user()->roles->contains('name', 'manager'))
        @if (Auth::user()->hasPermission('manage-borrowings'))
            <select class="form-control select2" id="select-department" name="department">
                @foreach ($userDepartments as $userDepartment)
                    <option value="{{ $userDepartment->departmentID }}"
                        {{ Session::get('departmentID') == $userDepartment->departmentID ? 'selected' : '' }}>
                        {{ $userDepartment->department_name }}
                    </option>
                @endforeach
            </select>
        @endif
    @endif

    <!-- Sidebar -->
    @if (Auth::user()->password_updated == true && Auth::user()->security_question_id != null)
        <div class="sidebar sidebar-dark-olive" style="height: calc(100vh - 100px); overflow: auto;">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @if (Auth::user()->roles->contains('name', 'manager') || Auth::user()->roles->contains('name', 'borrower'))
                        <li class="nav-item">
                            <a @if (Auth::user()->roles->contains('name', 'manager')) href="{{ route('admin.dashboard') }}" 
                        @else
                            href="{{ route('borrower.dashboard') }}" @endif
                                class="nav-link">
                                <i class="bi bi-clipboard-heart-fill nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if (Auth::user()->roles->contains('name', 'borrower'))
                            @if (Auth::user()->isAgreed == true)
                                @if (Session::has('department') && Session::has('category'))
                                    <li class="nav-item">
                                        <a href="{{ route('browse.category', ['_token' => csrf_token(), 'category' => Session::get('category')]) }}"
                                            class="nav-link">
                                            <i class="bi bi-search nav-icon"></i>
                                            <p>Browse Items</p>
                                        </a>
                                    </li>
                                @elseif(Session::has('department'))
                                    <li class="nav-item">
                                        <a href="{{ route('browse.department', ['_token' => csrf_token(), 'selectedDepartment' => Session::get('department')]) }}"
                                            class="nav-link">
                                            <i class="bi bi-search nav-icon"></i>
                                            <p>Browse Items</p>
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('browse.items') }}" class="nav-link">
                                            <i class="bi bi-search nav-icon"></i>
                                            <p>Browse Items</p>
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a href="{{ route('browse.cart') }}" class="nav-link">
                                        <i class="bi bi-basket3 nav-icon"></i>
                                        <p>For Borrowing</p>
                                        @if ($cartcount != 0)
                                            <span class="badge badge-danger right">{{ $cartcount }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('pending-order') }}" class="nav-link">
                                        <i class="bi bi-bag-check nav-icon"></i>
                                        <p>For Approval</p>
                                        @if ($pendingcount != 0)
                                            <span class="badge badge-danger right">{{ $pendingcount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('borrowed-items') }}" class="nav-link">
                                        <i class="bi bi-list-check nav-icon"></i>
                                        <p>Borrowed Items</p>
                                        @if ($borrowedcount != 0)
                                            <span class="badge badge-danger right">{{ $borrowedcount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('history') }}" class="nav-link">
                                        <i class="bi bi-alarm nav-icon"></i>
                                        <p>Transaction History</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (Auth::user()->roles->contains('name', 'manager'))
                            @if (Auth::user()->hasPermission('manage-borrowings'))
                                @if (Session::has('department') && Session::has('category'))
                                    <li class="nav-item">
                                        <a href="{{ route('browse.category', ['_token' => csrf_token(), 'category' => Session::get('category')]) }}"
                                            class="nav-link">
                                            <i class="bi bi-search nav-icon"></i>
                                            <p>Browse Items</p>
                                        </a>
                                    </li>
                                @elseif(Session::has('department'))
                                    <li class="nav-item">
                                        <a href="{{ route('browse.department', ['_token' => csrf_token(), 'selectedDepartment' => Session::get('department')]) }}"
                                            class="nav-link">
                                            <i class="bi bi-search nav-icon"></i>
                                            <p>Browse Items</p>
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('browse.items') }}" class="nav-link">
                                            <i class="bi bi-search nav-icon"></i>
                                            <p>Browse Items</p>
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a href="{{ route('browse.cart') }}" class="nav-link">
                                        <i class="bi bi-basket3 nav-icon"></i>
                                        <p>For Borrowing</p>
                                        @if ($cartcount != 0)
                                            <span class="badge badge-danger right">{{ $cartcount }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('pending-order') }}" class="nav-link">
                                        <i class="bi bi-bag-check nav-icon"></i>
                                        <p>For Approval</p>
                                        @if ($pendingcount != 0)
                                            <span class="badge badge-danger right">{{ $pendingcount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('borrowed-items') }}" class="nav-link">
                                        <i class="bi bi-list-check nav-icon"></i>
                                        <p>Borrowed Items</p>
                                        @if ($borrowedcount != 0)
                                            <span class="badge badge-danger right">{{ $borrowedcount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('history') }}" class="nav-link">
                                        <i class="bi bi-alarm nav-icon"></i>
                                        <p>Transaction History</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-hand-holding nav-icon"></i>
                                        <p>
                                            Manage Borrowings
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('pending') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-spinner nav-icon"></i>
                                                    <p>Pending</p>
                                                    {{-- @if (session()->has('pending_count'))
                                                        <span class="badge badge-danger right">{{ session('pending_count') }}</span>
                                                    @endif --}}

                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('borrowed') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-arrow-circle-right nav-icon"></i>
                                                    <p>Released Items</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('overdue') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-hourglass-half nav-icon"></i>
                                                    <p>Overdue</p>
                                                    {{-- @if (session()->has('overdue_count'))
                                                    <span class="badge badge-danger right">{{ session('overdue_count') }}</span>
                                                     @endif
                                                    --}}
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('returned') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-arrow-circle-left nav-icon"></i>
                                                    <p>Returned</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endif
                    @if (Auth::user()->roles->contains('name', 'admin') || Auth::user()->roles->contains('name', 'manager'))
                        @if (Auth::user()->roles->contains('name', 'admin'))
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                    <i class="fa fa-digital-tachograph nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                        @endif
                        {{-- INVENTORY --}}
                        @if (Auth::user()->hasPermission('manage-inventory'))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-box-open"></i>
                                    <p>
                                        Inventory
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (Auth::user()->hasPermission('add-items'))
                                        <li class="nav-item">
                                            <a href="{{ route('add_item') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-plus-square nav-icon"></i>
                                                    Add New Item
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->hasPermission('view-items'))
                                        <li class="nav-item">
                                            <a href="{{ route('view_items') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-list nav-icon"></i>
                                                    <p>View All Items</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->hasPermission('generate-report'))
                                        <li class="nav-item">
                                            <a href="{{ route('generate_report') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-file nav-icon"></i>
                                                    <p>Generate Report</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        {{-- MANAGE USERS --}}
                        @if (Auth::user()->hasPermission('manage-users'))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p>
                                        Manage Users
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (Auth::user()->hasPermission('add-users'))
                                        <li class="nav-item">
                                            <a href="{{ route('add_user') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-user-plus nav-icon"></i>
                                                    <p>Add New User</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->hasPermission('view-users'))
                                        <li class="nav-item">
                                            <a href="{{ route('view_users') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="far fa-address-book nav-icon"></i>
                                                    <p>View All Users</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif

                                    @if (Auth::user()->hasPermission('upload-csv-file'))
                                        <li class="nav-item">
                                            <a href="{{ route('upload_csv_file') }}" class="nav-link">
                                                <div class="ml-3">
                                                    <i class="fa fa-file-import nav-icon"></i>
                                                    <p>Upload a CSV File</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->hasPermission('manage-settings'))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-wrench nav-icon"></i>
                                    <p>
                                        Settings
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('view_terms') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="far fa-calendar nav-icon"></i>
                                                <p>Term</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_colleges') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-graduation-cap nav-icon"></i>
                                                <p>Colleges</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_departments') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-table nav-icon"></i>
                                                <p>Departments</p>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('view_rooms') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-door-open nav-icon"></i>
                                                <p>Rooms</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_item_categories') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-layer-group nav-icon"></i>
                                                <p>Item Categories</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_brands') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-certificate nav-icon"></i>
                                                <p>Brands</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_models') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-code-branch nav-icon"></i>
                                                <p>Models</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('agreement_index') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-scroll nav-icon"></i>
                                                <p>Agreement Form</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('view_roles') }}" class="nav-link">
                                            <div class="ml-3">
                                                <i class="fa fa-clipboard-check nav-icon"></i>
                                                <p>Roles & Permissions</p>
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
