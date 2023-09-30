@if ($blogs->count() > 0)
    @foreach($blogs as $blog)
        <div class="col-xl-4 col-lg-6">
            <div class="card bg-light rounded overflow-hidden">
                @if($blog->tipo === 'imagen')
                    <img style="width: 100%; height: 216px;" src="{{ asset($blog->archivo) }}" alt="">
                @elseif($blog->tipo === 'video')
                    <div style="width: 100%; height: 216px; position: relative;">
                        <video
                            autoplay="true"
                            muted="true"
                            preload="auto"
                            loop="loop"
                            controls>
                            <source src="{{ asset($blog->archivo) }}" type="video/mp4">
                            Tu navegador no admite el elemento de video.
                        </video>
                    </div>
                @endif
                <div class="card-body">
                    <a class="h3 d-block mb-3" href="">{{ $blog->titulo }}</a>
                    <p class="card-text">{!! nl2br($blog->descripcion) !!}</p>
                </div>
            </div>
        </div>
    @endforeach
@endif
