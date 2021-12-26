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
                        <livewire:frontend.carts />

                        <livewire:frontend.header.notification-component />
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                               data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fas fa-user-alt text-gray"></i>
                                <span class="ml-2">
                                    {{ Auth::user()->full_name }}
                                </span>
                            </a>
                            <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
                                <a class="dropdown-item border-0 transition-link"
                                   href="{{ route('frontend.dashboard') }}">Profile</a>
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