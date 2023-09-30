@include('includes.panel.headweb')
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <!-- Contact Start -->
                <div class="container-fluid pt-5">
                    <div class="container">
                        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                            <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Alguna Consulta?</h5>
                            <h1 class="display-4">Por favor, siéntete libre de contactarnos</h1>
                        </div>
                        <div class="row g-5 mb-5">
                            <div class="col-lg-4">
                                <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center text-center" style="height: 200px;">
                                    <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 100px; height: 70px; transform: rotate(-15deg);">
                                        <i class="fa fa-2x fa-location-arrow text-white" style="transform: rotate(15deg);"></i>
                                    </div>
                                    <h6 class="mb-0">Jirón Huallayco #454, Huánuco, Peru</h6>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center text-center" style="height: 200px;">
                                    <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 100px; height: 70px; transform: rotate(-15deg);">
                                        <i class="fab fa-2x fa-whatsapp text-white" style="transform: rotate(15deg);"></i>
                                    </div>
                                    <h6 class="mb-0">+51 961 295 024</h6>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg-light rounded d-flex flex-column align-items-center justify-content-center text-center" style="height: 200px;">
                                    <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 100px; height: 70px; transform: rotate(-15deg);">
                                        <i class="fa fa-2x fa-envelope-open text-white" style="transform: rotate(15deg);"></i>
                                    </div>
                                    <h6 class="mb-0">jesuszvi@hotmail.com</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="height: 500px;">
                                <div class="position-relative h-100">
                                    <iframe class="position-relative w-100 h-100"
                                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d982.5011046847507!2d-76.24575574049521!3d-9.933589268189307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zOcKwNTYnMDAuNSJTIDc2wrAxNCc0NC43Ilc!5e0!3m2!1ses!2spe!4v1694632136988!5m2!1ses!2spe"
                                        frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                                        tabindex="0">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center position-relative" style="margin-top: -200px; z-index: 1;">
                            <div class="col-lg-8">
                                <div class="bg-white rounded p-5 m-5 mb-0">
                                    <form action="https://wa.me/51992510315" method="GET" target="_blank">
                                        <!-- Agregar el número de teléfono en el atributo "action" y "target" -->
                                        <div class="row g-3">
                                            <h4 style="color: #bc0754 !important;"><strong>ESCRÍBRENOS UN MENSAJE</strong></h4>
                                            <div class="col-12">
                                                <textarea class="form-control bg-light border-0" name="text" rows="5" placeholder="Mensaje"></textarea>
                                                <!-- El campo "text" es importante para el mensaje de WhatsApp -->
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-dark w-100 py-3" style="background-color: #1D2A4D" type="submit">Enviar Mensaje</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact End -->
            </div>
        </div>
    </div>
@include('includes.panel.footweb')
