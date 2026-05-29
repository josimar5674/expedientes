<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Movimiento;
use App\Models\Documento;
use App\Models\Sujeto;
use Illuminate\Support\Facades\Storage;

class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    if (Auth::user()->role === 'admin') {
        // Admin ve todos
        $expedientes = Expediente::with('user')
            ->latest()
            ->get();
    } else {
        // Usuario normal solo los suyos
        $expedientes = Expediente::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    return view('expedientes.index', [
        'expedientes' => $expedientes,
        'expedienteSeleccionado' => null
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expedientes.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
    'numero_expediente' => 'required|unique:expedientes,numero_expediente',
    'tipo_tramite' => 'required',
], [
    'numero_expediente.unique' => 'Este número de expediente ya existe ⚠️',
]);

    Expediente::create([
     'user_id' => Auth::id(),
    'numero_expediente' => $request->numero_expediente,
    'tipo_tramite' => $request->tipo_tramite,
    'matricula' => $request->matricula,
    'sede' => $request->sede,
    'asignado' => $request->asignado,
    'pretension_principal' => $request->pretension_principal,
    'cuantia' => $request->cuantia,
    'fecha_presentacion' => $request->fecha_presentacion,
    'descripcion_proceso' => $request->descripcion_proceso,
]);

  return redirect()
    ->route('expedientes.index')
    ->with('success', 'Expediente creado correctamente');
    }

    /**
     * Display the specified resource.
     */
