<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCourseRequest;
use App\Models\StudentCourse;
use Illuminate\Contracts\Auth\Authenticatable;

class StudentCourseController extends Controller
{
    
    public function store(StudentCourseRequest $request, Authenticatable $user)
    {
        if(!$user->can('add')){
            return response()->json(['message' => 'Forbidden access'], 403);
        }
        
        StudentCourse::create($request->all());
        return response()->json(['message' => 'Student successfully enrolled in the course'], 200);
    }

  
}
