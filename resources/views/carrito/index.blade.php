@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Carrito de Compras</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @if (!empty($carrito))
        <form action="{{ route('carrito.comprar') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($carrito as $id => $item)
                        @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>${{ number_format($item['precio']) }}</td>
                            <td>
                                <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['stock'] }}">
                                    <button type="submit" class="btn btn-sm btn-info">Actualizar</button>
                                </form>
                            </td>
                            <td>${{ number_format($subtotal) }}</td>
                            <td>
                                <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>${{ number_format($total) }}</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </form>
    @else
        <p>Tu carrito está vacío.</p>
    @endif

    <a href="{{ route('articulos.index') }}" class="btn btn-secondary mt-3">Volver al catálogo</a>
</div>
@endsection
