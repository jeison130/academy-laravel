<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourse;
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

        return redirect('students')->with('success', 'Estudiante creado correctamente.');
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

        return redirect('students')->with('success', 'Estudiante actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        try{
            $student->delete();

            return redirect('students')->with('success', 'Estudiante eliminado correctamente.');
        }catch (\Exception $e){
            return redirect('students')->with('error', 'No ha sido posible eliminar el estudiante debido a que tiene algunos cursos enlazados');
        }

    }

    public function assignCourse(Request $request, $student_id){

        /*\DB::table('students_courses')->insert([
           'student_id' => $student_id,
           'course_id' => $request->input('course_id')
        ]);*/
        StudentCourse::create([
            'student_id' => $student_id,
            'course_id' => $request->input('course_id')
        ]);
        /*$student->courses()->create([
            'course_id' => $request->input('course_id')
        ]);*/

        return ['message' => 'El curso ha sido asignado correctamente'];
    }

    public function courseAvaible(Request $request, $student_id){
        $courses = Course::select('courses.*')
            ->leftJoin('students_courses', 'students_courses.course_id', \DB::raw('courses.id AND students_courses.student_id = ' . $student_id))
            ->whereNull('students_courses.student_id')
            ->get();

        return $courses;
    }

    public function courses(Request $request, $student_id){
        $courses = Course::select('courses.*')
            ->join('students_courses', 'students_courses.course_id', 'courses.id')
            ->where('students_courses.student_id', $student_id)
            ->get();

        return $courses;
    }

    public function coursesDelete(Request $request, $student_id, $course_id){
        StudentCourse::where('student_id', $student_id)
        ->where('course_id', $course_id)->delete();

        return ['message' => 'El curso ha sido eliminado correctamente'];
    }
}
