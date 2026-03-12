<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPostTest extends TestCase
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

    private function createCategory()
    {
        return Category::create(['name' => 'IT', 'slug' => 'it']);
    }

    public function test_employer_can_view_job_posts_index()
    {
        $employer = $this->createEmployer();

        $response = $this->actingAs($employer)->get('/employer/job-posts');

        $response->assertStatus(200);
    }

    public function test_employer_can_create_job_post()
    {
        $employer = $this->createEmployer();
        $category = $this->createCategory();

        $response = $this->actingAs($employer)->post('/employer/job-posts', [
            'title'       => 'Senior PHP Developer',
            'category_id' => $category->id,
            'description' => 'We need a great developer',
            'location'    => 'Remote',
            'type'        => 'full-time',
            'salary_min'  => 50000,
            'salary_max'  => 80000,
        ]);

        $response->assertRedirect('/employer/job-posts');
        $this->assertDatabaseHas('job_posts', [
            'title'   => 'Senior PHP Developer',
            'user_id' => $employer->id,
        ]);
    }

    public function test_employer_can_update_job_post()
    {
        $employer  = $this->createEmployer();
        $category  = $this->createCategory();
        $jobPost   = JobPost::factory()->create([
            'user_id'     => $employer->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($employer)->put("/employer/job-posts/{$jobPost->id}", [
            'title'       => 'Updated Title',
            'category_id' => $category->id,
            'description' => 'Updated description',
            'location'    => 'Remote',
            'type'        => 'full-time',
            'status'      => 'open',
        ]);

        $response->assertRedirect('/employer/job-posts');
        $this->assertDatabaseHas('job_posts', ['title' => 'Updated Title']);
    }

    public function test_employer_can_delete_job_post()
    {
        $employer = $this->createEmployer();
        $category = $this->createCategory();
        $jobPost  = JobPost::factory()->create([
            'user_id'     => $employer->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($employer)->delete("/employer/job-posts/{$jobPost->id}");

        $response->assertRedirect('/employer/job-posts');
        $this->assertDatabaseMissing('job_posts', ['id' => $jobPost->id]);
    }

    public function test_candidate_can_view_job_posts()
    {
        $candidate = $this->createCandidate();

        $response = $this->actingAs($candidate)->get('/candidate/job-posts');

        $response->assertStatus(200);
    }

    public function test_candidate_cannot_create_job_post()
    {
        $candidate = $this->createCandidate();
        $category  = $this->createCategory();

        $response = $this->actingAs($candidate)->post('/employer/job-posts', [
            'title'       => 'Hacked Job Post',
            'category_id' => $category->id,
            'description' => 'This should not work',
            'location'    => 'Remote',
            'type'        => 'full-time',
        ]);

        $response->assertStatus(403);
    }

    public function test_job_post_requires_title()
    {
        $employer = $this->createEmployer();
        $category = $this->createCategory();

        $response = $this->actingAs($employer)->post('/employer/job-posts', [
            'title'       => '',
            'category_id' => $category->id,
            'description' => 'Some description',
            'location'    => 'Remote',
            'type'        => 'full-time',
        ]);

        $response->assertSessionHasErrors('title');
    }
}