@extends('layouts.app')

@section('content')

<style>

.form-card{
    max-width:1100px;
    margin:auto;

    background:white;
    border:1px solid #e5e7eb;
    border-radius:16px;

    padding:24px;

    box-shadow:
        0 1px 3px rgba(0,0,0,.08),
        0 8px 24px rgba(0,0,0,.05);
}

.dark .form-card{
    background:#1f2937;
    border-color:#374151;
}

.form-title{
    font-size:24px;
    font-weight:700;

    margin-bottom:20px;
    padding-bottom:12px;

    border-bottom:2px solid #e5e7eb;

    color:#1f2937;
}

.dark .form-title{
    color:white;
    border-color:#374151;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group-full{
    grid-column:1 / -1;
}

.form-label{
    margin-bottom:6px;
    font-size:14px;
    font-weight:600;

    color:#374151;
}

.dark .form-label{
    color:#d1d5db;
}

.form-input{
    width:100%;
    padding:10px 12px;

    border:1px solid #d1d5db;
    border-radius:10px;

    background:white;
    color:#111827;

    transition:.2s;
}

.form-input:focus{
    outline:none;
    border-color:#0A84FF;
    box-shadow:0 0 0 3px rgba(10,132,255,.15);
}

.dark .form-input{
    background:#374151;
    color:white;
    border-color:#4b5563;
}

.dark .form-input::placeholder{
    color:#9ca3af;
}

.form-actions{
    margin-top:25px;
    display:flex;
    gap:12px;
}

.btn-back{
    background:#6b7280;
    color:white;

    padding:10px 18px;
    border-radius:10px;

    text-decoration:none;
}

.btn-back:hover{
    background:#4b5563;
}

.btn-save{
    background:#0A84FF;
    color:white;

    padding:10px 18px;
    border-radius:10px;

    border:none;
    cursor:pointer;
}

.btn-save:hover{
    background:#0071e3;
}

.error-text{
    color:#dc2626;
    margin-top:4px;
    font-size:13px;
}

.dark .error-text{
    color:#f87171;
}

.success-box{
    max-width:1100px;
    margin:0 auto 20px auto;

    background:#dcfce7;
    color:#166534;

    border:1px solid #86efac;

    padding:12px 15px;
    border-radius:12px;
}

.dark .success-box{
    background:#14532d;
    color:#bbf7d0;
    border-color:#166534;
}

</style>

@if(session('success'))
<div class="success-box">
    {{ session('success') }}
</div>
@endif

<div class="p-6">

    <div class="form-card">

        <div class="form-title">
            📂 Crear Expediente
        </div>

        <form method="POST" action="{{ route('expedientes.store') }}">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">
                        Número de Expediente
                    </label>

                    <input
                        type="text"
                        name="numero_expediente"
                        value="{{ old('numero_expediente') }}"
                        class="form-input">

                    @error('numero_expediente')
                        <small class="error-text">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Tipo de Trámite
                    </label>

                    <select
                        name="tipo_tramite"
                        class="form-input">

                        <option value="">
                            Seleccione una opción
                        </option>

                        <option value="Judicial"
                            {{ old('tipo_tramite') == 'Judicial' ? 'selected' : '' }}>
                            Judicial
                        </option>

                        <option value="Administrativo"
                            {{ old('tipo_tramite') == 'Administrativo' ? 'selected' : '' }}>
                            Administrativo
                        </option>

                    </select>

                    @error('tipo_tramite')
                        <small class="error-text">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Matrícula
                    </label>

                    <input
                        type="text"
                        name="matricula"
                        value="{{ old('matricula') }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Sede
                    </label>

                    <input
                        type="text"
                        name="sede"
                        value="{{ old('sede') }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Asignado
                    </label>

                    <input
                        type="text"
                        name="asignado"
                        value="{{ old('asignado') }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Cuantía
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="cuantia"
                        value="{{ old('cuantia') }}"
                        class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Fecha de Presentación
                    </label>

                    <input
                        type="date"
                        name="fecha_presentacion"
                        value="{{ old('fecha_presentacion') }}"
                        class="form-input">
                </div>

                <div class="form-group-full">
                    <label class="form-label">
                        Pretensión Principal
                    </label>

                    <textarea
                        name="pretension_principal"
                        rows="4"
                        class="form-input">{{ old('pretension_principal') }}</textarea>
                </div>

                <div class="form-group-full">
                    <label class="form-label">
                        Descripción del Proceso
                    </label>

                    <textarea
                        name="descripcion_proceso"
                        rows="5"
                        class="form-input">{{ old('descripcion_proceso') }}</textarea>
                </div>

            </div>

            <div class="form-actions">

                <a href="{{ route('expedientes.index') }}"
                    class="btn-back">

                    ← Volver

                </a>

                <button class="btn-save">

                    💾 Guardar Expediente

                </button>

            </div>

        </form>

    </div>

</div>

@endsection