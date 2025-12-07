<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Skill;
use App\Models\User;
use App\Models\EmployeeSkill; // Make sure to import
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AllInOneHRMSeeder extends Seeder
{
    public function run()
    {
        // -------------------
        // Users
        // -------------------
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Developer User',
            'email' => 'developer@example.com',
            'password' => Hash::make('password'),
            'role' => 'developer',
        ]);

        User::create([
            'name' => 'Visitor User',
            'email' => 'visitor@example.com',
            'password' => Hash::make('password'),
            'role' => 'visitor',
        ]);

        // -------------------
        // Departments
        // -------------------
        $departmentNames = ['HR', 'IT', 'Finance', 'Marketing'];
        $departments = [];
        foreach ($departmentNames as $name) {
            $departments[] = Department::create(['name' => $name]);
        }

        // -------------------
        // Skills
        // -------------------
        $skillNames = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'CSS', 'HTML', 'MySQL'];
        $skills = [];
        foreach ($skillNames as $name) {
            $skills[] = Skill::create(['name' => $name]);
        }

        // -------------------
        // Employees
        // -------------------
        $employeeFullNames = [
            'John Doe',
            'Jane Smith',
            'Alice Johnson',
            'Bob Brown',
            'Charlie Wilson',
            'David Lee',
            'Eva Adams',
            'Frank Harris',
            'Grace Clark',
            'Henry Lewis'
        ];

        foreach ($employeeFullNames as $fullName) {
            $parts = explode(' ', $fullName);
            $firstName = $parts[0];
            $lastName  = $parts[1] ?? '';

            $employee = Employee::create([
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'email'         => strtolower($firstName . '.' . $lastName) . '@example.com',
                'department_id' => $departments[array_rand($departments)]->id,
            ]);

            // Assign random 1-3 skills via EmployeeSkill model
            $assignedSkills = collect($skills)->random(rand(1, 3));
            foreach ($assignedSkills as $skill) {
                EmployeeSkill::create([
                    'employee_id' => $employee->id,
                    'skill_id'    => $skill->id,
                ]);
            }
        }

        $this->command->info('All users, departments, skills, and employees seeded successfully!');
    }
}
