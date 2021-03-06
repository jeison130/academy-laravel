<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;
    protected $table = 'students_courses';

    protected $fillable = ['student_id', 'course_id'];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];
}
