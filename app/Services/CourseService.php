<?php

namespace App\Services;

use App\Models\Course;
use App\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class CourseService extends BaseRepository
{
    public function __construct(public Course $course)
    {
        parent::__construct($course);
    }

    public function list($request): Builder
    {
        $query = $this->course->query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        return $query;
    }

    public function find($id)
    {
        return $this->course->with('students')->find($id);
    }


}