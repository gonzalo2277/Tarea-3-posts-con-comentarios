@extends('base')

@section('title', 'Inicio')

@section('header')
<header class="masthead" style="background-image: url('{{ asset('assets/img/home-bg.jpg') }}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Practica Noticias</h1>
                    <span class="subheading">Las últimas noticias</span>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            {{-- aquí pegas los .post-preview del index.html --}}
        </div>
    </div>
</div>
@endsection