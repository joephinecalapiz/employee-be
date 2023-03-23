<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\User;


use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return Employee::get();
        // $employees = Employee::all();
        // return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $input = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $employee = new Employee();
        $employee->user_id = auth()->user()->id;
        $employee->first_name = $input['first_name'];
        $employee->last_name = $input['last_name'];
        $employee->save();
        return response()->json($employee);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $userId)
    {
        $getValue = Employee::where('user_id',$userId)->get();

        return response([
            'data' => $getValue
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        // $employee->first_name = $input['first_name'];
        // $employee->last_name = $input['last_name'];
        // $employee->save();
        // return response()->json($employee);

        try{

            $employee = Employee::findOrFail($id);
            $employee->update($request->all());

            return response("Successfully edited", 200);

        }catch(Exception $e){
            return response($e->getString(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json($employee->delete());
    }
}
