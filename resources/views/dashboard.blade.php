@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')
<div class="container py-5 text-center">
    <h1 class="mb-3">🐄 Sistema de Gestión Ganadera</h1>
    <p class="lead">Bienvenido al panel principal del sistema.</p>
    <a href="{{ route('animales.index') }}" class="btn btn-primary">Ver animales</a>
</div>
@endsection
