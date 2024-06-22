<?php

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;

class RecruitmentWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithInvalidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(302);
        $this->assertGuest();
    }

    public function testUserCanRegisterWithValidData()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function testUserCannotRegisterWithExistingEmail()
    {
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function testJobSearchByKeyword()
    {
        Job::factory()->create([
            'title' => 'Developer'
        ]);

        $response = $this->get('/jobs?keyword=developer');

        $response->assertStatus(200);
        $response->assertSee('Developer');
    }

    public function testJobSearchByLocation()
    {
        Job::factory()->create([
            'location' => 'New York'
        ]);

        $response = $this->get('/jobs?location=New York');

        $response->assertStatus(200);
        $response->assertSee('New York');
    }

    public function testUserCannotApplyWithoutCV()
    {
        $user = User::factory()->create(['cv_updated' => false]);
        $this->actingAs($user);

        $job = Job::factory()->create();

        $response = $this->post('/apply', ['job_id' => $job->id]);

        $response->assertRedirect('/account/createcv');
        $response->assertSessionHas('error', 'You need to update your CV before applying for jobs.');
    }

    public function testUserCanApplyWithUpdatedCV()
    {
        $user = User::factory()->create(['cv_updated' => true]);
        $this->actingAs($user);

        $job = Job::factory()->create();

        $response = $this->post('/apply', ['job_id' => $job->id]);

        $response->assertRedirect('/jobs/' . $job->id);
        $response->assertSessionHas('success', 'Job applied successfully.');
    }

    public function testUserCanSaveCV()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/account/saveCV', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'jobType' => 1,
            'category' => 1,
            'address' => '123 Test St',
            'education' => 'Bachelor\'s Degree',
            'work_experience' => '2 years at Test Company',
            'experience' => '3 years',
            'keywords' => 'PHP, Laravel'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'CV saved successfully!');
        $this->assertDatabaseHas('cvs', [
            'user_id' => $user->id,
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);
    }
}
