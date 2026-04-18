


@extends('layouts.app')
@section('content')

<script>
function activarEdicion() {
    document.getElementById('modo-vista').style.display = 'none';
    document.getElementById('modo-edicion').style.display = 'block';
}

function cancelarEdicion() {
    document.getElementById('modo-edicion').style.display = 'none';
    document.getElementById('modo-vista').style.display = 'grid';
}
</script>

<div class="main-container">

    <!-- 🔹 SIDEBAR -->
    <div class="sidebar">
        <h3>Expedientes</h3>

        <div class="exp-list">
            @foreach ($expedientes as $exp)
                <a href="{{ route('expedientes.show', $exp->id) }}">
                    <div class="exp-item 
                        {{ isset($expedienteSeleccionado) && $expedienteSeleccionado->id == $exp->id ? 'active' : '' }}">
                        
                        <strong>#{{ $exp->numero_expediente }}</strong><br>
                        <small>{{ $exp->tipo_tramite }}</small><br>
                        <small>{{ $exp->user->name ?? 'N/A' }}</small><br>
                        <small>Estado: <strong>{{ strtoupper($exp->estado) }}</strong></small>

                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- 🔸 CONTENT -->
    <div class="content">

        <!-- HEADER -->
        <div class="header">
            <h2>Gestión de Expedientes</h2>

            <a href="{{ route('expedientes.create') }}" class="btn">
                + Nuevo Expediente
            </a>
        </div>

        @if ($expedienteSeleccionado)

            <!-- 🔹 INFO GENERAL -->
<div class="bg-white dark:bg-gray-800 p-4">
    <h3>Información General</h3>

    <!-- 🔘 BOTÓN EDITAR -->
    <button onclick="activarEdicion()" class="bg-yellow-500 text-white px-3 py-1 rounded mb-3">
        ✏️ Editar
    </button>

    <!-- 👀 MODO VISTA -->
    <div id="modo-vista" style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">

        <p><strong>Expediente:</strong> #{{ $expedienteSeleccionado->numero_expediente }}</p>
        <p><strong>Tipo:</strong> {{ $expedienteSeleccionado->tipo_tramite }}</p>

        <p><strong>Matrícula:</strong> {{ $expedienteSeleccionado->matricula }}</p>
        <p><strong>Sede:</strong> {{ $expedienteSeleccionado->sede }}</p>

        <p><strong>Cuantía:</strong> L {{ number_format($expedienteSeleccionado->cuantia, 2) }}</p>
        <p><strong>Fecha:</strong> {{ $expedienteSeleccionado->fecha_presentacion }}</p>

        <p><strong>Pretensión:</strong> {{ $expedienteSeleccionado->pretension_principal }}</p>
        <p><strong>Descripción:</strong> {{ $expedienteSeleccionado->descripcion_proceso }}</p>

        <p>
            <strong>Estado:</strong> 
            @php
                $estado = $expedienteSeleccionado->estado;
                $clases = [
                    'pendiente' => 'bg-yellow-500',
                    'en_proceso' => 'bg-blue-500',
                    'audiencia' => 'bg-purple-500',
                    'resuelto' => 'bg-green-500',
                    'cerrado' => 'bg-gray-500',
                ];
                $clase = $clases[$estado] ?? 'bg-red-500';
            @endphp

            <span class="{{ $clase }} text-white px-2 py-1 rounded">
                {{ strtoupper($estado) }}
            </span>
        </p>

        <p><strong>Usuario:</strong> {{ $expedienteSeleccionado->user->name }}</p>

    </div>

    <!-- ✏️ MODO EDICIÓN -->
    <form id="modo-edicion" method="POST" 
          action="{{ route('expedientes.update', $expedienteSeleccionado->id) }}"
          style="display:none;">

        @csrf
        @method('PUT')

  <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">

    <div>
        <label>Tipo</label>
        <select name="tipo_tramite" 
        class="border p-2 rounded w-full 
        bg-white text-black 
        dark:bg-gray-700 dark:text-white dark:border-gray-600">
            <option value="Judicial" {{ $expedienteSeleccionado->tipo_tramite == 'Judicial' ? 'selected' : '' }}>Judicial</option>
            <option value="Administrativo" {{ $expedienteSeleccionado->tipo_tramite == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
        </select>
    </div>

    <div>
        <label>Matrícula</label>
        <input type="text" name="matricula" 
            value="{{ $expedienteSeleccionado->matricula }}" 
            class="border p-2 rounded w-full 
            bg-white text-black 
            dark:bg-gray-700 dark:text-white dark:border-gray-600">
    </div>

    <div>
        <label>Sede</label>
        <input type="text" name="sede" 
            value="{{ $expedienteSeleccionado->sede }}" 
            class="border p-2 rounded w-full 
            bg-white text-black 
            dark:bg-gray-700 dark:text-white dark:border-gray-600">
    </div>

    <div>
        <label>Cuantía</label>
        <input type="number" name="cuantia" 
            value="{{ $expedienteSeleccionado->cuantia }}" 
            class="border p-2 rounded w-full 
            bg-white text-black 
            dark:bg-gray-700 dark:text-white dark:border-gray-600">
    </div>

    <div style="grid-column: span 2;">
        <label>Pretensión</label>
        <textarea name="pretension_principal" 
        class="border p-2 rounded w-full 
        bg-white text-black 
        dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ $expedienteSeleccionado->pretension_principal }}</textarea>
    </div>

    <div style="grid-column: span 2;">
        <label>Descripción</label>
        <textarea name="descripcion_proceso" 
        class="border p-2 rounded w-full 
        bg-white text-black 
        dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ $expedienteSeleccionado->descripcion_proceso }}</textarea>
    </div>
    @if(auth()->user()->role === 'admin')
    <div>
        <label>Asignar a usuario</label>
        <select name="user_id" 
            class="border p-2 rounded w-full 
            bg-white text-black 
            dark:bg-gray-700 dark:text-white dark:border-gray-600">
            
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}" 
                    {{ $expedienteSeleccionado->user_id == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->name }}
                </option>
            @endforeach

        </select>
    </div>
