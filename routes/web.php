<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('courses', \App\Http\Controllers\CourseController::class);
Route::resource('students', \App\Http\Controllers\StudentController::class);

Route::patch('students/{id}/assign', [ \App\Http\Controllers\StudentController::class, 'assignCourse' ])->name('students.assign');
Route::get('students/{id}/courses', [ \App\Http\Controllers\StudentController::class, 'courses' ])->name('students.courses');
Route::delete('students/{id}/courses/{course_id}', [ \App\Http\Controllers\StudentController::class, 'coursesDelete' ])->name('students.courses.delete');
