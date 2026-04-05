<?php

namespace App\Services;

use App\Models\Student;
use App\Contracts\BaseRepository;   

class StudentService extends BaseRepository
{
    public function __construct(public Student $student)
    {
        parent::__construct($student);
    }

    public function list($request)  
    {
        $query = $this->student->query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        return $query;
    }

    public function find($id)
    {
        return $this->student->with('courses')->find($id);
    }
}