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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect('courses');
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');*/


Route::resource('courses', \App\Http\Controllers\CourseController::class);
Route::resource('students', \App\Http\Controllers\StudentController::class);

/*Rutas adicionales de los estudiantes*/
Route::get('students/{id}/courses-avaible', [ \App\Http\Controllers\StudentController::class, 'courseAvaible' ])->name('students.courses.avaible');
Route::patch('students/{id}/assign', [ \App\Http\Controllers\StudentController::class, 'assignCourse' ])->name('students.assign');
Route::get('students/{id}/courses', [ \App\Http\Controllers\StudentController::class, 'courses' ])->name('students.courses');
Route::delete('students/{id}/courses/{course_id}', [ \App\Http\Controllers\StudentController::class, 'coursesDelete' ])->name('students.courses.delete');

/*Rutas adicionales de los cursos*/
Route::get('courses/{id}/students', [ \App\Http\Controllers\CourseController::class, 'students' ])->name('courses.students');
Route::delete('courses/{id}/students/{student_id}', [ \App\Http\Controllers\CourseController::class, 'studentDelete' ])->name('courses.students.delete');
Route::get('courses/top/3', [ \App\Http\Controllers\CourseController::class, 'topCourses' ])->name('courses.top');
