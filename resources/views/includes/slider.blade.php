<!-- Carousel Start -->
<div class="header-carousel owl-carousel">
    @for ($i = 0; $i < 5; $i++)
    <div class="header-carousel-item">
        <img src="{{asset('assets/img/carousel-1.jpg')}}" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="container align-items-center py-4">
                <div class="row g-5 align-items-center">
                    <div class="col-xl-7 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                        <div class="text-start">
                            <h4 class="text-primary text-uppercase fw-bold mb-4">Welcome To WaterLand</h4>
                            <h1 class="display-4 text-uppercase text-white mb-4">The Biggest Theme & Amusement Park</h1>
                            <p class="mb-4 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy... 
                            </p>
                            <div class="d-flex flex-shrink-0">
                                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Our Packages</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                        {{-- <div class="ticket-form p-5">
                            <h2 class="text-dark text-uppercase mb-4">book your ticket</h2>
                            <form>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <input type="text" class="form-control border-0 py-2" id="name" placeholder="Your Name">
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <input type="email" class="form-control border-0 py-2" id="email" placeholder="Your Email">
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <input type="phone" class="form-control border-0 py-2" id="phone" placeholder="Phone">
                                    </div>
                                    <div class="col-12">
                                        <select class="form-select border-0 py-2" aria-label="Default select example">
                                            <option selected>Select Packages</option>
                                            <option value="1">Family Packages</option>
                                            <option value="2">Basic Packages</option>
                                            <option value="3">Premium Packages</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control border-0 py-2" type="date">
                                    </div>
                                    <div class="col-12">
                                        <input type="number" class="form-control border-0 py-2" id="number" placeholder="Guest">
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary w-100 py-2 px-5">Book Now</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @endfor
</div>
<!-- Carousel End -->