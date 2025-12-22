<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar la lista de vigías
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Mostrar el formulario de invocación
    public function create()
    {
        return view('users.create');
    }

    // Guardar el nuevo guerrero en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', '¡Runa sincronizada! El guerrero ha sido invocado con éxito.');
    }

    // Formulario para editar un guerrero existente
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Actualizar datos del guerrero
    public function update(Request $request, User $user)
    {
        $user->update($request->only('name', 'email'));
        return redirect()->route('users.index')
            ->with('success', 'Las runas del guerrero han sido actualizadas.');
    }

    // Eliminar (Banear) un guerrero
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('error', 'El guerrero ha sido enviado al Helheim (Eliminado).');
    }
}