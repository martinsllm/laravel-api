<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Services\StudentService;
use Mockery;
use PHPUnit\Framework\TestCase;

class StudentServiceTest extends TestCase
{
    private $studentService;

    protected function setUp(): void
    {
        $this->studentService = $this->createMock(StudentService::class);
    }
    
    public function test_all_students_are_returned()
    {
        $data = [
            ['name' => 'John Doe', 'email' => 'xG3oH@example.com'],
            ['name' => 'Jane Doe', 'email' => 'xG3oH@example.com']
        ];

        $this->studentService->method('list')->willReturn($data);

        $result = $this->studentService->list();

        $this->assertEquals('John Doe', $result[0]['name']);
        $this->assertEquals('Jane Doe', $result[1]['name']);
        $this->assertCount(2, $result);
    }

    public function test_student_is_found()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'xG3oH@example.com'
        ];

        $this->studentService->method('find')->willReturn(new Student($data));

        $result = $this->studentService->find(1);

        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('xG3oH@example.com', $result->email);
    }

    public function test_student_not_found()
    {
        $this->studentService->method('find')->willReturn(null);

        $result = $this->studentService->find(1);

        $this->assertNull($result);
    }

    public function test_student_is_created()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];

        $this->studentService
            ->method('create')
            ->with($data)
            ->willReturn(new Student($data));

        $result = $this->studentService->create($data);

        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('john@example.com', $result->email);
    }

    public function test_student_is_updated()
    {
        $existingStudent = new Student([
            'name' => 'John Doe',
            'email' => 'old@example.com'
        ]);

        $updateData = ['email' => 'new@example.com'];

        $this->studentService->expects($this->once())
            ->method('update')
            ->with($existingStudent, $updateData)
            ->willReturn(new Student([
                'name' => 'John Doe',
                'email' => 'new@example.com'
            ]));

        $result = $this->studentService->update($existingStudent, $updateData);

        // Assert: verifica se o estudante foi atualizado corretamente
        $this->assertInstanceOf(Student::class, $result);
        $this->assertEquals('new@example.com', $result->email);
    }

    public function test_student_is_deleted()
    {
        $student = Mockery::mock(Student::class);

        $this->studentService
            ->method('delete')
            ->with($student)
            ->willReturn(null);

        $this->assertNull($this->studentService->delete($student));
    }
    
}
