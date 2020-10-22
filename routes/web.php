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

Route::get('/students', function () {
    return Inertia\Inertia::render('Students/list');
})->name('students');

Route::get('/students/create', function () {
    return Inertia\Inertia::render('Students/create');
})->name('students.create');


Route::resource('api/students', \App\Http\Controllers\StudentController::class)->except([
    'create',
    'edit'
]);
