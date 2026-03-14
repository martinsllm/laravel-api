<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function __construct(public Course $course)
    {
        $this->course = $course;
    }

    public function list()
    {
        return $this->course->all();
    }

    public function find($id)
    {
        return $this->course->find($id);
    }

    public function create($data)
    {
        return $this->course->create($data);
    }

    public function update(Course $course, array $data)
    {
        $course->fill($data);
        $course->save();
        return $course;
    }

    public function delete(Course $course)
    {
        $course->delete();
    }
}