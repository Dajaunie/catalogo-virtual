@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $articulo->nombre }}</h2>
    <img src="{{ asset('img/' . $articulo->imagen) }}" width="300" alt="{{ $articulo->nombre }}">
    <p><strong>Categoría:</strong> {{ $articulo->categoria }}</p>
    <p><strong>Precio:</strong> ${{ number_format($articulo->precio) }}</p>
    <p><strong>Stock disponible:</strong> {{ $articulo->stock }}</p>
    <p><strong>Descripción:</strong> {{ $articulo->descripcion }}</p>

    @auth
    <form action="{{ route('comprar.articulo', $articulo->id) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1" max="{{ $articulo->stock }}" required>
        </div>
        <button type="submit" class="btn btn-success">Comprar</button>
    </form>

    <form action="{{ route('carrito.agregar', $articulo->id) }}" method="POST" class="mt-2">
        @csrf
        <input type="hidden" name="cantidad" value="1">
        <button type="submit" class="btn btn-outline-primary">Agregar al carrito</button>
    </form>
    @else
    <p>Para comprar, por favor <a href="{{ route('login') }}">inicia sesión</a>.</p>
    @endauth

    <a href="{{ route('articulos.index') }}" class="btn btn-secondary mt-3">Volver al catálogo</a>
</div>
@endsection
