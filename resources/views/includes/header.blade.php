<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar sticky-top px-4 py-2 py-lg-0">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a href="{{route('home')}}" class="navbar-brand p-0">
            <h1 class="display-6 text-dark"><i class="fas fa-swimmer text-primary me-3"></i>Shipment</h1>
            {{-- <img src="{{asset('assets/img/logo.png')}}" alt="Logo"> --}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Service</a>
                <a href="blog.html" class="nav-item nav-link">Blog</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="feature.html" class="dropdown-item">Our Feature</a>
                        <a href="gallery.html" class="dropdown-item">Our Gallery</a>
                        <a href="attraction.html" class="dropdown-item">Attractions</a>
                        <a href="package.html" class="dropdown-item">Ticket Packages</a>
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <div class="team-icon d-none d-xl-flex justify-content-center me-3">
                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
            </div>
            @if (Auth::check() && Auth::user()->is_admin)
            <a href="{{route('admin.dashboard')}}" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Dashboard</a>   
            @endif

            @if (Auth::check() && !Auth::user()->is_admin)
            <a href="{{route('user.dashboard')}}" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Dashboard</a>   
            @endif

            @if (!Auth::check())
            <a href="{{route('login')}}" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Login</a>   
            @endif

           
           
        </div>
    </nav>
</div>
<!-- Navbar & Hero End -->