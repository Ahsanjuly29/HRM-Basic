<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('departments.index', [
            'departments' => Department::paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name'
        ]);

        // NEW OR UPDATE?
        if ($request->department_id) {
            $dept = Department::find($request->department_id);
            $dept->update($request->all());
        } else {
            Department::create($request->all());
        }

        return redirect()->route('departments.index')->with('success', 'Department saved.');
    }

    public function show(Department $department)
    {
        return response()->json([
            'department' => $department
        ]);
    }

    public function edit(Department $department)
    {
        return response()->json([
            'department' => $department
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted.');
    }
}
