<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    private function createEmployer()
    {
        return User::factory()->create(['role' => 'employer']);
    }

    private function createCandidate()
    {
        return User::factory()->create(['role' => 'candidate']);
    }

    private function createJobPost($employer)
    {
        $category = Category::create(['name' => 'IT', 'slug' => 'it']);
        return JobPost::factory()->create([
            'user_id'     => $employer->id,
            'category_id' => $category->id,
            'status'      => 'open',
        ]);
    }

    public function test_candidate_can_apply_to_job()
    {
        $employer  = $this->createEmployer();
        $candidate = $this->createCandidate();
        $jobPost   = $this->createJobPost($employer);

        $response = $this->actingAs($candidate)->post("/candidate/job-posts/{$jobPost->id}/apply", [
            'cover_letter' => 'I am a great candidate!',
        ]);

        $response->assertRedirect('/candidate/applications');
        $this->assertDatabaseHas('applications', [
            'user_id'     => $candidate->id,
            'job_post_id' => $jobPost->id,
            'status'      => 'pending',
        ]);
    }

    public function test_candidate_cannot_apply_twice()
    {
        $employer  = $this->createEmployer();
        $candidate = $this->createCandidate();
        $jobPost   = $this->createJobPost($employer);

        // First application
        $this->actingAs($candidate)->post("/candidate/job-posts/{$jobPost->id}/apply", [
            'cover_letter' => 'First application',
        ]);

        // Second application
        $response = $this->actingAs($candidate)->post("/candidate/job-posts/{$jobPost->id}/apply", [
            'cover_letter' => 'Second application',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertCount(1, Application::all());
    }

    public function test_employer_can_update_application_status()
    {
        $employer  = $this->createEmployer();
        $candidate = $this->createCandidate();
        $jobPost   = $this->createJobPost($employer);

        $application = Application::create([
            'user_id'      => $candidate->id,
            'job_post_id'  => $jobPost->id,
            'status'       => 'pending',
        ]);

        $response = $this->actingAs($employer)->patch("/employer/applications/{$application->id}", [
            'status' => 'accepted',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('applications', [
            'id'     => $application->id,
            'status' => 'accepted',
        ]);
    }

    public function test_employer_cannot_update_other_employers_application()
    {
        $employer1 = $this->createEmployer();
        $employer2 = User::factory()->create(['role' => 'employer']);
        $candidate = $this->createCandidate();
        $jobPost   = $this->createJobPost($employer1);

        $application = Application::create([
            'user_id'     => $candidate->id,
            'job_post_id' => $jobPost->id,
            'status'      => 'pending',
        ]);

        $response = $this->actingAs($employer2)->patch("/employer/applications/{$application->id}", [
            'status' => 'accepted',
        ]);

        $response->assertStatus(403);
    }

    public function test_candidate_can_view_their_applications()
    {
        $candidate = $this->createCandidate();

        $response = $this->actingAs($candidate)->get('/candidate/applications');

        $response->assertStatus(200);
    }
}