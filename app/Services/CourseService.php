<?php

namespace App\Services;

use App\Models\Course;
use App\Contracts\BaseRepository;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Builder;

class CourseService extends BaseRepository
{
    use FilterTrait;

    public function __construct(public Course $course)
    {
        parent::__construct($course);
    }

    public function list($request): Builder
    {
        $query = $this->course->query();

        if ($request->has('name')) {
            $this->filter($query, $request->query());
        }

        return $query;
    }

    public function find($id, $withStudents = false)
    {
        $query = $this->course->query();

        if ($withStudents) {
            $query->with('students');
        }

        return $query->find($id);
    }


}