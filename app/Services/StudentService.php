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

    public function list()  
    {
        return $this->student->all();
    }

    public function find($id)
    {
        return $this->student->with('courses')->find($id);
    }
}