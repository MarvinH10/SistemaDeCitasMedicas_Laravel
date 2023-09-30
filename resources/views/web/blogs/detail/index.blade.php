@include('includes.panel.headweb')
    <!-- Blog Start -->
    <div class="container py-5">
        <div class="row g-5">
            @if(isset($primerBlog))
                <div class="col-lg-8">
                    <!-- Blog Detail Start -->
                    <div class="mb-5">
                        @if($primerBlog->tipo === 'imagen')
                            <img class="rounded mb-5" src="{{ asset($primerBlog->archivo) }}" alt="">
                        @elseif($primerBlog->tipo === 'video')
                            <div>
                                <video
                                    muted="true"
                                    preload="auto"
                                    loop="loop"
                                    controls
                                    class="rounded mb-5">
                                    <source src="{{ asset($primerBlog->archivo) }}" type="video/mp4">
                                    Tu navegador no admite el elemento de video.
                                </video>
                            </div>
                        @endif
                        <h1 class="mb-4">{{ $primerBlog->titulo }}</h1>
                        <p>{!! nl2br($primerBlog->descripcion) !!}</p>
                        <div class="d-flex justify-content-between bg-light rounded p-4 mt-4 mb-4">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle me-2" src="{{ asset('img/jesuscaycho.png') }}" width="40" height="40" alt="">
                                <span>Dr. Jesús Caycho</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="ms-3"><i class="far fa-eye text-primary me-1"></i>{{ $primerBlog->userViews->count() }}</span>
                                <span class="ms-3"><i class="far fa-comment text-primary me-1"></i>{{ $comments->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Blog Detail End -->

                    <!-- Comment List Start -->
                    <div class="mb-5">
                        @if($comments->count() <= 1)
                            <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 mb-4">{{ $comments->count() }} Comentario</h4>
                        @else
                            <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 mb-4">{{ $comments->count() }} Comentarios</h4>
                        @endif
                        @foreach($comments->where('parent_id', null) as $comment)
                        <div class="d-flex mb-4">
                            <img src="{{ asset('img/user.png') }}" class="img-fluid rounded-circle" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6>{{ $comment->user->name }} <small><i>{{ $comment->created_at->format('d M Y') }}</i></small></h6>
                                <p>{{ $comment->content }}</p>

                                <!-- Mostrar botón "Responder" solo si el usuario actual no es el mismo -->
                                @if(auth()->check() && auth()->user()->id !== $comment->user->id)
                                    <button class="btn btn-sm btn-light rounded" data-toggle="collapse" data-target="#replyForm{{ $comment->id }}">Responder</button>
                                @endif

                                <!-- Formulario de respuesta -->
                                <div id="replyForm{{ $comment->id }}" class="collapse mt-3">
                                    <form action="{{ route('addComment', ['id' => $primerBlog->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="form-group">
                                            <textarea name="content" class="form-control bg-white border m-3" rows="2" placeholder="Añade una respuesta" required></textarea>
                                        </div>
                                        <button style="background: #bc0754" class="btn btn-sm btn-primary mt-1 m-3" type="submit">Responder</button>
                                    </form>
                                </div>

                                <!-- Botón "Ver respuestas" si hay respuestas -->
                                @if($comment->replies->count() > 0)
                                    <button class="btn btn-sm btn-light toggle-replies rounded" data-comment-id="{{ $comment->id }}">({{ $comment->replies->count() }}) respuestas</button>
                                @endif

                                <!-- Mostrar respuestas -->
                                <div id="comment-replies-{{ $comment->id }}" style="display: none;">
                                    @foreach($comment->replies as $reply)
                                        <div class="d-flex mt-3 replies">
                                            <img src="{{ asset('img/user.png') }}" class="img-fluid rounded-circle" style="width: 45px; height: 45px;">
                                            <div class="ps-3">
                                                <h6>{{ $reply->user->name }} <small><i>{{ $reply->created_at->format('d M Y') }}</i></small></h6>
                                                <p>{{ $reply->content }}</p>
                                                @if(auth()->check() && auth()->user()->id !== $reply->user->id)
                                                    <button class="btn btn-sm btn-light" data-toggle="collapse" data-target="#replyForm{{ $comment->id }}-{{ $reply->id }}">Responder</button>
                                                @endif
                                                <!-- Formulario de respuesta -->
                                                <div id="replyForm{{ $comment->id }}-{{ $reply->id }}" class="collapse mt-3">
                                                    <form action="{{ route('addComment', ['id' => $primerBlog->id]) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                                                        <div class="form-group">
                                                            <textarea name="content" class="form-control bg-white border m-3" rows="2" placeholder="Añade una respuesta" required></textarea>
                                                        </div>
                                                        <button style="background: #bc0754" class="btn btn-sm btn-primary rounded mt-1 m-3" type="submit">Responder</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="bg-light rounded p-5">
                        <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 border-white mb-4">Deja un Comentario</h4>
                        <form action="{{ route('addComment', ['id' => $primerBlog->id]) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <textarea name="content" class="form-control bg-white border-0" rows="3" placeholder="Añade un comentario" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button style="background: #bc0754;" class="btn btn-primary w-100 py-3" type="submit">Deja tu Comentario</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                </div>

                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Category Start -->
                    <div class="mb-5">
                        <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 mb-4">Categorías</h4>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="h5 bg-light rounded py-2 px-3 mb-2" href="/services"><i class="fa fa-angle-right me-2"></i>Servicios Médicos</a>
                            <a class="h5 bg-light rounded py-2 px-3 mb-2" href="/appointments"><i class="fa fa-angle-right me-2"></i>Citas</a>
                            <a class="h5 bg-light rounded py-2 px-3 mb-2" href="/blog-grid"><i class="fa fa-angle-right me-2"></i>Blogs</a>
                            <a class="h5 bg-light rounded py-2 px-3 mb-2" href="/contacts"><i class="fa fa-angle-right me-2"></i>Contacto</a>
                            <a class="h5 bg-light rounded py-2 px-3 mb-2" href="/private-security"><i class="fa fa-angle-right me-2"></i>Privacidad y Seguridad</a>
                        </div>
                    </div>
                    <!-- Category End -->

                    <!-- Recent Post Start -->
                    <div class="mb-5">
                        <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 mb-4">Blogs Recientes</h4>

                        @foreach($recentBlogs as $recentBlog)
                        <div class="d-flex overflow-hidden mb-3 rounded">
                            @if($recentBlog->tipo === 'imagen')
                            <img class="img-fluid" src="{{ asset($recentBlog->archivo) }}" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                            @elseif($recentBlog->tipo === 'video')
                            <div class="embed-responsive">
                                <video class="embed-responsive-item img-fluid" src="{{ asset($recentBlog->archivo) }}" style="width: 100px; height: 100px; object-fit: cover;" alt=""></video>
                            </div>
                            @endif
                            <a href="{{ route('blogdetail', ['id' => $recentBlog->id]) }}" class="h6 d-flex align-items-center bg-light px-3 mb-0">{{ $recentBlog->titulo }}</a>
                        </div>
                        @endforeach
                    </div>
                    <!-- Recent Post End -->

                    <!-- Image Start -->
                    <div class="mb-5">
                        @if(isset($recentBlogs) && $recentBlogs->count() > 0)
                            @php
                                $ultimoBlog = $recentBlogs->last();
                            @endphp
                            @if($ultimoBlog->tipo === 'imagen')
                                <img src="{{ asset($ultimoBlog->archivo) }}" alt="{{ $ultimoBlog->titulo }}" class="rounded" style="height:auto;">
                            @elseif($ultimoBlog->tipo === 'video')
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video src="{{ asset($ultimoBlog->archivo) }}" alt="{{ $ultimoBlog->titulo }}" controls class="embed-responsive-item img-fluid"></video>
                                </div>
                            @endif
                        @endif
                    </div>
                    <!-- Image End -->

                    <!-- Plain Text Start -->
                    <div class="mb-5">
                        <h4 class="d-inline-block text-primary text-uppercase border-bottom border-5 mb-4">¿Sabías que?</h4>
                        <div class="bg-light rounded text-justify" style="padding: 30px;">
                            <p id="parrafoCorto">Sabías que, en el campo de la ginecología y obstetricia, uno de los avances más significativos ha sido la implementación de la ecografía 4D en la atención prenatal.</p>
                            <p id="parrafoCompleto" style="display: none;">Esta tecnología revolucionaria permite a los médicos obtener imágenes tridimensionales en tiempo real del feto en el útero materno. A diferencia de las ecografías 2D tradicionales, que ofrecen imágenes planas y estáticas, la ecografía 4D proporciona una visión más completa y detallada del desarrollo fetal.
                            <br>La ecografía 4D utiliza ondas de sonido de alta frecuencia para crear imágenes en movimiento que muestran al feto en acción. Esto ha permitido a los médicos y a los futuros padres observar cómo el bebé se mueve, sonríe y realiza diferentes gestos en el útero. Además de ser una experiencia emocionante para los padres, la ecografía 4D también desempeña un papel crucial en la detección temprana de posibles anomalías o problemas de salud en el feto.
                            <br>Esta tecnología ha mejorado significativamente la capacidad de los médicos para diagnosticar y tratar afecciones como malformaciones congénitas, problemas cardíacos y defectos en el desarrollo fetal. Además, la ecografía 4D ha brindado a los obstetras una herramienta valiosa para monitorear el crecimiento y el bienestar del feto a lo largo del embarazo, lo que ha llevado a una atención prenatal más precisa y personalizada.
                            <div style="text-align: left; margin-top: 30px;">
                                <button id="botonLeerMas" onclick="mostrarTextoCompleto()" class="btn btn-primary py-2 px-4">Leer Más</button>
                                <button id="botonLeerMenos" onclick="ocultarTextoCompleto()" style="display: none;" class="btn btn-primary py-2 px-4">Leer Menos</button>
                            </div>
                        </div>
                    </div>
                    <!-- Plain Text End -->
                </div>
            @else
                <!-- No se encontraron blogs -->
                <p>No se encontraron blogs.</p>
            @endif
            <!-- Sidebar End -->
        </div>
    </div>
    <!-- Blog End -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-replies').click(function() {
                var commentId = $(this).data('comment-id');
                var showing = $(this).data('showing');
                var repliesDiv = $('#comment-replies-' + commentId);
                var replyCount = repliesDiv.find('.replies').length;

                // Mostrar u ocultar respuestas
                if (showing === "true") {
                    repliesDiv.hide();
                    if (replyCount > 1) {
                        $(this).text('(' + repliesDiv.find('.replies').length + ') respuestas');
                        $(this).data('showing', "false");
                    }else{
                        $(this).text('(' + repliesDiv.find('.replies').length + ') respuesta');
                        $(this).data('showing', "false");
                    }
                } else {
                    repliesDiv.show();
                    if (replyCount > 1) {
                        $(this).text('Ocultar respuestas');
                        $(this).data('showing', "true");
                    }else{
                        $(this).text('Ocultar respuesta');
                        $(this).data('showing', "true");
                    }
                }
            });
        });
    </script>
@include('includes.panel.footweb')
