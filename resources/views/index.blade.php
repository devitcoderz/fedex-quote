@extends('layouts.app')
@section('content')
<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="row g-5"> 
            {{-- <div class="col-12 col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                <div>
                    <div class="pb-5">
                        <h4 class="text-primary">Get in Touch</h4>
                        <p class="mb-0">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a class="text-primary fw-bold" href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="contact-add-item rounded bg-light p-4">
                                <div class="contact-icon text-primary mb-4">
                                    <i class="fas fa-map-marker-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h4>Address</h4>
                                    <p class="mb-0">123 Street New York.USA</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-add-item rounded bg-light p-4">
                                <div class="contact-icon text-primary mb-4">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                                <div>
                                    <h4>Mail Us</h4>
                                    <p class="mb-0">info@example.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-add-item rounded bg-light p-4">
                                <div class="contact-icon text-primary mb-4">
                                    <i class="fa fa-phone-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h4>Telephone</h4>
                                    <p class="mb-0">(+012) 3456 7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-add-item rounded bg-light p-4">
                                <div class="contact-icon text-primary mb-4">
                                    <i class="fab fa-firefox-browser fa-2x"></i>
                                </div>
                                <div>
                                    <h4>Yoursite@ex.com</h4>
                                    <p class="mb-0">(+012) 3456 7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-around bg-light rounded p-4">
                                <a class="btn btn-xl-square btn-primary rounded-circle" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-xl-square btn-primary rounded-circle" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-xl-square btn-primary rounded-circle" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-xl-square btn-primary rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="0.4s">
                <div class="bg-light p-5 rounded h-100">
                    <h4 class="text-primary mb-4">Quick Quote</h4>
                    <form action="{{route('home.quick-quote.get')}}" method="get">
                        
                        <div class="row g-4">
                            @if (Session::has('message'))
                            <div class="col-lg-12 col-xl-12">
                                <p class="alert alert-{{Session::get('message')['success'] ? 'success' : 'danger'}}">
                                    {{Session::get('message')['msg']}}
                                </p>
                            </div>
                            @endif
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" name="from_zip" id="from_zip" placeholder="10001">
                                    <label for="from_zip">From Zip</label>
                                    @if ($errors->has('from_zip'))
                                    <span class="text-danger">{{ $errors->first('from_zip') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" name="to_zip" id="to_zip" placeholder="10001">
                                    <label for="to_zip">To Zip</label>
                                    @if ($errors->has('to_zip'))
                                    <span class="text-danger">{{ $errors->first('to_zip') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3 col-xl-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" name="weight" id="weight" placeholder="Weight">
                                    <label for="weight">Weight</label>
                                    @if ($errors->has('weight'))
                                    <span class="text-danger">{{ $errors->first('weight') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" name="length" id="length" placeholder="Length">
                                    <label for="length">Length</label>
                                    @if ($errors->has('length'))
                                    <span class="text-danger">{{ $errors->first('length') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" name="width" id="width" placeholder="Width">
                                    <label for="width">Width</label>
                                    @if ($errors->has('width'))
                                    <span class="text-danger">{{ $errors->first('width') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" name="height" id="height" placeholder="Height">
                                    <label for="height">Height</label>
                                    @if ($errors->has('height'))
                                    <span class="text-danger">{{ $errors->first('height') }}</span>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3">GET QUOTE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- Contact End -->
@endsection