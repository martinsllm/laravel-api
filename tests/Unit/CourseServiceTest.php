<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Services\CourseService;
use Mockery;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    private $courseService;

    protected function setUp(): void
    {
        $this->courseService = $this->createMock(CourseService::class);
    }

    public function test_all_courses_are_returned()
    {
        $data = [
            ['name' => 'PHP'],
            ['name' => 'Laravel']
        ];

        $this->courseService->expects($this->once())->method('list')->willReturn($data);
        
        $result = $this->courseService->list();

        $this->assertEquals('PHP', $result[0]['name']);
        $this->assertEquals('Laravel', $result[1]['name']);
        $this->assertCount(2, $result);
    }

    public function test_course_is_found()
    {
        $data = [
            'name' => 'PHP'
        ];   

        $this->courseService->expects($this->once())->method('find')->willReturn(new Course($data));

        $result = $this->courseService->find(1);

        $this->assertInstanceOf(Course::class, $result);
        $this->assertEquals('PHP', $result['name']);
    }

    public function test_course_not_found()
    {
        $this->courseService->expects($this->once())->method('find')->willReturn(null);

        $result = $this->courseService->find(1);

        $this->assertNull($result);
    }

    public function test_course_is_created()
    {
        $data = [
            'name' => 'PHP'
        ];

        $this->courseService->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn(new Course($data));

        $result = $this->courseService->create($data);

        $this->assertInstanceOf(Course::class, $result);
        $this->assertEquals('PHP', $result['name']);
    }

    public function test_course_is_updated()
    {
        $existingCourse = new Course([
            'name' => 'PHP'
        ]);

        $updateData = ['name' => 'Laravel'];

        $this->courseService->expects($this->once())
            ->method('update')
            ->with($existingCourse, $updateData)
            ->willReturn(new Course($updateData));

        $result = $this->courseService->update($existingCourse, $updateData);

        $this->assertInstanceOf(Course::class, $result);
        $this->assertEquals('Laravel', $result['name']);
    }

    public function test_course_is_deleted()
    {
        $course = Mockery::mock(Course::class);

        $this->courseService
            ->method('delete')
            ->with($course)
            ->willReturn(null);

        $this->assertNull($this->courseService->delete($course));
    }
}
