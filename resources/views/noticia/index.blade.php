@extends('base')

@section('title', 'Noticias')

@section('header')
<header class="masthead" style="background-image: url('{{ asset('assets/img/home-bg.jpg') }}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Noticias</h1>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            @error('error')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror

            <div class="text-center mb-5">
                <a href="{{ route('noticia.create') }}" class="btn btn-secondary">Crear noticia</a>
            </div>

            @forelse($noticias as $noticia)
                <div class="mb-5">
                    <h3>{{ $noticia->titulo }}</h3>
                    <p class="text-muted">{{ $noticia->created_at->format('d/m/Y H:i') }}</p>
                    <!-- <p>{{ $noticia->texto }}</p> -->
                    <p style="white-space: pre-line; overflow-wrap: anywhere; text-align: justify;">{{ $noticia->texto }}</p>

                    {{-- Regla 3: editar solo los primeros 20 minutos --}}
                    @if($noticia->puedeEditarse())
                        <a href="{{ route('noticia.edit', $noticia) }}" class="btn btn-secondary">Editar</a>
                    @endif

                    {{-- Regla 1: sin comentarios para poder borrar --}}
                    @if($noticia->comentarios->isEmpty())
                        <form data-message="la noticia &quot;{{ $noticia->titulo }}&quot;" class="confirm-dialog" action="{{ route('noticia.destroy', $noticia) }}" method="post" style="display: inline;">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Eliminar" class="btn btn-secondary">
                        </form>
                    @endif

                    <a href="{{ route('noticia.comentario.create', $noticia) }}" class="btn btn-secondary">Crear comentario</a>

                    {{-- Comentarios --}}
                    @if($noticia->comentarios->isNotEmpty())
                        <h5 class="mt-4">Comentarios ({{ $noticia->comentarios->count() }})</h5>
                        @foreach($noticia->comentarios as $comentario)
                            <div class="border rounded p-3 mb-2">
                                <span class="badge {{ $comentario->valoracion === 'positivo' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($comentario->valoracion) }}
                                </span>
                                <small class="text-muted">{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
                                <!-- <p class="mb-2">{{ $comentario->mensaje }}</p> -->
                                <p class="mb-2" style="white-space: pre-line; overflow-wrap: anywhere;">{{ $comentario->mensaje }}</p>

                                {{-- Regla 2: editar y borrar solo durante 5 minutos --}}
                                @if($comentario->puedeModificarse())
                                    <a href="{{ route('comentario.edit', $comentario) }}" class="btn btn-sm btn-secondary">Editar</a>
                                    <form data-message="este comentario" class="confirm-dialog" action="{{ route('comentario.destroy', $comentario) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('delete')
                                        <input type="submit" value="Eliminar" class="btn btn-sm btn-secondary">
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr>
            @empty
                <p class="text-center">No hay noticias todavía.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('form.confirm-dialog').forEach(
        form => {
            form.addEventListener('submit', e => {
                const message = '¿Seguro que quieres borrar ' + form.dataset.message + '?';
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        }
    );
</script>
@endsection