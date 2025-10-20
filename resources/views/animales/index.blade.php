@extends('layouts.app')

@section('title','Lista de Animales')

@section('content')
<div class="container">
    <h1>Animales</h1>
    <a href="{{ route('animales.create') }}" class="btn btn-primary mb-3">Registrar Animal</a>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('animales.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="arete" class="form-control" placeholder="Buscar por arete..."
               value="{{ request('arete') }}">
    </div>

    <div class="d-flex justify-content-between mb-3">
    <h1>Animales</h1>
    <a href="{{ route('animales.export', request()->query()) }}" class="btn btn-outline-success">
        <i class="bi bi-file-earmark-excel"></i> Exportar Excel
    </a>
</div>


    <div class="col-md-3">
        <select name="sexo" class="form-select">
            <option value="">-- Sexo --</option>
            <option value="M" {{ request('sexo') == 'M' ? 'selected' : '' }}>Macho</option>
            <option value="H" {{ request('sexo') == 'H' ? 'selected' : '' }}>Hembra</option>
        </select>
    </div>

    <div class="col-md-3">
        <select name="activo" class="form-select">
            <option value="">-- Estado --</option>
            <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
            <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-success w-100" type="submit">Buscar</button>
    </div>
</form>

    <table class="table table-striped">
      <thead>
        <tr><th>Arete</th><th>Especie</th><th>Raza</th><th>Sexo</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        @foreach($animales as $a)
        <tr>
          <td>{{ $a->arete }}</td>
          <td>{{ $a->especie }}</td>
          <td>{{ $a->raza }}</td>
          <td>{{ $a->sexo == 'M' ? 'Macho' : 'Hembra' }}</td>
          <td>
            <a href="{{ route('animales.show', $a) }}" class="btn btn-sm btn-info">Ver</a>
            <a href="{{ route('animales.edit', $a) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('animales.destroy', $a) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmar?')">Desactivar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{ $animales->links() }}
</div>
@endsection
