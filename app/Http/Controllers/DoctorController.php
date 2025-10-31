<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with("Department")->paginate()->toResourceCollection();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => "required|string|max:255",
            'email' => "required|string|unique:users,email",
            'password' => 'required|string|min:8|confirmed',
            "department" => 'exists:departments,name|string'
        ]);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => $validated["password"],
            "departmentId" => Department::where("name", $validated["department"])->first()->id
        ]);

        return response()->json(["status" => 201, "resource" => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $doctor)
    {
        return response()->json(array("status" => 200, "response" => $doctor), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $doctor)
    {
        $validated = $request->validate([
            'name' => "string|max:255",
            'email' => "string|unique:users,email",
            'password' => 'string|min:8|confirmed',
            "department" => 'exists:departments,name|string'
        ]);

        $doctor->update($validated);

        return response()->json(["status" => 200, "resource" => $doctor->fresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        $doctor->delete();
        return response()->json(["status" => 200, "resource" => $doctor]);
    }
}
