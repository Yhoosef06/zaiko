
<nav class="main-header navbar navbar-expand navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                    class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                @if(count((array) session('cart')) == 0 )
                    <i class="bi bi-cart"></i>
                @else
                    <i class="bi bi-cart-fill"></i>
                @endif
                <span class="badge badge-warning navbar-badge">{{ count((array) session('cart')) }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ count((array) session('cart'))}} Items in cart</span> 

                @if(session('cart'))
                    @foreach(session('cart') as $serial_number => $item)
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
                <a href="{{ route('student.cart.list') }}" class="dropdown-item dropdown-footer">See All Items In Cart</a>

                {{-- <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a> --}}
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('signin.page') }}" role="button">
                <strong>Logout</strong>
            </a>
        </li>
        <li class="nav-item">


        </li>
    </ul>
</nav>
