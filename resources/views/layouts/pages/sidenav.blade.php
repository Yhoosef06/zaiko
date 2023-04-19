
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
                <img src="dist/img/scs.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                {{-- @auth
                    <a href="#" class="d-block">{{Auth::user()->first_name}}  {{Auth::user()->last_name}}</a>
                @endauth --}}
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
                        @if( \Auth::user()->account_type == 'student' )
                            <li class="nav-item">
                                <a href="/student-dashboard" class="nav-link">
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
                                        Borrowing
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
                        @elseif( \Auth::user()->account_type == 'admin' )
                        <li class="nav-item">
                            <a href="{{route('admin.dashboard')}}" class="nav-link">
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
                            <a href="{{route('admin.dashboard')}}" class="nav-link">
                                <i class="bi bi-qr-code-scan nav-icon"></i>
                                <p>QR Code Scanner</p>
                            </a>
                        </li>
                                
                        @endif
                    </ul>
                </li>
</aside>
