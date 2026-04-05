<?php

namespace App\Services;

use App\Models\Student;
use App\Contracts\BaseRepository;
use App\Traits\FilterTrait;   

class StudentService extends BaseRepository
{
    use FilterTrait;

    public function __construct(public Student $student)
    {
        parent::__construct($student);
    }

    public function list($request)  
    {
        $query = $this->student->query();

        if ($request->has('name')) {
            $this->filter($query, $request->query());
        }

        return $query;
    }

    public function find($id)
    {
        return $this->student->with('courses')->find($id);
    }
}