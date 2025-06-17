@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center fw-bold">Catálogo de Artículos</h1>

    <!-- Búsqueda Avanzada -->
    <form action="{{ route('articulos.busquedaAvanzada') }}" method="GET" class="mb-4 p-4 bg-light rounded shadow-sm">
        <h5 class="mb-3"><i class="bi bi-funnel"></i> Búsqueda Avanzada</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <option value="Video juegos">Video juegos</option>
                    <option value="Computadores">Computadores</option>
                    <option value="Escritorios">Escritorios</option>
                    <option value="Celulares">Celulares</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="precio_min" class="form-label">Precio mínimo</label>
                <input type="number" name="precio_min" class="form-control" placeholder="0">
            </div>
            <div class="col-md-4">
                <label for="precio_max" class="form-label">Precio máximo</label>
                <input type="number" name="precio_max" class="form-control" placeholder="1000000">
            </div>
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-success mt-2"><i class="bi bi-search"></i> Buscar</button>
            </div>
        </div>
    </form>

    <!-- Búsqueda Rápida -->
    <form action="{{ route('articulos.buscar') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Buscar por nombre..." value="{{ request('query') }}">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
        </div>
    </form>

    <!-- Catálogo -->
    <div class="row">
        @forelse ($articulos as $articulo)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('img/' . $articulo->imagen) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $articulo->nombre }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $articulo->nombre }}</h5>
                        <p class="card-text">${{ number_format($articulo->precio) }}</p>
                        <a href="{{ route('articulos.show', $articulo->id) }}" class="btn btn-primary mt-auto"><i class="bi bi-info-circle"></i> Ver más</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">No se encontraron artículos con ese nombre o filtro.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection