<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(public StudentService $studentService)
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = $this->studentService->list();
        return response()->json($students, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $student = $this->studentService->create($request->all());
        return response()->json($student, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = $this->studentService->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, string $id)
    {
        $student = $this->studentService->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $this->studentService->update($student, $request->all());

        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = $this->studentService->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $this->studentService->delete($student);

        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
}