public function show(Expediente $expediente)
{
    // 🔹 Lista SOLO del usuario logueado
  if (Auth::user()->role === 'admin') {
    $expedientes = Expediente::with('user')
        ->latest()
        ->get();
} else {
    $expedientes = Expediente::with('user')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();
}

    // 🔥 Seguridad: validar que el expediente sea del usuario
 if (Auth::user()->role !== 'admin' && $expediente->user_id !== Auth::id()) {
    abort(403);
}

    // 🔹 Cargar relaciones
    $expediente->load([
        'user',
        'sujetos',
        'movimientos',
        'documentos'
    ]);

   return view('expedientes.index', [
    'expedientes' => $expedientes,
    'expedienteSeleccionado' => $expediente,
    'usuarios' => Auth::user()->role === 'admin' ? User::all() : []
]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expediente $expediente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Expediente $expediente)
{
    // 🔒 Admin o dueño del expediente
    $puedeEditar =
        Auth::user()->role === 'admin'
        || $expediente->user_id === Auth::id();

    if (!$puedeEditar) {
        abort(403);
    }

    // ✅ Validación
    $request->validate([
        'tipo_tramite' => 'required',
        'matricula' => 'nullable|string|max:255',
        'sede' => 'nullable|string|max:255',
        'pretension_principal' => 'nullable|string',
        'cuantia' => 'nullable|numeric',
        'descripcion_proceso' => 'nullable|string',
    ]);

    // 💾 Actualización
    $expediente->update([
        'tipo_tramite' => $request->tipo_tramite,
        'matricula' => $request->matricula,
        'sede' => $request->sede,
        'asignado' => $request->asignado,
        'pretension_principal' => $request->pretension_principal,
        'cuantia' => $request->cuantia,
        'descripcion_proceso' => $request->descripcion_proceso,
        'user_id' => $request->user_id ?? $expediente->user_id,
        'permite_edicion' => $request->has('permite_edicion'),
    ]);

    return back()->with('success', 'Expediente actualizado correctamente');
}

    /**
     * Remove the specified resource from storage.
     */


public function destroy(Expediente $expediente)

{

 
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    // 📄 Eliminar archivos de documentos
    foreach ($expediente->documentos as $doc) {

        if ($doc->archivo && Storage::disk('public')->exists($doc->archivo)) {
            Storage::disk('public')->delete($doc->archivo);
        }
    }

    // 📜 Eliminar archivos de movimientos
    foreach ($expediente->movimientos as $mov) {

        if ($mov->archivo && Storage::disk('public')->exists($mov->archivo)) {
            Storage::disk('public')->delete($mov->archivo);
        }
    }

    // 🗑️ Eliminar expediente
    // Las relaciones sujetes/documentos/movimientos
    // se eliminarán automáticamente por cascade
    $expediente->delete();

    return redirect()
        ->route('expedientes.index')
        ->with('success', 'Expediente eliminado correctamente');
}


public function storeSujeto(Request $request, Expediente $expediente)
{
    $puedeCrear =
        Auth::user()->role === 'admin'
        || $expediente->user_id === Auth::id();

    if (!$puedeCrear) {
        abort(403);
    }

    $request->validate([
        'tipo' => 'required',
        'nombre' => 'required',
    ]);

    $expediente->sujetos()->create([
        'tipo' => $request->tipo,
        'nombre' => $request->nombre,
        'identificacion' => $request->identificacion,
        'cah' => $request->cah,
    ]);

    return back()->with('success', 'Sujeto agregado');
}



public function storeMovimiento(Request $request, Expediente $expediente)
{
    $request->validate([
        'fecha' => 'required|date',
        'descripcion' => 'required',
        'archivo' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    $rutaArchivo = null;

    if ($request->hasFile('archivo')) {
        $rutaArchivo = $request->file('archivo')->store('movimientos', 'public');
    }

    $expediente->movimientos()->create([
        'fecha' => $request->fecha,
        'descripcion' => $request->descripcion,
        'archivo' => $rutaArchivo,
    ]);

    return back()->with('success', 'Movimiento agregado');
}
public function storeDocumento(Request $request, Expediente $expediente)
{
    $request->validate([
        'titulo' => 'required',
        'archivo' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    $rutaArchivo = null;

    if ($request->hasFile('archivo')) {
        $rutaArchivo = $request->file('archivo')->store('documentos', 'public');
    }

    $expediente->documentos()->create([
        'fecha' => $request->fecha,
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'archivo' => $rutaArchivo,
        'sujeto_id' => $request->sujeto_id ?? null,
    ]);

    return back()->with('success', 'Documento agregado');
}

public function updateEstado(Request $request, Expediente $expediente)
{
    $request->validate([
        'estado' => 'required'
    ]);

    $expediente->update([
        'estado' => $request->estado
    ]);

    return back()->with('success', 'Estado actualizado');
}


public function verArchivo($id)
{
    $movimiento = Movimiento::findOrFail($id);

    if (!$movimiento->archivo) {
        abort(404);
    }

    $path = storage_path('app/public/' . $movimiento->archivo);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
}



public function verDocumento($id)
{
    $doc = Documento::findOrFail($id);

    if (!$doc->archivo) {
        abort(404);
    }

    $path = storage_path('app/public/' . $doc->archivo);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
}


/* ======================================
   ACTUALIZAR SUJETO
====================================== */

public function updateSujeto(Request $request, $id)
{
    $sujeto = \App\Models\Sujeto::findOrFail($id);

    $expediente = $sujeto->expediente;

    $puedeEditar =
        Auth::user()->role === 'admin'
        || (
            $expediente->user_id === Auth::id()
            && $expediente->permite_edicion
        );

    if (!$puedeEditar) {
        abort(403);
    }

    $request->validate([
        'tipo' => 'required',
        'nombre' => 'required',
    ]);

    $sujeto->update([
        'tipo' => $request->tipo,
        'nombre' => $request->nombre,
        'identificacion' => $request->identificacion,
        'cah' => $request->cah,
    ]);

    return back()->with('success', 'Sujeto actualizado');
}


public function destroyDocumento($id)
{
    $doc = Documento::findOrFail($id);

    $expediente = $doc->expediente;

    $puedeEditar =
        Auth::user()->role === 'admin'
        || (
            $expediente->user_id === Auth::id()
            && $expediente->permite_edicion
        );

    if (!$puedeEditar) {
        abort(403);
    }

    // borrar archivo físico
    if ($doc->archivo) {

        $path = storage_path('app/public/' . $doc->archivo);

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $doc->delete();

    return back()->with('success', 'Documento eliminado');
}

public function destroySujeto($id)
{
    $sujeto = Sujeto::findOrFail($id);

    $expediente = $sujeto->expediente;

    $puedeEditar =
        Auth::user()->role === 'admin'
        || (
            $expediente->user_id === Auth::id()
            && $expediente->permite_edicion
        );

    if (!$puedeEditar) {
        abort(403);
    }

    foreach ($sujeto->documentos as $doc) {

        // eliminar archivo físico
        if ($doc->archivo) {

            $path = storage_path('app/public/' . $doc->archivo);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        // eliminar registro
        $doc->delete();
    }

    $sujeto->delete();

    return back()->with('success', 'Sujeto eliminado correctamente');
}


public function updateDocumento(Request $request, Documento $documento)
{
    $expediente = $documento->expediente;

    $puedeEditar =
        Auth::user()->role === 'admin'
        || (
            $expediente->user_id === Auth::id()
            && $expediente->permite_edicion
        );

    if (!$puedeEditar) {
        abort(403);
    }

    $request->validate([
        'titulo' => 'required'
    ]);

    // Si subieron un archivo nuevo
    if ($request->hasFile('archivo')) {

        if ($documento->archivo) {

            $path = storage_path('app/public/' . $documento->archivo);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $documento->archivo = $request->file('archivo')
            ->store('documentos', 'public');
    }

    $documento->fecha = $request->fecha;
    $documento->titulo = $request->titulo;
    $documento->descripcion = $request->descripcion;

    $documento->save();

    return back()->with('success', 'Documento actualizado correctamente');
}

public function updateMovimiento(Request $request, Movimiento $movimiento)
{
    $expediente = $movimiento->expediente;

    $puedeEditar =
        Auth::user()->role === 'admin'
        || (
            $expediente->user_id === Auth::id()
            && $expediente->permite_edicion
        );

    if (!$puedeEditar) {
        abort(403);
    }

    if ($request->hasFile('archivo')) {

        if ($movimiento->archivo) {

            $path = storage_path('app/public/' . $movimiento->archivo);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $movimiento->archivo = $request->file('archivo')
            ->store('movimientos', 'public');
    }

    $movimiento->fecha = $request->fecha;
    $movimiento->descripcion = $request->descripcion;

    $movimiento->save();

    return back()->with('success', 'Movimiento actualizado');
}

public function destroyMovimiento(Movimiento $movimiento)
{
    $expediente = $movimiento->expediente;

    $puedeEditar =
        Auth::user()->role === 'admin'
        || (
            $expediente->user_id === Auth::id()
            && $expediente->permite_edicion
        );

    if (!$puedeEditar) {
        abort(403);
    }

    if ($movimiento->archivo) {

        $path = storage_path('app/public/' . $movimiento->archivo);

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $movimiento->delete();

    return back()->with('success', 'Movimiento eliminado');
}


}


