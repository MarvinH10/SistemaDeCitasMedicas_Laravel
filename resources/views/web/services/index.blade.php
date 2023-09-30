@include('includes.panel.headweb')
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <!-- Services Start -->
                <div class="container-fluid py-5">
                    <div class="container">
                        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Servicios</h5>
                            <h1 class="display-4">Excelentes Servicios Ginecológicos y Obstétricos</h1>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-4 col-md-6">
                                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="service-icon mb-4">
                                        <i class="fas fa-2x fa-user-nurse text-white"></i>
                                    </div>
                                    <h4 class="mb-3">Atención de Emergencia</h4>
                                    <p class="m-0">Ofrecemos atención médica de emergencia para abordar cualquier situación crítica relacionada con la salud ginecológica y obstétrica.</p>
                                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="service-icon mb-4">
                                        <i class="fa fa-2x fa-procedures text-white"></i>
                                    </div>
                                    <h4 class="mb-3">Cirugías y Procedimientos Ginecológicos</h4>
                                    <p class="m-0">Realizamos cirugías y procedimientos especializados en ginecología y obstetricia con experticia y cuidado excepcionales.</p>
                                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="service-icon mb-4">
                                        <i class="fa fa-2x fa-pills text-white"></i>
                                    </div>
                                    <h4 class="mb-3">Medicamentos y Farmacia Especializada</h4>
                                    <p class="m-0">Ofrecemos una gama completa de medicamentos y servicios farmacéuticos para satisfacer tus necesidades específicas de salud ginecológica y obstétrica.</p>
                                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="service-icon mb-4">
                                        <i class="fa fa-2x fa-baby text-white"></i>
                                    </div>
                                    <h4 class="mb-3">Control Prenatal al Aire Libre</h4>
                                    <p class="m-0">Proporcionamos un entorno cómodo y seguro para las revisiones de control prenatal al aire libre, asegurando tu bienestar y el del bebé.</p>
                                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="service-icon mb-4">
                                        <i class="fa fa-2x fa-stethoscope text-white"></i>
                                    </div>
                                    <h4 class="mb-3">Servicio Ginecológica y Obstétrica</h4>
                                    <p class="m-0">Disponemos de servicios especializado para garantizar la atención oportuna en situaciones de emergencia relacionadas con la salud de las mujeres.</p>
                                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="service-icon mb-4">
                                        <i class="fa fa-2x fa-microscope text-white"></i>
                                    </div>
                                    <h4 class="mb-3">Pruebas de Sangre Especializadas</h4>
                                    <p class="m-0">Realizamos pruebas de sangre especializadas y precisas para el diagnóstico y seguimiento de condiciones ginecológicas y obstétricas.</p>
                                    <a class="btn btn-lg btn-primary rounded-pill" href="">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Services End -->

                <!-- Testimonial Start -->
                <div class="container-fluid py-5">
                    <div class="container">
                        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Testimonial</h5>
                            <h1 class="display-4">Los Pacientes Hablan Acerca de Nuestros Servicios</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="owl-carousel testimonial-carousel">
                                    @foreach($testimonials as $testimonial)
                                        @if ($testimonial->rating >= 3) <!-- Mostrar solo los testimonios con 3 estrellas o más -->
                                            <div class="testimonial-item text-center">
                                                <div class="position-relative mb-5">
                                                    @if(isset($testimonial->user) && $testimonial->user->image)
                                                        <!-- Si el testimonio tiene un usuario con imagen, muestra la imagen del usuario -->
                                                        <img class="img-fluid rounded-circle mx-auto" src="{{ asset($testimonial->user->image) }}" alt="{{ $testimonial->user->name }}">
                                                    @else
                                                        <!-- Si el testimonio no tiene un usuario con imagen, muestra la imagen predeterminada -->
                                                        <img class="img-fluid rounded-circle mx-auto" src="{{ asset('ruta_a_la_imagen_predeterminada.jpg') }}" alt="Imagen predeterminada">
                                                    @endif
                                                    <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white rounded-circle" style="width: 60px; height: 60px;">
                                                        <i class="fa fa-quote-left fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                                <p class="fs-4 fw-normal">{{ $testimonial->testimonial }}</p>
                                                <hr class="w-25 mx-auto">
                                                @if ($testimonial->user)
                                                    <h3>{{ $testimonial->user->name }}</h3>
                                                    <h6 class="fw-normal text-primary mb-3">{{ $testimonial->user->role }}</h6>
                                                @else
                                                    <p>{{ $testimonial->name }}</p>
                                                    <h6 class="fw-normal text-primary mb-3">Usuario desconocido</h6>
                                                @endif
                                                <!-- Mostrar las estrellas en lugar de la puntuación -->
                                                <div class="stars">
                                                    @php
                                                    $maxStars = 5; // Número máximo de estrellas
                                                    $rating = $testimonial->rating; // Puntuación del testimonio
                                                    @endphp

                                                    @for ($i = 1; $i <= $maxStars; $i++)
                                                        @if ($i <= $rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Testimonial End -->
            </div>
        </div>
    </div>
@include('includes.panel.footweb')
