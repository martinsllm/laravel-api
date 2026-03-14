<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCourseRequest;
use App\Models\StudentCourse;

class StudentCourseController extends Controller
{
    
    public function store(StudentCourseRequest $request)
    {
        StudentCourse::create($request->all());
        return response()->json(['message' => 'Student successfully enrolled in the course'], 200);
    }

  
}