@endif

</div>

     <div style="margin-top:10px; display:flex; gap:10px;">

    <!-- ❌ CANCELAR -->
    <button type="button" onclick="cancelarEdicion()" 
        class="bg-gray-500 text-white px-4 py-2 rounded">
        ❌ Cancelar
    </button>

    <!-- 💾 GUARDAR -->
    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        💾 Guardar
    </button>

</div>

    </form>

</div>


            <!-- 🔄 CAMBIAR ESTADO -->
            <div class="bg-white dark:bg-gray-800 p-4">
                <h3>Cambiar Estado</h3>

                <form method="POST" action="{{ route('expedientes.estado.update', $expedienteSeleccionado->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">
                        <select class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600" name="estado">
                            <option value="pendiente" {{ old('estado', $expedienteSeleccionado->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_proceso" {{ old('estado', $expedienteSeleccionado->estado) == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="audiencia" {{ old('estado', $expedienteSeleccionado->estado) == 'audiencia' ? 'selected' : '' }}>Audiencia</option>
                            <option value="resuelto" {{ old('estado', $expedienteSeleccionado->estado) == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                            <option value="cerrado" {{ old('estado', $expedienteSeleccionado->estado) == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>

                        <button class="btn">Actualizar</button>
                    </div>
                </form>
            </div>

        
<div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">

    <!-- 👥 SUJETOS -->
   <div class="bg-white dark:bg-gray-800 p-4">
        <h3>👥 Sujetos</h3>

         <form method="POST" action="{{ route('expedientes.sujetos.store', $expedienteSeleccionado->id) }}">
                    @csrf

                    <div class="form-grid">
                       <select name="tipo" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <option value="activo">Activo</option>
                            <option value="pasivo">Pasivo</option>
                            <option value="apoderado">Apoderado</option>
                        </select>

                        <input type="text" name="nombre" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="Nombre">
                        <input type="text" name="identificacion" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="Identificación">
                        <input type="text" name="cah" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="CAH">
                    </div>

                    <button class="btn">Guardar</button>
                </form>

                <br>

                @foreach ($expedienteSeleccionado->sujetos as $sujeto)
                    <div class="list-item bg-white text-black dark:bg-gray-700 dark:text-white p-2 rounded mb-2">
                        <strong>{{ strtoupper($sujeto->tipo) }}</strong><br>
                        {{ $sujeto->nombre }}<br>
                        <small>{{ $sujeto->identificacion }}</small>
                    </div>
                @endforeach
    </div>

    <!-- 📎 DOCUMENTOS -->
<div class="bg-white dark:bg-gray-800 p-4">
    

                 <h3>📎 Documentos</h3>

                <form method="POST" 
                    action="{{ route('expedientes.documentos.store', $expedienteSeleccionado->id) }}" 
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                       <input type="date" name="fecha" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white">
                        <input type="text" name="titulo" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="Título">
                        <input type="text" name="descripcion" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="Descripción">
                        <input type="file" name="archivo" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white">
                    </div>

                    <button class="btn">Guardar</button>
                </form>

                <br>

                @foreach ($expedienteSeleccionado->documentos->sortByDesc('fecha') as $doc)
                   <div class="list-item bg-white text-black dark:bg-gray-700 dark:text-white p-2 rounded mb-2">
                        <strong>{{ $doc->titulo }}</strong><br>
                        <small>{{ $doc->fecha }}</small><br>
                        <p>{{ $doc->descripcion }}</p>

                        <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">
                            Ver Documento 📄
                        </a>
                    </div>
                @endforeach
    </div>

</div>


            <!-- 📜 MOVIMIENTOS -->
          <div class="bg-white dark:bg-gray-800 p-4">
                <h3>📜 Movimientos</h3>

                <form method="POST" 
                    action="{{ route('expedientes.movimientos.store', $expedienteSeleccionado->id) }}" 
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                    <input type="date" name="fecha" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white">
                        <input type="file" name="archivo" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white">
                    </div>

                    <textarea name="descripcion" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="Descripción"></textarea>
                    <button class="btn">Guardar</button>
                </form>

                <br>

                @foreach ($expedienteSeleccionado->movimientos->sortByDesc('fecha') as $mov)
                   <div class="list-item bg-white text-black dark:bg-gray-700 dark:text-white p-2 rounded mb-2">
                        <strong>{{ $mov->fecha }}</strong><br>
                        {{ $mov->descripcion }}<br>

                        @if ($mov->archivo)
                            <a href="{{ asset('storage/' . $mov->archivo) }}" target="_blank">
                                Ver PDF 📄
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

       

        @else
            <div class="bg-white dark:bg-gray-800 p-4">
                <h3>Selecciona un expediente</h3>
            </div>
        @endif

    </div>
</div>

</div>

@endsection



