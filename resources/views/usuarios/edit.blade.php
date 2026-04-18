@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
        @csrf
        @method('PUT')

        <input name="name" value="{{ $usuario->name }}" class="border p-2 w-full mb-2">

        <input name="email" value="{{ $usuario->email }}" class="border p-2 w-full mb-2">

        <input type="password" name="password" placeholder="Nueva contraseña (opcional)" class="border p-2 w-full mb-2">

        <select name="role" class="border p-2 w-full mb-2">
            <option value="user" {{ $usuario->role == 'user' ? 'selected' : '' }}>Usuario</option>
            <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Administrador</option>
        </select>

        <div class="flex gap-2">
            <a href="{{ route('usuarios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                ← Volver
            </a>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Actualizar
            </button>
        </div>
    </form>
</div>

@endsection