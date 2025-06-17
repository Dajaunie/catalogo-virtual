@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row g-4">
        <div class="col-md-6">
            <img src="{{ asset('img/' . $articulo->imagen) }}" class="img-fluid rounded shadow-sm" alt="{{ $articulo->nombre }}">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $articulo->nombre }}</h2>
            <p class="text-muted">Categoría: <strong>{{ $articulo->categoria }}</strong></p>
            <p class="fs-4">Precio: <strong>${{ number_format($articulo->precio) }}</strong></p>
            <p>Stock disponible: <strong>{{ $articulo->stock }}</strong></p>
            <p class="mt-3">{{ $articulo->descripcion }}</p>

            @auth
            <form action="{{ route('comprar.articulo', $articulo->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1" max="{{ $articulo->stock }}" required>
                </div>
                <button type="submit" class="btn btn-success"><i class="bi bi-cash-coin"></i> Comprar</button>
            </form>

            <form action="{{ route('carrito.agregar', $articulo->id) }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="cantidad" value="1">
                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i> Agregar al carrito</button>
            </form>
            @else
            <p class="mt-3">Para comprar, por favor <a href="{{ route('login') }}">inicia sesión</a>.</p>
            @endauth

            <a href="{{ route('articulos.index') }}" class="btn btn-secondary mt-4"><i class="bi bi-arrow-left"></i> Volver al catálogo</a>
        </div>
    </div>
</div>
@endsection
