<?php

namespace App\Services;

use App\Models\Course;
use App\Contracts\BaseRepository;

class CourseService extends BaseRepository
{
    public function __construct(public Course $course)
    {
        parent::__construct($course);
    }

    public function list()
    {
        return $this->course->all();
    }

    public function find($id)
    {
        return $this->course->with('students')->find($id);
    }


}