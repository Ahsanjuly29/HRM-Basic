<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Skill;

class DashboardController extends Controller
{

    public function index()
    {
        $employeeCount   = Employee::count();
        $departmentCount = Department::count();
        $skillCount      = Skill::count();

        // For chart: employees per department
        $departments = Department::withCount('employees')->get();
        $departmentLabels = $departments->pluck('name');        // ['HR','IT','Sales']
        $departmentCounts = $departments->pluck('employees_count'); // [5,10,3]

        return view('dashboard', compact(
            'employeeCount',
            'departmentCount',
            'skillCount',
            'departmentLabels',
            'departmentCounts'
        ));
    }
}
