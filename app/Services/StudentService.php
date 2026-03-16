<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    public function __construct(public Student $student)
    {
        $this->student = $student;
    }

    public function list()  
    {
        return $this->student->all();
    }

    public function find($id)
    {
        return $this->student->with('courses')->find($id);
    }

    public function create(array $data)
    {
        return $this->student->create($data);
    }

    public function update(Student $student, array $data)
    {
        $student->fill($data);
        $student->save();
        return $student;
    }

    public function delete(Student $student)
    {
        $student->delete();
    }
}