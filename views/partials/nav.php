    <!-- Navbar Start -->
    <div class="container-fluid p-0 nav-bar">
        <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
            <a href="index.html" class="navbar-brand px-lg-4 m-0">
                <h1 class="m-0 display-4 text-uppercase text-white">Coffee ni Wacxyy</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto p-4">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="/" class="nav-item nav-link h6">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/about" class="nav-item nav-link h6">About</a>
                </li>
                <li class="nav-item">
                    <a href="/service" class="nav-item nav-link h6">Service</a>
                </li>
                <li class="nav-item">
                    <a href="/menu" class="nav-item nav-link h6">Menu</a>
                </li>
                <?php if ($_SESSION['user'] ?? false) : ?>
                <li class="nav-item">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle h6" data-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu text-capitalize">
                            <a href="/reservation" class="dropdown-item">Reservation</a>
                            <a href="/testimonial" class="dropdown-item">Testimonial</a>
                        </div>
                    </div>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a href="/contact" class="nav-link h6">Contact</a>
                </li>
                <?php endif; ?>
                <?php if ($_SESSION['user'] ?? false) : ?>
                <li class="nav-item">
                    <form action="/sessions" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn nav-link h6">Log Out</button>
                    </form>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a href="/register" class="nav-item nav-link h6">Register</a>
                </li>
                <li class="nav-item">
                    <a href="/login" class="nav-item nav-link h6">Login</a>
                </li>
                <?php endif; ?>
                </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->