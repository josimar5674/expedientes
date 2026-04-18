@extends('layouts.app')
@section('content')
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Usuarios</h2>

        <a href="{{ route('usuarios.create') }}" class="bg-blue-500 text-white px-3 py-2 rounded">
            Nuevo Usuario
        </a>

        <table class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">ID</th>
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Rol</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr class="border">
                        <td class="p-2">{{ $user->id }}</td>
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ $user->role }}</td>
                        <td class="p-2">
                            <a href="{{ route('usuarios.edit', $user) }}">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection