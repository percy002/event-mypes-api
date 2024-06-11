<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyEvent;
use App\Models\AttendanceRecord;

class AttendanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companies = AttendanceRecord::select('check_in','id','company_event_id')
        ->with('companyEvent.company')
        ->orderBy('check_in','desc')
        ->get();
        return response()->json(['empresas' => $companies]);
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function asistencia(string $qr_code)
    {
        //
        $companyEvent = CompanyEvent::where('qr_code', $qr_code)->first();
        if ($companyEvent) {
            $attendanceRecord = AttendanceRecord::where('company_event_id',$companyEvent->id)->first();

            if ($attendanceRecord) {
                return response()->json(['message' => 'Ya se registró la asistencia','status' => 2]);
            }else{
                $attendanceRecord = AttendanceRecord::create([
                    'company_event_id' => $companyEvent->id,
                    'check_in' => now(),
                ]);
                return response()->json(['message' => 'Asistencia registrada correctamente','status'=> 1]);
            }

        }
        return response()->json(['message' => 'No se encontró este QR', 'status' => 3]);

    }
}
