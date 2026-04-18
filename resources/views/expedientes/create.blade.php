@if(session('success'))
    <div class="bg-green-200 p-2 mb-4">
        {{ session('success') }}
    </div>
@endif

@extends('layouts.app')
@section('content')

    <div class="max-w-4xl mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Crear Expediente</h2>

        <form method="POST" action="{{ route('expedientes.store') }}">
            @csrf

            <!-- Número Expediente -->
            <div class="mb-4">
                <label>Número/clave Expediente</label>
                <input type="text" name="numero_expediente"
                    value="{{ old('numero_expediente') }}"
                    class="w-full border rounded p-2">
                
                @error('numero_expediente')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <!-- Tipo -->
            <div class="mb-4">
                <label>Tipo de Trámite</label>
                <select name="tipo_tramite" class="w-full border rounded p-2">
                    <option value="">Seleccione una opción</option>
                    <option value="Judicial" {{ old('tipo_tramite') == 'Judicial' ? 'selected' : '' }}>Judicial</option>
                    <option value="Administrativo" {{ old('tipo_tramite') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                </select>

                @error('tipo_tramite')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <!-- Matrícula -->
            <div class="mb-4">
                <label>Matrícula</label>
                <input type="text" name="matricula"
                    value="{{ old('matricula') }}"
                    class="w-full border rounded p-2">
            </div>

            <!-- Sede -->
            <div class="mb-4">
                <label>Sede</label>
                <input type="text" name="sede"
                    value="{{ old('sede') }}"
                    class="w-full border rounded p-2">
            </div>

            <!-- Pretensión -->
            <div class="mb-4">
                <label>Pretensión Principal</label>
                <textarea name="pretension_principal" class="w-full border rounded p-2">{{ old('pretension_principal') }}</textarea>
            </div>

            <!-- Cuantía -->
            <div class="mb-4">
                <label>Cuantía</label>
                <input type="number" step="0.01" name="cuantia"
                    value="{{ old('cuantia') }}"
                    class="w-full border rounded p-2">
            </div>

            <!-- Fecha -->
            <div class="mb-4">
                <label>Fecha de Presentación</label>
                <input type="date" name="fecha_presentacion"
                    value="{{ old('fecha_presentacion') }}"
                    class="w-full border rounded p-2">
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label>Descripción del Proceso</label>
                <textarea name="descripcion_proceso" class="w-full border rounded p-2">{{ old('descripcion_proceso') }}</textarea>
            </div>

            <div style="margin-top:10px; display:flex; gap:10px;">

    <!-- 🔙 BOTÓN ATRÁS -->
    <a href="{{ route('expedientes.index') }}" 
       class="bg-gray-500 text-white px-4 py-2 rounded">
        ← Atrás
    </a>

    <!-- 💾 BOTÓN GUARDAR -->
    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Guardar
    </button>

</div>
        </form>
    </div>
@endsection