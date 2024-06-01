<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'dni' => 'required|string|size:8|unique:users',
                'gerencia' => 'required|string|max:100',
                'cargo' => 'required|max:50',
                'genero' => 'required|string|max:50',
                'rol' => 'string|max:255',
            ], [
                'nombres.required' => 'El campo nombres es obligatorio.',
                'nombres.max' => 'El campo nombres no debe exceder los 100 caracteres.',
                'apellidos.required' => 'El campo apellidos es obligatorio.',
                'apellidos.max' => 'El campo apellidos no debe exceder los 100 caracteres.',
                'dni.required' => 'El campo DNI es obligatorio.',
                'dni.size' => 'El campo DNI debe tener 8 caracteres.',
                'dni.unique' => 'El DNI ya está en uso.',
                'gerencia.required' => 'El campo gerencia es obligatorio.',
                'gerencia.max' => 'El campo gerencia no debe exceder los 100 caracteres.',
                'cargo.required' => 'El campo cargo es obligatorio.',
                'cargo.max' => 'El campo cargo no debe exceder los 50 caracteres.',
                'genero.required' => 'El campo género es obligatorio.',
                'genero.max' => 'El campo género no debe exceder los 50 caracteres.',
                'rol.max' => 'El campo rol no debe exceder los 255 caracteres.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }   
        
        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'gerencia' => $request->gerencia,
            'cargo' => $request->cargo,
            'genero' => $request->genero,
            'email' => $request->email,
            'rol' => $request->rol ?? 'user',
            'password' => Hash::make($request->password),
        ]);
        //loguear al usuario
        // Auth::login($user);

        // Return a JSON response with a success message
        return response()->json(['message' => 'Persona registrada correctamente', 'id' => $user->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function asistencia(string $dni)
    {
        $user = User::where('dni', $dni)->first();

        if ($user) {
            if ($user->asistencia == 1) {
                return response()->json(['message' => 'Usuario ya fue registrado']);
            }

            $user->update(['asistencia' => 1]);
            return response()->json(['message' => 'Asistencia registrada correctamente', 'user' => $user]);
        } else {
            return response()->json(['message' => 'Persona no encontrada']);
        }
    }
    public function encontrar(string $dni)
    {
        $user = User::where('dni', $dni)->first();

        if ($user) {
            return response()->json(['message' => 'Persona encontrada', 'user' => $user]);
        } else {
            return response()->json(['message' => 'Persona no encontrada']);
        }
    }

    public function list()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    
}
