<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Services\CourseService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(public CourseService $courseService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->courseService->list($request);

        $result = $query->paginate(10);
        
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request, Authenticatable $user)
    {
        if(!$user->can('add')){
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        $course = $this->courseService->save($request->all());
        return response()->json($course, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = $this->courseService->find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id, Authenticatable $user)
    {
        if(!$user->can('edit')){
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        $course = $this->courseService->find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $this->courseService->update($course, $request->all());

        return response()->json($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Authenticatable $user)
    {
        if(!$user->can('delete')){
            return response()->json(['message' => 'Forbidden access'], 403);
        }
        
        $course = $this->courseService->find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $this->courseService->delete($course);

        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
