<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AllInOneHRMSeeder extends Seeder
{
    public function run()
    {
        // users 
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


        // departments 
        $departments = ['HR', 'IT', 'Finance', 'Marketing'];
        foreach ($departments as $dept) {
            Department::create(['name' => $dept]);
        }

        // Skills 
        $skills = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'CSS', 'HTML', 'MySQL'];
        foreach ($skills as $skill) {
            Skill::create(['name' => $skill]);
        }

        // Employee 
        $departments = Department::all();
        $skills = Skill::all();

        Employee::factory(10)->create()->each(function ($employee) use ($departments, $skills) {
            // Assign random department
            $employee->department_id = $departments->random()->id;
            $employee->save();

            // Assign random skills (1-3)
            $employee->skills()->sync($skills->random(rand(1, 3))->pluck('id')->toArray());
        });

        
    }
}
