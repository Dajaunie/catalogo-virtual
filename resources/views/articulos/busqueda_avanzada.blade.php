@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Búsqueda Avanzada de Artículos</h1>

    <form action="{{ route('articulos.busquedaAvanzada') }}" method="GET" class="mb-4">
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" id="categoria" class="form-select">
                <option value="">-- Seleccionar categoría --</option>
                <option value="Ropa" {{ request('categoria') == 'Ropa' ? 'selected' : '' }}>Ropa</option>
                <option value="Zapatos" {{ request('categoria') == 'Zapatos' ? 'selected' : '' }}>Zapatos</option>
                <option value="Tecnología" {{ request('categoria') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                <option value="Libros" {{ request('categoria') == 'Libros' ? 'selected' : '' }}>Libros</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="precio_min" class="form-label">Precio mínimo</label>
            <input type="number" name="precio_min" id="precio_min" class="form-control" value="{{ request('precio_min') }}" min="0">
        </div>

        <div class="mb-3">
            <label for="precio_max" class="form-label">Precio máximo</label>
            <input type="number" name="precio_max" id="precio_max" class="form-control" value="{{ request('precio_max') }}" min="0">
        </div>

        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>
@endsection
