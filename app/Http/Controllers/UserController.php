<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
  use App\Models\User;
   use Illuminate\Support\Facades\Hash;
     
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index()
{
    $users = User::all();
    return view('usuarios.index', compact('users'));
}

    /**
     * Show the form for creating a new resource.
     */
  public function create()
{
    return view('usuarios.create');
}

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('usuarios.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(User $usuario)
{
    return view('usuarios.edit', compact('usuario'));
}

    /**
     * Update the specified resource in storage.
     */


public function update(Request $request, User $usuario)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $usuario->id,
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ];

    // Solo actualizar password si viene lleno
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $usuario->update($data);

    return redirect()->route('usuarios.index')
        ->with('success', 'Usuario actualizado correctamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
