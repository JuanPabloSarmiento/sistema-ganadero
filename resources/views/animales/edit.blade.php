@extends('layouts.app')

@section('title', 'Editar Animal')

@section('content')
<div class="container">
    <h1>Editar Animal</h1>

    <a href="{{ route('animales.index') }}" class="btn btn-secondary mb-3">← Volver al listado</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Corrige los errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('animales.update', $animal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="arete" class="form-label">Número de Arete</label>
                <input type="text" name="arete" class="form-control" value="{{ old('arete', $animal->arete) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="especie" class="form-label">Especie</label>
                <input type="text" name="especie" class="form-control" value="{{ old('especie', $animal->especie) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="raza" class="form-label">Raza</label>
                <input type="text" name="raza" class="form-control" value="{{ old('raza', $animal->raza) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" class="form-control" required>
                    <option value="M" {{ old('sexo', $animal->sexo) == 'M' ? 'selected' : '' }}>Macho</option>
                    <option value="H" {{ old('sexo', $animal->sexo) == 'H' ? 'selected' : '' }}>Hembra</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control"
                       value="{{ old('fecha_nacimiento', $animal->fecha_nacimiento->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="peso_actual" class="form-label">Peso actual (kg)</label>
                <input type="number" step="0.01" name="peso_actual" class="form-control"
                       value="{{ old('peso_actual', $animal->peso_actual) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto actual:</label><br>
            @if($animal->foto)
                <img src="{{ asset('storage/animales/'.$animal->foto) }}" width="200" class="rounded mb-2">
            @else
                <p class="text-muted">Sin foto</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Nueva foto (opcional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
