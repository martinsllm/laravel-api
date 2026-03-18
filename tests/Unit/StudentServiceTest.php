<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Services\StudentService;
use Mockery;
use PHPUnit\Framework\TestCase;

class StudentServiceTest extends TestCase
{
    private $studentMock;

    protected function setUp(): void
    {
        $this->studentMock = Mockery::mock(Student::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    
    public function test_all_students_are_returned()
    {
        $data = collect([
            ['name' => 'John Doe', 'email' => 'xG3oH@example.com'],
            ['name' => 'Jane Doe', 'email' => 'xG3oH@example.com']
        ]);

        $this->studentMock->shouldReceive('all')
            ->once()
            ->andReturn($data);

        $service = new StudentService($this->studentMock);
        $result = $service->list();

        $this->assertEquals($data, $result);
    }

    public function test_student_is_found()
    {
        $mockStudent = (object) ['id' => 1, 'name' => 'John Doe', 'email' => 'xG3oH@example.com'];

        $this->studentMock->shouldReceive('with')->once()->with('courses')->andReturnSelf();
        $this->studentMock->shouldReceive('find')->once()->with(1)->andReturn($mockStudent);

        $service = new StudentService($this->studentMock);
        $result = $service->find(1);

        $this->assertEquals($mockStudent, $result);
    }

    public function test_student_not_found()
    {
        $this->studentMock->shouldReceive('with')->once()->with('courses')->andReturnSelf();
        $this->studentMock->shouldReceive('find')->once()->with(1)->andReturn(null);

        $service = new StudentService($this->studentMock);
        $result = $service->find(1);

        $this->assertNull($result);
    }

    public function test_student_is_created()
    {
        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $mockStudent = (object) ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'];

        $this->studentMock->shouldReceive('create')->once()->with($data)->andReturn($mockStudent);

        $service = new StudentService($this->studentMock);
        $result = $service->create($data);

        $this->assertEquals($mockStudent, $result);
    }

    public function test_student_is_updated()
    {
        $existingStudent = Mockery::mock(Student::class);
        $updateData = ['email' => 'new@example.com'];

        $existingStudent->shouldReceive('fill')->once()->with($updateData);
        $existingStudent->shouldReceive('save')->once();

        $service = new StudentService($this->studentMock);
        $result = $service->update($existingStudent, $updateData);

        $this->assertEquals($existingStudent, $result);
    }

    public function test_student_is_deleted()
    {
        $student = Mockery::mock(Student::class);
        $student->shouldReceive('delete')->once();

        $service = new StudentService($this->studentMock);
        $service->delete($student);

        $this->assertTrue(true); // Só garante que delete foi chamado
    }
    
}
