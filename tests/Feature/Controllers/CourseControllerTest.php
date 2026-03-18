<?php

namespace Tests\Feature\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CourseControllerTest extends TestCase
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

    public function test_all_courses_are_returned()
    {
        $response = $this->actingAs(
            $this->admin,
            'sanctum'
        )->get('/api/v1/course');

        $response->assertStatus(200);
        $this->assertTrue(is_array(json_decode($response->getContent())));
    }

    public function test_course_is_returned()
    {
        $course = Course::factory()->create();  

        $response = $this->actingAs(
            $this->admin,
            'sanctum'
        )->get('/api/v1/course/1');

        $response->assertStatus(200);
        $this->assertEquals($course->name, $response->json()['name']);
    }

    public function test_store_return_successful_response()
    {
        $data = [
            'name' => 'PHP'
        ];

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->postJson('/api/v1/course', $data);

        $response->assertStatus(200);
        $this->assertEquals($data['name'], json_decode($response->getContent())->name);
        $this->assertDatabaseHas('courses', $data);
    }

    public function test_store_return_unauthorized_response()
    {
        $data = [
            'name' => 'PHP'
        ];

        $response = $this->actingAs(
            $this->guestUser, 'sanctum')
        ->postJson('/api/v1/course', $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('courses', $data);
    }

    public function test_store_return_validation_error_response()
    {
        $data = [
            'name' => ''
        ];

        $response = $this->actingAs(
            $this->admin, 'sanctum')
        ->postJson('/api/v1/course', $data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
        $this->assertDatabaseMissing('courses', $data);
    }
}
