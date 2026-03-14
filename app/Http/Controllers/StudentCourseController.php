<?php

namespace App\Http\Controllers;

use App\Models\StudentCourse;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    
    public function store(Request $request)
    {
        StudentCourse::create($request->all());
        return response()->json(['message' => 'Student successfully enrolled in the course'], 200);
    }

  
}
