@extends('layouts.app')

@section('title', 'Registrar Animal')

@section('content')
<div class="container">
    <h1>Registrar Animal</h1>

    <a href="{{ route('animales.index') }}" class="btn btn-secondary mb-3">← Volver al listado</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Corrige los errores:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('animales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="arete" class="form-label">Número de Arete</label>
                <input type="text" name="arete" class="form-control" value="{{ old('arete') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="especie" class="form-label">Especie</label>
                <input type="text" name="especie" class="form-control" value="{{ old('especie') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="raza" class="form-label">Raza</label>
                <input type="text" name="raza" class="form-control" value="{{ old('raza') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
                    <option value="H" {{ old('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="peso_actual" class="form-label">Peso Actual (kg)</label>
                <input type="number" step="0.01" name="peso_actual" class="form-control" value="{{ old('peso_actual') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (opcional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar Animal</button>
    </form>
</div>
@endsection
