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
        
        $users = User::where('asistencia', '1')->get();
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
        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no debe exceder los :max caracteres.',
            'size' => 'El campo :attribute debe tener :size caracteres.',
            'unique' => 'El :attribute ya está en uso.',
            'email' => 'El campo :attribute debe ser un correo válido.'
        ];
        
        try {
            $request->validate([
                'categoria' => 'required|string|max:50',
                'razon_social' => 'required|string|max:255',
                'nombre_comercial' => 'required|string|max:255',
                'ruc' => 'required|string|max:255|unique:users',
                'direccion' => 'required|string',
                'email_empresa' => 'required|email',
                'nombre_representante' => 'required|string|max:100',
                'apellidos_representante' => 'required|string|max:100',
                'nombres' => 'required|string',
                'apellidos' => 'required|string|max:100',
                'dni' => 'required|string|size:8|unique:users',
                'cargo' => 'required|max:50',
                'email_participante' => 'required|email|unique:users',
                'celular' => 'required|string|max:20',
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }   
        
        $user = User::create([
            'categoria' => $request->categoria,
            'razon_social' => $request->razon_social,
            'nombre_comercial' => $request->nombre_comercial,
            'ruc' => $request->ruc,
            'direccion' => $request->direccion,
            'email_empresa' => $request->email_empresa,
            'nombre_representante' => $request->nombre_representante,
            'apellidos_representante' => $request->apellidos_representante,
        
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'cargo' => $request->cargo,
            'email' => $request->email,
            'rol' => 'user',
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
        $users = User::where('asistencia','1');
        return response()->json(['users' => $users]);
    }

    
}
