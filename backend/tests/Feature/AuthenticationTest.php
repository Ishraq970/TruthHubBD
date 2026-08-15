<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_role_is_never_client_controlled(): void
    {
        $response = $this->postJson('/register', [
            'name'                  => 'Faysal Ahmed',
            'email'                 => 'faysal@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'admin',
        ]);

        $response->assertCreated()->assertJsonStructure(['message']);
        $this->assertDatabaseHas('users', [
            'email' => 'faysal@example.com',
            'role'  => 'user',
        ]);
        // User must verify email before authentication session is established
        $this->assertGuest();
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'same@example.com']);
        $this->postJson('/register', [
            'name'                  => 'Another',
            'email'                 => 'same@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertUnprocessable()->assertJsonValidationErrors('email');
    }

    public function test_user_can_login_and_fetch_current_user(): void
    {
        $user = User::factory()->create([
            'password'          => 'password123',
            'email_verified_at' => now(),
        ]);

        $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ])->assertOk();

        $this->getJson('/api/user')->assertOk()->assertJsonPath('user.id', $user->id);
    }

    public function test_unverified_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'password'          => 'password123',
            'email_verified_at' => null,
        ]);

        $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ])->assertStatus(403);

        $this->assertGuest();
    }

    public function test_invalid_password_fails(): void
    {
        $user = User::factory()->create([
            'password'          => 'password123',
            'email_verified_at' => now(),
        ]);

        $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ])->assertUnprocessable();

        $this->assertGuest();
    }

    public function test_current_user_requires_authentication(): void
    {
        $this->getJson('/api/user')->assertUnauthorized();
    }

    public function test_logout_invalidates_session(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user)->postJson('/logout')->assertOk();
        $this->assertGuest();
        $this->getJson('/api/user')->assertUnauthorized();
    }

    public function test_profile_update_only_changes_authenticated_user(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $other = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user)->patchJson('/api/profile', ['name' => 'Updated Name'])->assertOk()->assertJsonPath('user.name', 'Updated Name');
        $this->assertDatabaseHas('users', ['id' => $other->id, 'name' => $other->name]);
    }
}
