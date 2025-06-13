<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Importar Validator


class Controller 
{
    // Muestra el formulario de registro
    public function create()
    {
        return view('users.create');
    }
    // Muestra la página con la lista de usuarios (que usará Vue)
    public function showUserListPage()
    {
        return view('users.list'); // Crearemos esta vista Blade
    }


    // Guarda los datos del formulario
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
}
