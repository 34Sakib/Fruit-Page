<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <i class="fas fa-phone-alt"></i> Hotline: 09613-787804 | <i class="fas fa-envelope"></i> support@fruitspage.com
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white me-3"><i class="fas fa-map-marker-alt"></i> Store Locator</a>
                @auth
                <div class="dropdown d-inline-block me-3">
                    <a href="#" class="text-white dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-white me-3"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}" class="text-white me-3"><i class="fas fa-user-plus"></i> Register</a>
                @endauth
                <a href="#" class="text-white"><i class="fas fa-shopping-cart"></i> Cart (0)</a>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-apple-alt me-2"></i>FruitsPage
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('fruits') ? 'active' : '' }}" href="{{ url('/fruits') }}">Fruits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('vegetables') ? 'active' : '' }}" href="{{ url('/vegetables') }}">Vegetables</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('organic') ? 'active' : '' }}" href="{{ url('/organic') }}">Organic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('seasonal') ? 'active' : '' }}" href="{{ url('/seasonal') }}">Seasonal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('deals') ? 'active' : '' }}" href="{{ url('/deals') }}">Deals</a>
                </li>
            </ul>
            <div class="d-flex">
                <div class="search-box me-3">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search for fruits...">
                </div>
                <div class="header-icons">
                    <a href="{{ route('login') }}"><i class="fas fa-user"></i></a>
                    <a href="#"><i class="fas fa-shopping-cart"></i></a>
                    <a href="#"><i class="fas fa-heart"></i></a>
                </div>
            </div>
        </div>
    </div>
</nav>