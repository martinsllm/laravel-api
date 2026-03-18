<?php

namespace Tests\Feature\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $guestUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Clear and re-register permissions with the Gate, especially when using Spatie
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create a permission and a role
        Permission::create(['name' => 'add']);
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Role::create(['name' => 'admin'])->givePermissionTo(['add', 'edit', 'delete']);
        

        // Create a user and assign the role
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->guestUser = User::factory()->create();
    }

    public function test_all_students_are_returned()
    {
        $response = $this->actingAs(
            $this->admin,
            'sanctum'
        )->get('/api/v1/student');

        $response->assertStatus(200);
        $this->assertTrue(is_array(json_decode($response->getContent())));
    }

    public function test_student_is_returned()
    {
        $student = Student::factory()->create();

        $response = $this->actingAs(
            $this->admin,
            'sanctum'
        )->get('/api/v1/student/1');

        $response->assertStatus(200);
        $this->assertEquals($student->name, $response->json()['name']);
    }

    public function test_store_return_successful_response()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'xG3oH@example.com'
        ];

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->postJson('/api/v1/student', $data);

        $response->assertStatus(200);
        $this->assertEquals($data['name'], json_decode($response->getContent())->name);
        $this->assertDatabaseHas('students', $data);
    }

    public function test_store_return_unauthorized_response()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'xG3oH@example.com'
        ];

        $response = $this->actingAs(
            $this->guestUser, 'sanctum')
        ->postJson('/api/v1/student', $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('students', $data);
    }

    public function test_store_return_validation_error_response()
    {
        $data = [
            'name' => '',
            'email' => 'xG3oHexample.com'
        ];

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->postJson('/api/v1/student', $data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
        $this->assertDatabaseMissing('students', $data);
    }

    public function test_update_return_successful_response()
    {
        Student::factory()->create();

        $data = [
            'name' => 'John Doe',
            'email' => 'xG3oH@example.com'
        ];

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->putJson("/api/v1/student/1", $data);

        $response->assertStatus(200);
        $this->assertEquals('John Doe', json_decode($response->getContent())->name);
        $this->assertDatabaseHas('students', $data);
    }

    public function test_update_return_unauthorized_response()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'xG3oH@example.com'
        ];

        $response = $this->actingAs(
            $this->guestUser, 'sanctum')
        ->putJson('/api/v1/student/1', $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('students', $data);
    }

    public function test_update_return_validation_error_response()
    {
        $data = [
            'name' => '',
            'email' => 'xG3oHexample.com'
        ];

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->putJson('/api/v1/student/1', $data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
        $this->assertDatabaseMissing('students', $data);
    }

    public function test_delete_return_successful_response()
    {
        Student::factory()->create();

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->delete('/api/v1/student/1');

        $response->assertStatus(200);
        $this->assertDatabaseMissing('students', ['id' => 1]);
    }

    public function test_delete_return_unauthorized_response()
    {
        Student::factory()->create();

        $response = $this->actingAs(
            $this->guestUser, 'sanctum')
        ->delete('/api/v1/student/1');

        $response->assertStatus(403);
        $this->assertDatabaseHas('students', ['id' => 1]);
    }
    
}
