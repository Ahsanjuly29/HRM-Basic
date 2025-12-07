<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Skill;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $employees = Employee::with(['department', 'employeeSkills.skill']);

        // AJAX filtering by department
        if ($request->ajax()) {
            if ($request->department_id) {
                $employees->where('department_id', $request->department_id);
            }
            return response()->json($employees->paginate(10));
        }

        return view('employees.index', [
            'employees' => $employees->paginate(10),
            'departments' => $departments
        ]);
    }

    public function create()
    {
        return view('employees.create', [
            'departments' => Department::all(),
            'skills' => Skill::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'skills'     => 'nullable|array',
            'skills.*'   => 'exists:skills,id',
        ]);

        $employee = Employee::create($validated);

        // Sync skills via employeeSkills table
        if (isset($validated['skills'])) {
            $employee->employeeSkills()->createMany(
                array_map(fn($skill_id) => ['skill_id' => $skill_id], $validated['skills'])
            );
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'employeeSkills.skill']); // eager load skills
        return response()->json([
            'employee' => $employee
        ]);
    }

    public function edit(Employee $employee)
    {
        return response()->json([
            'employee' => $employee,
            'skill_ids' => $employee->employeeSkills()->pluck('skill_id')
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => [
                'required',
                'email',
                Rule::unique('employees')->ignore($employee->id)
            ],
            'department_id' => 'required|exists:departments,id',
            'skills'     => 'nullable|array',
            'skills.*'   => 'exists:skills,id',
        ]);

        $employee->update($validated);

        // Sync skills via employeeSkills table
        if (isset($validated['skills'])) {
            // Delete existing skills first
            $employee->employeeSkills()->delete();
            // Add new ones
            $employee->employeeSkills()->createMany(
                array_map(fn($skill_id) => ['skill_id' => $skill_id], $validated['skills'])
            );
        } else {
            $employee->employeeSkills()->delete();
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Delete related employeeSkills first
        $employee->employeeSkills()->delete();
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
