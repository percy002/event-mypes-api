<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Employee;
use App\Models\CompanyEvent;
use App\Models\CompanyEmployee;
class RegisterCompanyEvent extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // return response()->json(['message' => $request->all()], 422);
        try {
            $messages = [
                'required' => 'El campo :attribute es obligatorio.',
                'string' => 'El campo :attribute debe ser una cadena de texto.',
                'max' => 'El campo :attribute no debe exceder :max caracteres.',
                'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
                'unique' => 'El campo :attribute ya está en uso.',
                'size' => 'El campo :attribute debe tener exactamente :size caracteres.',
            ];
            //
            $validateData = $request->validate([
                'categoria' => 'required|string|max:255',
                'razon_social' => 'required|string|max:255',
                'nombre_comercial' => 'required|string|max:255',
                'ruc' => 'required|string|size:11|unique:companies,ruc',
                'direccion' => 'required|string|max:255',
                'email_empresa' => 'required|string|email|max:255|unique:companies,company_email',
                'nombre_representante' => 'required|string|max:255',
                'apellidos_representante' => 'required|string|max:255',
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'dni' => 'required|string|size:8|unique:employees,dni',
                'email_participante' => 'required|string|email|max:25,email',
                'celular' => 'required|string|max:20',
                'cargo' => 'required|string|max:255',
            ], $messages);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        try {
            DB::beginTransaction();
            $company = Company::create([
                'category' => $validateData['categoria'],
                'business_name' => $validateData['razon_social'],
                'trade_name' => $validateData['nombre_comercial'],
                'ruc' => $validateData['ruc'],
                'address' => $validateData['direccion'],
                'company_email' => $validateData['email_empresa'],
                'legal_representative_first_name' => $validateData['nombre_representante'],
                'legal_representative_last_name' => $validateData['apellidos_representante'],
            ]);
            $employee = Employee::create([
                'first_name' => $validateData['nombres'],
                'last_name' => $validateData['apellidos'],
                'dni' => $validateData['dni'],
                'email' => $validateData['email_participante'],
                'cell_phone' => $validateData['celular'],
            ]);
            $companyEmployee = CompanyEmployee::create([
                'company_id' => $company->id,
                'employee_id' => $employee->id,
                'position' => $validateData['cargo'],
            ]);
            $companyEvent = CompanyEvent::create([
                'company_id' => $company->id,
                'event_id' => 1,
                'qr_code' => 'MYPES'.$company->ruc.$employee->dni,
                'number_of_people' => 1,
                'check_in' => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar la empresa', 'error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Empresa registrada correctamente','id' => $company->id], 201);
        

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $company = Company::find($id);
        $employee = $company->employees()->first();

        return response()->json([
            'company' => $company,
            'employee' => $employee
        ]);
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

    public function encontrarEmpresa(string $ruc)
    {
        $company = Company::where('ruc', $ruc)->first();
        if ($company) {
            return response()->json(['message' => 'Empresa encontrada', 'id' => $company->id]);
        } else {
            return response()->json(['message' => 'Empresa no encontrada']);
        }
    }

    
}
