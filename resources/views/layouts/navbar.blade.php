<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/img/logo.png" alt="Caroline Nail Art" style="height: 30px;"><i>Caroline Nail Art</i>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active-custom' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('collection') ? 'active-custom' : '' }}" href="/collection">Collection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('shop') ? 'active-custom' : '' }}" href="/shop">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('booking') ? 'active-custom' : '' }}" href="/booking">Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('testimonials') ? 'active-custom' : '' }}" href="/testimonials">Testimoni</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/cart" class="btn position-relative me-3">
                    <i class="fa fa-shopping-cart" style="font-size: 1.2rem;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
                @auth
                    <div class="dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown">
                            <img src="/img/avatar.jpg" alt="User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile">Profil</a></li>
                            <li><form method="POST" action="{{ route('logout') }}" class="d-inline">
                     @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                            </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="/login" class="btn btn-primary-custom">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>