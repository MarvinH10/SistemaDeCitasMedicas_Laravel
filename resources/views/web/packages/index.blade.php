@include('includes.panel.headweb')
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <!-- Packages Start -->
                <div class="container-fluid py-5">
                    <div class="container">
                        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Paquetes</h5>
                            <h1 class="display-4">Ofertas Especiales</h1>
                        </div>
                        <div class="owl-carousel price-carousel position-relative" style="padding: 0 45px 45px 45px;">
                            @foreach($promotions as $promotion)
                                <div class="bg-light rounded text-center">
                                    <div class="position-relative">
                                        <img class="img-fluid rounded-top" src="{{ $promotion->image }}" alt="">
                                        <div class="position-absolute w-100 h-100 top-50 start-50 translate-middle rounded-top d-flex flex-column align-items-center justify-content-center" style="background: rgba(29, 42, 77, .8);">
                                            <h3 class="text-white">{{ $promotion->name }}</h3>
                                            <h1 class="display-4 text-white mb-0">
                                                <small class="align-top fw-normal" style="font-size: 22px; line-height: 45px;">$</small>{{ $promotion->price }}<small class="align-bottom fw-normal" style="font-size: 16px; line-height: 40px;"></small>
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="text-center py-5">
                                        <p>
                                            @foreach(explode("\n", $promotion->description) as $point)
                                                <li>{{ $point }}</li>
                                            @endforeach
                                        </p>
                                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill py-3 px-5 my-2">Agendar cita ya!</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Packages End -->
            </div>
        </div>
    </div>
@include('includes.panel.footweb')
