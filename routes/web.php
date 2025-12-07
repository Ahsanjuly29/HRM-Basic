<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('/');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['role:admin,developer,visitor'])->name('dashboard');

// Group routes for authenticated users
Route::middleware(['auth', 'verified', 'role:admin,developer'])->group(function () {


    // Employees CRUD
    Route::resource('employees', EmployeeController::class);

    // Departments CRUD (except edit/delete from separate pages; modals used)
    Route::resource('departments', DepartmentController::class);

    // Skills CRUD
    Route::resource('skills', SkillController::class);

    Route::get('employees/check-email', [EmployeeController::class, 'checkEmail'])->name('employees.checkEmail');




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
