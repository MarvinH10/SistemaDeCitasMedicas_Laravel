@include('includes.panel.headweb')
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="card-header askhead" style="color: white">
                    Deja tu comentario sobre que te parecio de nuestra atención
                    <div class="card-body">
                        <form method="POST" action="{{ route('testimonials.store') }}">
                            @csrf
                            <div class="form-group m-3">
                                @if (auth()->check())
                                    <!-- Si el usuario está autenticado, no mostramos el campo de nombre -->
                                    <input type="hidden" id="name" name="name" value="{{ auth()->user()->name }}">
                                @else
                                    <!-- Si el usuario no está autenticado, mostramos el campo de nombre -->
                                    <label for="name">Nombres:</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                @endif
                            </div>

                            <div class="form-group m-3">
                                <label for="testimonial">Testimonio:</label>
                                <textarea id="testimonial" name="testimonial" class="form-control" required></textarea>
                            </div>

                            <div class="form-group m-3">
                                <label for="rating">Calificación:</label>
                                <div class="rating">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5" title="5 estrellas"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4" title="4 estrellas"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3" title="3 estrellas"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2" title="2 estrellas"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1" title="1 estrella"><i class="fas fa-star"></i></label>
                                </div>
                            </div>
                            <button type="submit" style="background-color: #1D2A4D" class="btn btn-dark m-3">Guardar Testimonio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('includes.panel.footweb')
