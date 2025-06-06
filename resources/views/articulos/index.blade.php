@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Catálogo de Artículos</h1>
    <a href="{{ route('articulos.busquedaAvanzada') }}" class="btn btn-secondary mb-3">Búsqueda avanzada</a>


    <form action="{{ route('articulos.buscar') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Buscar por nombre..." value="{{ request('query') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <div class="row">
        @forelse ($articulos as $articulo)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <img src="{{ asset('img/' . $articulo->imagen) }}" class="card-img-top" alt="{{ $articulo->nombre }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $articulo->nombre }}</h5>
                        <p class="card-text">${{ number_format($articulo->precio) }}</p>
                        <a href="{{ route('articulos.show', $articulo->id) }}" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No se encontraron artículos con ese nombre.</p>
        @endforelse
    </div>
</div>
@endsection
