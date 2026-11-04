@extends('base')

@section('title', 'Editar comentario')

@section('header')
<header class="masthead" style="background-image: url('{{ asset('assets/img/home-bg.jpg') }}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Editar comentario</h1>
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

            <form action="{{ route('comentario.update', $comentario) }}" method="post">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required minlength="2" maxlength="255">{{ old('mensaje', $comentario->mensaje) }}</textarea>
                    @error('mensaje')
                    <div class="alert alert-danger" role="alert" style="margin-top: 6px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="valoracion" class="form-label">Valoración</label>
                    <select class="form-select" id="valoracion" name="valoracion" required>
                        <option value="positivo" @selected(old('valoracion', $comentario->valoracion) == 'positivo')>Positivo</option>
                        <option value="negativo" @selected(old('valoracion', $comentario->valoracion) == 'negativo')>Negativo</option>
                    </select>
                    @error('valoracion')
                    <div class="alert alert-danger" role="alert" style="margin-top: 6px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-secondary">Editar comentario</button>
                <a href="{{ route('noticia.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection