<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validation = $request->validate([
            "name" => "string"
        ]);

        if (array_key_exists("name", $validation)){
            $response = Department::whereLike("name", "%".$validation["name"]."%")->get();
        }else{
            $response = Department::paginate();
        }

        $response = $response->toResourceCollection();

        return response()->json(array("status" => 200, "response" => $response), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => "required|string"
        ]);

        $department = Department::firstOrCreate($validation);

        return response()->json(array("status" => 201, "response" => $department), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response()->json(array("status" => 200, "response" => $department), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validation = $request->validate([
            "name" => "required|string"
        ]);

        $department->update($validation);
        return response()->json(array("status" => 200, "response" => $department->fresh()), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(array("status" => 200, "response" => ["ok" => "Resource deleted"]), 200);
    }
}
