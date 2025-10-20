@extends('layouts.app')

@section('title', 'Detalle del Animal')

@section('content')
<div class="container">
    <a href="{{ route('animales.index') }}" class="btn btn-secondary mb-3">← Volver al listado</a>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Detalles del Animal</h4>
        </div>

        <div class="card-body row">
            <div class="col-md-4 text-center">
                @if($animal->foto)
                    <img src="{{ asset('storage/animales/'.$animal->foto) }}" alt="Foto del animal" class="img-fluid rounded">
                @else
                    <img src="https://via.placeholder.com/300x200?text=Sin+Foto" class="img-fluid rounded">
                @endif
            </div>

            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr><th>ID</th><td>{{ $animal->id }}</td></tr>
                    <tr><th>Arete</th><td>{{ $animal->arete }}</td></tr>
                    <tr><th>Especie</th><td>{{ $animal->especie }}</td></tr>
                    <tr><th>Raza</th><td>{{ $animal->raza }}</td></tr>
                    <tr><th>Sexo</th><td>{{ $animal->sexo == 'M' ? 'Macho' : 'Hembra' }}</td></tr>
                    <tr><th>Fecha de nacimiento</th><td>{{ $animal->fecha_nacimiento->format('d/m/Y') }}</td></tr>
                    <tr><th>Edad (años)</th><td>{{ $animal->edad_anos ?? '—' }}</td></tr>
                    <tr><th>Peso actual (kg)</th><td>{{ $animal->peso_actual ?? 'No registrado' }}</td></tr>
                    <tr><th>Activo</th><td>{{ $animal->activo ? 'Sí' : 'No' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
