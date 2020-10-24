<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Course[]|\Illuminate\Database\Eloquent\Collection|\Inertia\Response
     */
    public function index(Request $request)
    {
        $courses = Course::paginate(10);

        return Inertia::render('Courses/list', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Courses/create');
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
            'name' => 'required|max:255',
            'schedule' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        Course::create($validateData);

        return redirect('courses')->with('success', 'Curso creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return Inertia::render('Courses/edit', [
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'schedule' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $course->update($validateData);

        return redirect('courses')->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();

            return redirect('courses')->with('success', 'Curso eliminado correctamente.');
        }catch (\Exception $e){
            return redirect('students')->with('error', 'No ha sido posible eliminar el curso debido a que tiene algunos estudiantes enlazados');
        }
    }

    public function students($course_id)
    {
        $students = Student::select('students.*', 'students_courses.created_at as inscription_date')
            ->join('students_courses', 'students_courses.student_id', 'students.id')
            ->where('students_courses.course_id', $course_id)
            ->get();

        return $students;
    }

    public function studentDelete($course_id, $student_id){
        StudentCourse::where('student_id', $student_id)
            ->where('course_id', $course_id)->delete();

        return ['message' => 'El estudiante ha sido eliminado correctamente'];
    }
}
