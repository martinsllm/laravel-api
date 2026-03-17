<?php

namespace Tests\Feature\Controllers;

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
        Role::create(['name' => 'admin'])->givePermissionTo('add');

        // Create a user and assign the role
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->guestUser = User::factory()->create();
    }

    public function test_students_all_are_returned()
    {
        $response = $this->actingAs(
            $this->admin,
            'sanctum'
        )->get('/api/v1/student');

        $response->assertStatus(200);
        $this->assertTrue(is_array(json_decode($response->getContent())));
    }

    public function test_store_return_successful_response()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'xG3oH@example.com'
        ];

        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/v1/student', $data);

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

        $response = $this->actingAs($this->guestUser, 'sanctum')->postJson('/api/v1/student', $data);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('students', $data);
    }

    public function test_store_return_validation_error_response()
    {
        $data = [
            'name' => '',
            'email' => 'xG3oHexample.com'
        ];

        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/v1/student', $data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
        $this->assertDatabaseMissing('students', $data);
    }
    
}
