@include('includes.panel.headweb')
    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Blogs</h5>
                <h1 class="display-4">Nuestras Últimas Publicaciones</h1>
            </div>
            <div class="row g-5" id="blogs-container">
                @include('web.blogs.grid.blogs')
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-primary py-3 px-5" id="load-more">Cargar Más</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var page = 2; // La página actual para cargar más blogs
            var loading = false; // Para evitar múltiples solicitudes mientras se carga

            // Función para cargar más blogs
            function loadMoreBlogs() {
                if (!loading) {
                    loading = true;
                    $.ajax({
                        url: "{{ route('bloggrid') }}",
                        type: "GET",
                        data: { page: page },
                        dataType: "html",
                        success: function (data) {
                            if (data.trim() !== "") {
                                $("#blogs-container").append(data);
                                page++;
                            } else {
                                $("#load-more").hide(); // Ocultar el botón si no hay más blogs
                            }
                            loading = false;
                        },
                        error: function () {
                            loading = false;
                        }
                    });
                }
            }

            // Escucha el clic en el botón "Cargar Más"
            $("#load-more").click(function () {
                loadMoreBlogs();
            });

            // Ocultar el botón inicialmente si $blogs está vacío
            if ({{ $blogs->isEmpty() ? 'true' : 'false' }}) {
                $("#load-more").hide();
            }
        });
    </script>
    <!-- Blog End -->
@include('includes.panel.footweb')
