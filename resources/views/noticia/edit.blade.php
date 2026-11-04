@extends('base')

@section('title', 'Editar noticia')

@section('header')
<header class="masthead" style="background-image: url('{{ asset('assets/img/home-bg.jpg') }}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Editar noticia</h1>
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

            @error('error')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror

            <form action="{{ route('noticia.update', $noticia) }}" method="post">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" value="{{ old('titulo', $noticia->titulo) }}" class="form-control" id="titulo" name="titulo" required minlength="3" maxlength="150">
                    @error('titulo')
                    <div class="alert alert-danger" role="alert" style="margin-top: 6px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="texto" class="form-label">Texto</label>
                    <textarea class="form-control" id="texto" name="texto" rows="8" required minlength="10">{{ old('texto', $noticia->texto) }}</textarea>
                    @error('texto')
                    <div class="alert alert-danger" role="alert" style="margin-top: 6px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-secondary">Editar noticia</button>
                <a href="{{ route('noticia.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection