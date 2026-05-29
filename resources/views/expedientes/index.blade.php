@extends('layouts.app')
@section('content')


<style>
    .panel-card {

        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 14px;

        padding: 18px;

        margin-bottom: 18px;

        box-shadow:

            0 1px 3px rgba(0, 0, 0, .08),

            0 8px 24px rgba(0, 0, 0, .05);

        transition: .2s;

    }

    .dark .panel-card {

        background: #1f2937;

        border-color: #374151;

    }

    .panel-card:hover {

        transform: translateY(-3px);

    }

    /* =========================
   COLORES POR SECCIÓN
   ========================= */
    .panel-info {

        border-top: 3px solid #0A84FF;

    }

    .panel-sujetos {

        border-top: 3px solid #0A84FF;

    }

    .panel-documentos {

        border-top: 3px solid #8E8E93;

    }

    .panel-movimientos {

        border-top: 3px solid #5E5CE6;

    }

    .panel-estado {

        border-top: 3px solid #30D158;

    }

    /* DARK MODE */

    .dark .panel-info {

        border-top-color: #64D2FF;

    }

    .dark .panel-sujetos {

        border-top-color: #64D2FF;

    }

    .dark .panel-documentos {

        border-top-color: #AEAEB2;

    }

    .dark .panel-movimientos {

        border-top-color: #7D7AFF;

    }

    .dark .panel-estado {

        border-top-color: #32D74B;

    }

    /* =========================
   TÍTULOS
   ========================= */

    .panel-title {

        display: flex;

        align-items: center;

        gap: 10px;

        margin-bottom: 15px;

        padding-bottom: 10px;

        border-bottom: 1px solid #e5e7eb;

        font-size: 18px;

        font-weight: 600;

        color: #1d1d1f;

    }

    .dark .panel-title {

        color: #f5f5f7;

        border-color: #374151;

    }

    .dark .panel-title {
        border-color: #374151;
    }

    /* COLOR DEL TEXTO DEL TÍTULO */

    .panel-info .panel-title {
        color: #2563eb;
    }

    .panel-sujetos .panel-title {
        color: #059669;
    }

    .panel-documentos .panel-title {
        color: #d97706;
    }

    .panel-movimientos .panel-title {
        color: #7c3aed;
    }

    .panel-estado .panel-title {
        color: #1d4f24ff;
    }

    /* DARK MODE */

    .dark .panel-info .panel-title {
        color: #60a5fa;
    }

    .dark .panel-sujetos .panel-title {
        color: #34d399;
    }

    .dark .panel-documentos .panel-title {
        color: #fbbf24;
    }

    .dark .panel-movimientos .panel-title {
        color: #a78bfa;
    }

    .dark .panel-estado .panel-title {
        color: #6b8bcaff;
    }

    /* =========================
   LAYOUT
   ========================= */

    html,
    body {
        min-height: 100%;
    }

    .main-container {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 320px;
        border-right: 1px solid #ddd;
        position: sticky;
        top: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .exp-list {
        flex: 1;
        overflow-y: auto;
        padding-right: 5px;
    }

    .content {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
    }

    .panel-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        align-items: start;
    }

    .scroll-panel {
        max-height: 450px;
        overflow-y: auto;
    }

    /* SCROLL */

    .scroll-panel::-webkit-scrollbar,
    .exp-list::-webkit-scrollbar,
    .content::-webkit-scrollbar,
    .movimientos-panel::-webkit-scrollbar {
        width: 8px;
    }

    .scroll-panel::-webkit-scrollbar-thumb,
    .exp-list::-webkit-scrollbar-thumb,
    .content::-webkit-scrollbar-thumb,
    .movimientos-panel::-webkit-scrollbar-thumb {
        background: #999;
        border-radius: 10px;
    }

    /* ==========================
   SIDEBAR
   ========================== */

.sidebar{
    width:320px;
    height:100vh;

    background:#f8fafc;
    border-right:1px solid #e5e7eb;

    display:flex;
    flex-direction:column;
}

.dark .sidebar{
    background:#111827;
    border-color:#374151;
}

.sidebar-header{
    padding:15px;
    border-bottom:1px solid #e5e7eb;
}

.dark .sidebar-header{
    border-color:#374151;
}

.sidebar-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:10px;
}

.sidebar-search{
    width:100%;
    padding:10px 12px;

    border-radius:10px;
    border:1px solid #d1d5db;

    outline:none;
}

.sidebar-search:focus{
    border-color:#0A84FF;
}

.dark .sidebar-search{
    background:#1f2937;
    color:white;
    border-color:#374151;
}

.expediente-card{
    margin:10px;
    padding:12px;

    border-radius:12px;

    background:white;
    border:1px solid #e5e7eb;

    transition:.2s;
}

.dark .expediente-card{
    background:#1f2937;
    border-color:#374151;
}

.expediente-card:hover{
    transform:translateY(-1px);

    box-shadow:
        0 4px 15px rgba(0,0,0,.08);
}

.expediente-card.active{
    border-left:4px solid #0A84FF;
    background:#eff6ff;
}

.dark .expediente-card.active{
    background:#172554;
}

/* BADGES */

.estado-badge{
    font-size:11px;
    padding:4px 8px;
    border-radius:999px;
    font-weight:600;
}

.estado-pendiente{
    background:#fef3c7;
    color:#92400e;
}

.estado-proceso{
    background:#dbeafe;
    color:#1d4ed8;
}

.estado-audiencia{
    background:#ede9fe;
    color:#6d28d9;
}

.estado-resuelto{
    background:#dcfce7;
    color:#166534;
}

.estado-cerrado{
    background:#e5e7eb;
    color:#374151;
}
</style>

<script>
    function activarEdicion() {
        document.getElementById('modo-vista').style.display = 'none';
        document.getElementById('modo-edicion').style.display = 'block';
    }

    function cancelarEdicion() {
        document.getElementById('modo-edicion').style.display = 'none';
        document.getElementById('modo-vista').style.display = 'grid';
    }

    // FORMULARIOS DOCUMENTOS
    function toggleForm(id) {

        let form = document.getElementById(id);

        if (form) {
            form.classList.toggle('hidden');
        }

    }

    // FORMULARIOS EDICIÓN
    function toggleEdit(id) {
        let form = document.getElementById('edit-' + id);

        if (form) {
            form.classList.toggle('hidden');
        }
    }
</script>

@php
$puedeEditar = false;

if ($expedienteSeleccionado) {
$puedeEditar =
auth()->user()->role === 'admin'
|| (
$expedienteSeleccionado->user_id === auth()->id()
&& $expedienteSeleccionado->permite_edicion
);
}
@endphp

<div class="main-container">

    <!-- 🔹 SIDEBAR -->
<div class="sidebar">

    <div class="sidebar-header">

        <h3 class="sidebar-title">
            📂 Expedientes
        </h3>

        <input
            type="text"
            id="buscarExpediente"
            placeholder="Buscar expediente..."
            class="sidebar-search">

    </div>

    <div class="exp-list">

        @foreach ($expedientes as $exp)

        <a href="{{ route('expedientes.show', $exp->id) }}"
           class="block">

            <div class="exp-item expediente-card
                {{ isset($expedienteSeleccionado) && $expedienteSeleccionado->id == $exp->id ? 'active' : '' }}">

                <div class="font-semibold text-sm">
                    #{{ $exp->numero_expediente }}
                </div>

                <div class="text-xs opacity-80">
                    {{ $exp->tipo_tramite }}
                </div>

                <div class="text-xs opacity-80">
                    {{ $exp->user->name ?? 'N/A' }}
                </div>

                <div class="mt-2">

                    @php
                        $estadoColor = [
                            'pendiente' => 'estado-pendiente',
                            'en_proceso' => 'estado-proceso',
                            'audiencia' => 'estado-audiencia',
                            'resuelto' => 'estado-resuelto',
                            'cerrado' => 'estado-cerrado',
                        ][$exp->estado] ?? 'estado-pendiente';
                    @endphp

                    <span class="estado-badge {{ $estadoColor }}">
                        {{ strtoupper($exp->estado) }}
                    </span>

                </div>

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
        <div class="panel-card panel-info">
            <div class="panel-title">

                📋 Información General

            </div>

            <!-- 🔘 BOTÓN EDITAR -->
            <button onclick="activarEdicion()" class="bg-yellow-500 text-white px-3 py-1 rounded mb-3">
                ✏️ Editar
            </button>

            <!-- 👀 MODO VISTA -->
            <div id="modo-vista" style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">

                <p><strong>Expediente:</strong> {{ $expedienteSeleccionado->numero_expediente }}</p>
                <p><strong>Tipo:</strong> {{ $expedienteSeleccionado->tipo_tramite }}</p>

                <p><strong>Matrícula:</strong> {{ $expedienteSeleccionado->matricula }}</p>
                <p><strong>Sede:</strong> {{ $expedienteSeleccionado->sede }}</p>

                <p><strong>Cuantía:</strong> L {{ number_format($expedienteSeleccionado->cuantia, 2) }}</p>
                <p><strong>Asignado:</strong> {{ $expedienteSeleccionado->asignado ?? 'N/A' }}</p>
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
                        <label>Asignado</label>
                        <input type="text" name="asignado"
                            value="{{ $expedienteSeleccionado->asignado }}"
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
                    <div class="flex items-center gap-2 mt-2">

                        <input type="checkbox"
                            name="permite_edicion"
                            value="1"
                            class="w-4 h-4 accent-blue-600"
                            {{ $expedienteSeleccionado->permite_edicion ? 'checked' : '' }}>

                        <label class="text-sm text-gray-700 dark:text-gray-300">
                            Otorgar permisos de modificación
                        </label>

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

                    @if(auth()->user()->role === 'admin')

