@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel de Administración</h1>
        <a href="{{ route('restaurantes.index') }}" class="btn btn-secondary">Ver Restaurantes</a>
        <a href="{{ route('restaurantes.create') }}" class="btn btn-primary">Crear Restaurante</a>
    </div>
@endsection
