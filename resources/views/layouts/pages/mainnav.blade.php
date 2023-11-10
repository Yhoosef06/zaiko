<style>
    /* Initially hide collapse-content */
    .collapse-content {
        display: none;
    }

    /* Style for collapse-content items */
    .collapse-content a {
        display: block;
        text-decoration: none;
        background-color: rgba(255, 255, 255, 0.759);
    }

    .dropdown-menu a:hover {
        background-color: #f0f0f0;
    }

    /* Style for collapse-content items when hovered */
    .collapse-content a:hover {
        background-color: #f0f0f0;
        padding-left: 5px;
    }

    /* Show collapse-content when hovering over the parent dropdown and the "Change Department" item or collapse-content */
    .dropdown:hover .dropdown-item-change-department:hover+.collapse-content,
    .dropdown-item-change-department:hover .collapse-content,
    .collapse-content:hover {
        display: block;
    }

    .dropdown:hover .dropdown-item-change-department {
        background-color: #f0f0f0;
        /* Adjust the background color on hover */
    }

    /* Highlight the "Change Department" item when a collapse-content item is selected */
    .dropdown-item-change-department.active {
        background-color: #d3d3d3;
        /* Adjust the background color for the active state */
    }
</style>
<nav class="main-header navbar navbar-expand navbar-olive navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                @if (count((array) session('cart')) == 0)
                    <i class="bi bi-cart"></i>
                @else
                    <i class="bi bi-cart-fill"></i>
                @endif
                <span class="badge badge-warning navbar-badge">{{ count((array) session('cart')) }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ Cart::count(Auth::user()->id_number) }} Items in cart</span> 
                <span class="dropdown-item dropdown-header">{{ Cart::count() }} Items in cart</span> 

                @if (session('cart'))
                    @foreach (session('cart') as $serial_number => $item)
                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item">
                            <div class="row">
                                <div class="col-lg-4 col-sm-4 col-4">
                                    <i class="bi bi-asterisk mr-2"> {{ $item['item_name'] }} </i>
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8">
                                    <p>{{ $item['unit_number']}}</p>
                                    <span class="text-info text-wrap">{{ $item['item_description'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('cart.list') }}" class="dropdown-item dropdown-footer">See All Items In Cart</a>

                {{-- <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a> --}}
        {{-- </div>
        </li> --}}
        {{-- <li class="nav-item">
            <a href="" class="nav-link">
                <img src="dist/img/scs.png" class="img-circle" alt="User Image" width="25">
            </a>
        </li> --}}
        <li class="nav-item text-bold">
            <div class="dropdown">
                <a class="btn nav-link border-right border-1 text-lg text-bold dropdown-toggle" href="#"
                    role="button" id="userDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                </a>

                <div class="dropdown-menu" aria-labelledby="userDropdown">
                    @if (Auth::user()->password_updated == false || Auth::user()->security_question_id == null)
                        <a class="dropdown-item" href="{{ url()->current() }}">Update Password</a>
                    @else
                        <a class="dropdown-item"
                            href="{{ route('view_profile', ['id_number' => Auth::user()->id_number]) }}">View
                            Profile</a>
                    @endif
                    <a href="#" class="dropdown-item">Switch to Borrower</a>

                    <a href="#" class="dropdown-item dropdown-item-change-department">Change Department</a>
                    <!-- Content that expands/collapses -->
                    <div class="collapse-content">
                        <a href="#" class="dropdown-item">Department 1</a>
                        <a href="#" class="dropdown-item">Department 2</a>
                        <!-- Add more department options as needed -->
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <form action="/logout" method="POST">
                @csrf
                <button class="btn nav-link border-left border-1 text-lg text-bold" href="{{ route('logout') }}"
                    role="button">
                    Logout
                </button>
            </form>
        </li>
        <li class="nav-item">
        </li>
    </ul>
</nav>
{{-- <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Your existing HTML code -->

<script>
    $(document).ready(function() {
        var timeoutId;

        // Show collapse-content when hovering over "Change Department" dropdown item
        $('.dropdown-item-change-department').mouseenter(function() {
            clearTimeout(timeoutId);
            $('.collapse-content').slideDown();
        });

        // Hide collapse-content after a delay when mouse leaves "Change Department" dropdown item
        $('.dropdown-item-change-department').mouseleave(function() {
            timeoutId = setTimeout(function() {
                $('.collapse-content').slideUp();
            }, 500); // Adjust the delay time (in milliseconds) as needed
        });

        // Hide collapse-content when mouse leaves the entire dropdown
        $('.dropdown').mouseleave(function() {
            clearTimeout(timeoutId);
            $('.collapse-content').slideUp();
        });
    });
</script> --}}
