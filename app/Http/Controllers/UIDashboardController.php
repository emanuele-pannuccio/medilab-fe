<?php

namespace App\Http\Controllers;

use App\MedicalCaseStatus;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class UIDashboardController extends Controller
{

    public function index(Request $request){
        $departments = Department::all()->toResourceCollection();
        $patients = Patient::all();
        $doctors = User::all();


        $medical_cases = Report::with(['patient', 'doctor']);

        // 2. Applica i filtri in modo condizionale

        if ($request->filled('paziente')) {
            $medical_cases->where('patientId', $request->query('paziente'));
        }

        if ($request->filled('medico')) {
            $medical_cases->where('doctorId', $request->query('medico'));
        }

        // Filtro per Stato (colonna diretta sulla tabella 'reports')
        if ($request->filled('stato')) {
            $medical_cases->where('status', $request->query('stato'));
        }

        // Usiamo 'whereHas' per filtrare i Report basandoci su una proprietà del medico
        if ($request->filled('reparto')) {
            $medical_cases->whereHas('doctor', function ($doctorQuery) use ($request) {
                $doctorQuery->where('departmentId', $request->query('reparto'));
            });
        }

        $medical_cases->orderBy('hospitalization_date', 'desc');

        $medical_cases = $medical_cases->paginate(15);


        return view('dashboard')->with("data", [
            "reparto" => $departments,
            "paziente" => $patients,
            "stato" => array_column(MedicalCaseStatus::cases(), column_key: 'value'),
            "medico" => $doctors,
            "medical_cases" => $medical_cases,
            "all_medical_cases" => Report::all()
        ]);
    }

}
