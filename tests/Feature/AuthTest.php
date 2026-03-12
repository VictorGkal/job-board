<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_can_register()
    {
        $response = $this->post('/register', [
            'name'                  => 'Test Employer',
            'email'                 => 'employer@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'employer',
        ]);

        $response->assertRedirect('/employer/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'employer@test.com',
            'role'  => 'employer',
        ]);
    }

    public function test_candidate_can_register()
    {
        $response = $this->post('/register', [
            'name'                  => 'Test Candidate',
            'email'                 => 'candidate@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'candidate',
        ]);

        $response->assertRedirect('/candidate/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'candidate@test.com',
            'role'  => 'candidate',
        ]);
    }

    public function test_employer_is_redirected_to_employer_dashboard_after_login()
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $response = $this->post('/login', [
            'email'    => $employer->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/employer/dashboard');
    }

    public function test_candidate_is_redirected_to_candidate_dashboard_after_login()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $response = $this->post('/login', [
            'email'    => $candidate->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/candidate/dashboard');
    }

    public function test_unauthenticated_user_cannot_access_employer_dashboard()
    {
        $response = $this->get('/employer/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_candidate_cannot_access_employer_dashboard()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $response = $this->actingAs($candidate)->get('/employer/dashboard');
        $response->assertStatus(403);
    }

    public function test_employer_cannot_access_candidate_dashboard()
    {
        $employer = User::factory()->create(['role' => 'employer']);

        $response = $this->actingAs($employer)->get('/candidate/dashboard');
        $response->assertStatus(403);
    }
}