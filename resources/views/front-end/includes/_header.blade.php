<!-- navbar-->
<header class="header bg-white">
    <div class="container px-0 px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand"
                                                                          href="{{ route('frontend.index') }}"><span
                        class="font-weight-bold text-uppercase text-dark">Boutique</span></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link active" href="{{ route('frontend.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link" href="{{ route('frontend.shop') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link" href="{{ route('frontend.details') }}">Product detail</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#"
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">Pages</a>
                        <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown"><a
                                    class="dropdown-item border-0 transition-link" href="{{ route('frontend.index') }}">Homepage</a><a
                                    class="dropdown-item border-0 transition-link" href="{{ route('frontend.shop') }}">Category</a><a
                                    class="dropdown-item border-0 transition-link"
                                    href="{{ route('frontend.details') }}">Product
                                                                           detail</a><a
                                    class="dropdown-item border-0 transition-link" href="{{ route('frontend.cart') }}">Shopping
                                                                                                                       cart</a><a
                                    class="dropdown-item border-0 transition-link"
                                    href="{{ route('frontend.checkout') }}">Checkout</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item dropdown">
                            <a class="btn btn-primary rounded-pill text-white" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt fa-fw mx-1"></i> Login
                            </a>
                            <a class="btn btn-outline-secondary rounded-pill" href="{{ route('register') }}">
                                <i class="fas fa-sign-in-alt fa-fw mx-1"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.cart') }}">
                                <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>Cart
                                <small class="text-gray">(2)</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <i class="far fa-heart mr-1"></i>
                                <small class="text-gray"> (0)</small>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                               data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false"><i
                                        class="fas fa-user-alt mr-1 text-gray"></i>{{ Auth::user()->full_name }}</a>
                            <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
                                <a class="dropdown-item border-0 transition-link"
                                   href="{{ route('frontend.index') }}">Profile</a>
                                <a class="dropdown-item border-0 transition-link"
                                   href="{{ route('backend.index') }}">Admin</a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item border-0 transition-link"
                                   href="#"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</header>