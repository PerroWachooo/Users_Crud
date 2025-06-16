<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.list'); // Crearemos esta vista Blade
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' buscará 'password_confirmation'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // 422 Unprocessable Entity
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'Usuario creado exitosamente!', 'user' => $user], 201); // 201 Created
        } catch (\Exception $e) {
            // Log::error('Error creating user: '.$e->getMessage()); // Opcional: loguear el error
            return response()->json(['message' => 'Error al crear el usuario en el servidor.'], 500); // 500 Internal Server Error
        }
    }

    // Devuelve la lista de usuarios en formato JSON
    public function getUsersJson()
    {
        //Mostrar la vista de los usuarios
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {

        $user = User::findOrFail($id->id); // Buscar el usuario por ID
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404); // 404 Not Found
        }
        // Mostrar la vista del usuario
        return view('users.show', compact('user')); // Crearemos esta vista Blade
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]); // Crearemos esta vista Blade
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // 'confirmed' buscará 'password_confirmation'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // 422 Unprocessable Entity
        }

        try {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json(['message' => 'Usuario actualizado exitosamente!', 'user' => $user], 200); // 200 OK
        } catch (\Exception $e) {
            // Log::error('Error updating user: '.$e->getMessage()); // Opcional: loguear el error
            return response()->json(['message' => 'Error al actualizar el usuario en el servidor.'], 500); // 500 Internal Server Error
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
