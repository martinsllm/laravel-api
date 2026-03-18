<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Services\CourseService;
use Mockery;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    private $courseMock;

    protected function setUp(): void
    {
        // Mock do model Course
        $this->courseMock = Mockery::mock(Course::class);
    }

    public function test_all_courses_are_returned()
    {
        $data = collect([
            ['name' => 'PHP'],
            ['name' => 'Laravel']
        ]);

        $this->courseMock->shouldReceive('all')->once()->andReturn($data);

        $service = new CourseService($this->courseMock);
        $result = $service->list();

        $this->assertEquals($data, $result);
    }

    public function test_find_course_by_id()
    {
        $courseId = 1;
        $mockCourse = (object) ['id' => $courseId, 'name' => 'PHP'];

        $this->courseMock->shouldReceive('with')
            ->once()
            ->with('students')
            ->andReturnSelf(); // Encadeamento do Eloquent

        $this->courseMock->shouldReceive('find')
            ->once()
            ->with($courseId)
            ->andReturn($mockCourse);

        $service = new CourseService($this->courseMock);
        $result = $service->find($courseId);

        $this->assertEquals($mockCourse, $result);
    }

   public function test_create_course()
    {
        $data = ['name' => 'VueJS'];
        $mockCourse = (object) ['id' => 10, 'name' => 'VueJS'];

        $this->courseMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($mockCourse);

        $service = new CourseService($this->courseMock);
        $result = $service->create($data);

        $this->assertEquals($mockCourse, $result);
    }

    public function test_update_course()
    {
        $existingCourse = Mockery::mock(Course::class);
        $updateData = ['name' => 'Updated PHP'];

        $existingCourse->shouldReceive('fill')->once()->with($updateData);
        $existingCourse->shouldReceive('save')->once();

        $service = new CourseService($this->courseMock);
        $result = $service->update($existingCourse, $updateData);

        $this->assertEquals($existingCourse, $result);
    }

    public function test_delete_course()
    {
        $course = Mockery::mock(Course::class);
        $course->shouldReceive('delete')->once();

        $service = new CourseService($this->courseMock);
        $service->delete($course);

        $this->assertTrue(true);
    }
}
