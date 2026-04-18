
   @extends('layouts.app')
@section('content')
   
   <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Crear Usuario</h2>

        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf

            <input name="name" placeholder="Nombre" class="border p-2 w-full mb-2">
            <input name="email" placeholder="Email" class="border p-2 w-full mb-2">
            <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-2">

            <select name="role" class="border p-2 w-full mb-2">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>

            <button class="bg-blue-500 text-white px-4 py-2">Guardar</button>
        </form>
    </div>
@endsection