<button
    type="button"
    onclick="if(confirm('¿Está seguro que desea eliminar este expediente? Esta acción eliminará sujetos, documentos y movimientos asociados.')) document.getElementById('delete-expediente').submit();"
    class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded">

    🗑️ Eliminar Expediente

</button>





@endif

                </div>

            </form>

            <form id="delete-expediente"
    method="POST"
    action="{{ route('expedientes.destroy', $expedienteSeleccionado->id) }}"
    style="display:none;">

    @csrf
    @method('DELETE')
    

</form>

        </div>


        <!-- 🔄 CAMBIAR ESTADO -->
        <div class="panel-card panel-estado">
            <div class="panel-title">

                🔄 Estado del Expediente

            </div>

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


        <div class="panel-grid">
            <!-- 👥 SUJETOS -->

            <div class="panel-card panel-sujetos scroll-panel">

                <div class="panel-title">

                    👥 Sujetos

                </div>
                <form method="POST"
                    action="{{ route('expedientes.sujetos.store', $expedienteSeleccionado->id) }}">

                    @csrf

                    <div class="form-grid">

                        <select name="tipo"
                            class="border p-2 rounded w-full 
                bg-white text-black 
                dark:bg-gray-700 dark:text-white dark:border-gray-600">

                            <option value="sujeto activo">Sujeto Activo</option>
                            <option value="sujeto pasivo">Sujeto Pasivo</option>
                            <option value="apoderado activo">Apoderado Activo</option>
                            <option value="apoderado pasivo">Apoderado Pasivo</option>

                        </select>

                        <input type="text"
                            name="nombre"
                            placeholder="Nombre"
                            class="border p-2 rounded w-full 
                bg-white text-black 
                dark:bg-gray-700 dark:text-white dark:border-gray-600">

                        <input type="text"
                            name="identificacion"
                            placeholder="Identificación"
                            class="border p-2 rounded w-full 
                bg-white text-black 
                dark:bg-gray-700 dark:text-white dark:border-gray-600">

                        <input type="text"
                            name="cah"
                            placeholder="CAH"
                            class="border p-2 rounded w-full 
                bg-white text-black 
                dark:bg-gray-700 dark:text-white dark:border-gray-600">

                    </div>

                    <button class="btn mt-2">
                        Guardar
                    </button>

                </form>

                <br>





                {{-- LISTA SUJETOS --}}
                @foreach ($expedienteSeleccionado->sujetos as $sujeto)

                <div class="bg-gray-50 dark:bg-gray-700
        text-gray-900 dark:text-gray-100
        p-4 rounded mb-3 shadow-sm border
        border-gray-200 dark:border-gray-600">

                    {{-- INFO --}}
                    <div class="mb-2">

                        <strong class="text-blue-600 dark:text-blue-400">
                            {{ strtoupper($sujeto->tipo) }}
                        </strong>

                        <br>

                        <span class="font-semibold">
                            {{ $sujeto->nombre }}
                        </span>

                        <br>

                        <small class="text-gray-500 dark:text-gray-300">
                            ID: {{ $sujeto->identificacion ?? '—' }} |
                            CAH: {{ $sujeto->cah ?? '—' }}
                        </small>

                    </div>


                    {{-- BOTONES --}}
                    @if($puedeEditar)

                    <div class="mt-3 flex gap-2">

                        {{-- EDITAR --}}
                        <button type="button"
                            onclick="toggleEdit('{{ $sujeto->id }}')"
                            class="inline-flex items-center
                bg-yellow-500 hover:bg-yellow-600
                text-white px-2 py-1 rounded text-sm
                w-auto">

                            ✏️ Editar

                        </button>


                        {{-- SUBIR DOC --}}
                        <button type="button"
                            onclick="toggleForm('form-editar-sujeto-{{ $sujeto->id }}')"
                            class="inline-flex items-center
                bg-green-500 hover:bg-green-600
                text-white px-2 py-1 rounded text-sm
                w-auto">

                            +📄

                        </button>

                    </div>

                    @endif



                    {{-- FORM EDITAR --}}
                    @if($puedeEditar)

                    <div id="edit-{{ $sujeto->id }}"
                        class="hidden mt-3">

                        <form method="POST"
                            action="{{ route('sujetos.update', $sujeto->id) }}">

                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-2 gap-2">

                                <input type="text"
                                    name="nombre"
                                    value="{{ $sujeto->nombre }}"
                                    class="border p-2 rounded w-full
                        bg-white text-black
                        dark:bg-gray-700 dark:text-white dark:border-gray-600">

                                <input type="text"
                                    name="identificacion"
                                    value="{{ $sujeto->identificacion }}"
                                    class="border p-2 rounded w-full
                        bg-white text-black
                        dark:bg-gray-700 dark:text-white dark:border-gray-600">

                                <input type="text"
                                    name="cah"
                                    value="{{ $sujeto->cah }}"
                                    class="border p-2 rounded w-full
                        bg-white text-black
                        dark:bg-gray-700 dark:text-white dark:border-gray-600">

                                <select name="tipo"
                                    class="border p-2 rounded w-full
                        bg-white text-black
                        dark:bg-gray-700 dark:text-white dark:border-gray-600">

                                    <option value="sujeto activo"
                                        {{ $sujeto->tipo == 'sujeto activo' ? 'selected' : '' }}>
                                        Sujeto Activo
                                    </option>

                                    <option value="sujeto pasivo"
                                        {{ $sujeto->tipo == 'sujeto pasivo' ? 'selected' : '' }}>
                                        Sujeto Pasivo
                                    </option>

                                    <option value="apoderado activo"
                                        {{ $sujeto->tipo == 'apoderado activo' ? 'selected' : '' }}>
                                        Apoderado Activo
                                    </option>

                                    <option value="apoderado pasivo"
                                        {{ $sujeto->tipo == 'apoderado pasivo' ? 'selected' : '' }}>
                                        Apoderado Pasivo
                                    </option>

                                </select>

                            </div>

                            <div class="flex gap-2 mt-2">

                                <button class="bg-blue-500 hover:bg-blue-600
        text-white px-3 py-1 rounded text-sm">

                                    Guardar Cambios

                                </button>

                                <button type="button"
                                    onclick="if(confirm('¿Está seguro que desea eliminar este registro?')) document.getElementById('delete-sujeto-{{ $sujeto->id }}').submit();"
                                    class="bg-red-500 hover:bg-red-600
        text-white px-3 py-1 rounded text-sm">

                                    🗑️ Eliminar Sujeto

                                </button>

                            </div>

                        </form>

                    </div>

                    @endif



                    {{-- DOCUMENTOS --}}
                    <div class="flex flex-wrap items-center gap-2 mt-3">

                        @foreach ($sujeto->documentos as $doc)

                        <div class="flex items-center gap-1">

                            <a href="{{ route('documentos.archivo', $doc->id) }}"
                                target="_blank"
                                class="bg-gray-200 dark:bg-gray-600
        text-gray-800 dark:text-white
        px-2 py-1 rounded text-sm
        hover:bg-gray-300 dark:hover:bg-gray-500">

                                📄 {{ $doc->titulo }}

                            </a>

                            @if($puedeEditar)

                            <form method="POST"
                                action="{{ route('documentos.destroy', $doc->id) }}"
                                onsubmit="return confirm('¿Eliminar documento?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600
            text-white px-2 py-1 rounded text-sm">

                                    🗑️

                                </button>

                            </form>

                            <form id="delete-sujeto-{{ $sujeto->id }}"
                                method="POST"
                                action="{{ route('sujetos.destroy', $sujeto->id) }}"
                                style="display:none;">

                                @csrf
                                @method('DELETE')

                            </form>


                            @endif

                        </div>

                        @endforeach

                    </div>



                    {{-- FORM SUBIR DOC --}}
                    @if($puedeEditar)

                    <div id="form-{{ $sujeto->id }}"
                        class="hidden mt-3">

                        <form method="POST"
                            action="{{ route('expedientes.documentos.store', $expedienteSeleccionado->id) }}"
                            enctype="multipart/form-data"
                            class="flex gap-2 items-center flex-wrap">

                            @csrf

                            <input type="hidden"
                                name="sujeto_id"
                                value="{{ $sujeto->id }}">

                            <input type="text"
                                name="titulo"
                                placeholder="Título"
                                class="border p-2 rounded text-sm
                    bg-white text-black
                    dark:bg-gray-700 dark:text-white dark:border-gray-600">

                            <input type="file"
                                name="archivo"
                                class="text-sm text-gray-700 dark:text-gray-200">

                            <button class="bg-blue-500 hover:bg-blue-600
                    text-white px-2 py-1 rounded text-sm">

                                Subir

                            </button>

                        </form>

                    </div>

                    @endif

                </div>

                @endforeach

            </div>

            <!-- 📎 DOCUMENTOS -->
            <div class="panel-card panel-documentos scroll-panel">

                <div class="panel-title">
                    📄 Procuración y Documentos
                </div>

                <form method="POST"
                    action="{{ route('expedientes.documentos.store', $expedienteSeleccionado->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <input type="date" name="fecha" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white">
                        <input type="text" name="titulo" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white" placeholder="Título">
                        <input type="file" name="archivo" class="border p-2 rounded w-full bg-white text-black dark:bg-gray-700 dark:text-white">
                        <div style="grid-column: 1 / -1; width:100%;">
                            <label class="text-sm text-gray-600 dark:text-gray-300">
                                Descripción
                            </label>

                            <textarea name="descripcion"
                                rows="3"
                                class="border p-2 rounded w-full
                                        bg-white text-black 
                                        dark:bg-gray-700 dark:text-white dark:border-gray-600
                                        resize-none focus:ring-2 focus:ring-blue-400"
                                placeholder="Detalle..."></textarea>
                        </div>
                    </div>

                    <button class="btn">Guardar</button>
                </form>

                <br>
                @foreach ($expedienteSeleccionado->documentos->whereNull('sujeto_id')->sortByDesc('fecha') as $doc)

                <div class="list-item bg-white text-black dark:bg-gray-700 dark:text-white p-2 rounded mb-2">

                    <strong>{{ $doc->titulo }}</strong><br>
                    <small>{{ $doc->fecha }}</small><br>
                    <p>{{ $doc->descripcion }}</p>

                    @if ($doc->archivo)
                    <a href="{{ route('documentos.archivo', $doc->id) }}" target="_blank">
                        Ver Documento 📄
                    </a>
                    @else
                    <span class="text-gray-400">Sin archivo</span>
                    @endif

                    @if($puedeEditar)

                    <div class="mt-2 flex gap-2">

                        <button type="button"

                            onclick="toggleForm('form-edit-doc-{{ $doc->id }}')"

                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-sm">

                            ✏️ Editar

                        </button>

                    </div>

                    <div id="form-edit-doc-{{ $doc->id }}" class="hidden mt-3">

                        <form method="POST"
                            action="{{ route('documentos.update', $doc->id) }}"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <input type="date"
                                name="fecha"
                                value="{{ $doc->fecha }}"
                                class="border p-2 rounded w-full mb-2 bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600">

                            <input type="text"
                                name="titulo"
                                value="{{ $doc->titulo }}"
                                class="border p-2 rounded w-full mb-2 bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600">

                            <textarea name="descripcion"
                                class="border p-2 rounded w-full mb-2 bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ $doc->descripcion }}</textarea>

                            <input type="file"
                                name="archivo"
                                class="border p-2 rounded w-full mb-2 bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            <div class="flex gap-2">

                                <button class="bg-blue-500 text-white px-3 py-1 rounded">
                                    Guardar Cambios
                                </button>

                                <button type="button"
                                    onclick="if(confirm('¿Está seguro que desea eliminar este registro?')) document.getElementById('delete-doc-{{ $doc->id }}').submit();"
                                    class="bg-red-500 text-white px-3 py-1 rounded">

                                    🗑️ Eliminar

                                </button>

                            </div>

                        </form>

                        <form id="delete-doc-{{ $doc->id }}"
                            method="POST"
                            action="{{ route('documentos.destroy', $doc->id) }}"
                            style="display:none;">

                            @csrf
                            @method('DELETE')

                        </form>

                    </div>

                    @endif

                </div>

                @endforeach
            </div>

        </div>


        <!-- 📜 MOVIMIENTOS -->
        <div class="panel-card panel-movimientos scroll-panel">

            <div class="panel-title">

                📜 Movimientos

            </div>

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
                <a href="{{ route('movimientos.archivo', $mov->id) }}" target="_blank">
                    Ver PDF 📄
                </a>
                @endif

                @if($puedeEditar)

                <div class="mt-2">

                    <button type="button"
                        onclick="toggleForm('form-edit-mov-{{ $mov->id }}')"
                        class="bg-yellow-500 hover:bg-yellow-600
            text-white px-2 py-1 rounded text-sm">

                        ✏️ Editar

                    </button>

                </div>

                <div id="form-edit-mov-{{ $mov->id }}"
                    class="hidden mt-3 p-3 rounded border
        border-gray-200 dark:border-gray-600
        bg-gray-50 dark:bg-gray-800">

                    <form method="POST"
                        action="{{ route('movimientos.update', $mov->id) }}"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <input type="date"
                            name="fecha"
                            value="{{ $mov->fecha }}"
                            class="border p-2 rounded w-full mb-2
                bg-white text-black
                dark:bg-gray-700 dark:text-white dark:border-gray-600">

                        <textarea
                            name="descripcion"
                            class="border p-2 rounded w-full mb-2
                bg-white text-black
                dark:bg-gray-700 dark:text-white dark:border-gray-600">{{ $mov->descripcion }}</textarea>

                        <input type="file"
                            name="archivo"
                            class="border p-2 rounded w-full mb-2
                bg-white text-black
                dark:bg-gray-700 dark:text-white dark:border-gray-600">

                        <div class="flex gap-2">

                            <button class="bg-blue-500 text-white px-3 py-1 rounded">
                                Guardar Cambios
                            </button>

                            <button type="button"
                                onclick="if(confirm('¿Está seguro que desea eliminar este registro?')) document.getElementById('delete-mov-{{ $mov->id }}').submit();"
                                class="bg-red-500 text-white px-3 py-1 rounded">

                                🗑️ Eliminar

                            </button>

                        </div>

                    </form>

                    <form id="delete-mov-{{ $mov->id }}"
                        method="POST"
                        action="{{ route('movimientos.destroy', $mov->id) }}"
                        style="display:none;">

                        @csrf
                        @method('DELETE')

                    </form>

                </div>

                @endif

            </div>

            @endforeach
        </div>



        @else
        <div class="panel-card panel-info">
            <h3>Selecciona un expediente</h3>
        </div>
        @endif

    </div>
</div>

</div>

<br>
<br>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const buscador =
        document.getElementById('buscarExpediente');

    buscador.addEventListener('keyup', function(){

        const texto =
            this.value.toLowerCase();

        document.querySelectorAll('.expediente-card')
            .forEach(card => {

                const contenido =
                    card.innerText.toLowerCase();

                card.parentElement.style.display =
                    contenido.includes(texto)
                    ? 'block'
                    : 'none';

            });

    });

});

</script>

@endsection