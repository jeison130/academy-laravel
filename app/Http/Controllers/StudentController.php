<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::paginate(10);

        return Inertia::render('Students/list', [
            'students' => $students
        ]);
    }

    /**
     * Form for create new students
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Students/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:50',
            'lastName' => 'required|max:50',
            'age' => 'required',
            'email' => 'required|email'
        ]);

        Student::create($validateData);

        return redirect('students');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return $student;
    }

    public function edit(Student $student)
    {
        return Inertia::render('Students/edit', [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $validateData = $request->validate([
            'name' => 'required|max:50',
            'lastName' => 'required|max:50',
            'age' => 'required',
            'email' => 'required|email'
        ]);

        $student->update($validateData);

        return redirect('students');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect('students');
    }
}
