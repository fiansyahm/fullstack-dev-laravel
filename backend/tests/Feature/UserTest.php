<?php
// backend/tests/Feature/UserTest.php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_users()
    {
        User::factory()->count(3)->create();
        $response = $this->getJson('/api/users');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'age' => 30,
        ];
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201)->assertJsonFragment($data);
        $this->assertDatabaseHas('users', $data);
    }

    public function test_can_show_user()
    {
        $user = User::factory()->create();
        $response = $this->getJson("/api/users/{$user->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $user->id]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'age' => 25,
        ];
        $response = $this->putJson("/api/users/{$user->id}", $data);
        $response->assertStatus(200)->assertJsonFragment($data);
        $this->assertDatabaseHas('users', $data);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_validation_fails_on_invalid_data()
    {
        $data = [
            'name' => '',
            'email' => 'invalid',
            'age' => -1,
        ];
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'age']);
    }
}