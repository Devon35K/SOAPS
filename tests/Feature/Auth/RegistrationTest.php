<?php

namespace Tests\Feature\Auth;

use App\Models\AccountApproval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function test_new_users_can_register(): void
    {
        Storage::fake('public');

        $document = UploadedFile::fake()->create('student_id.pdf', 100, 'application/pdf');

        $response = $this->post(route('register.post'), [
            'student_id' => '2026-00001',
            'full_name' => 'Test Athlete',
            'email' => 'test@example.com',
            'status' => 'undergraduate',
            'sport' => 'Basketball',
            'campus' => 'Tagum',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'document' => $document,
        ]);

        $response->assertRedirect(route('register', ['status' => 'success']));
        $response->assertSessionHas('message');

        $this->assertGuest();
        $this->assertDatabaseHas('account_approvals', [
            'student_id' => '2026-00001',
            'email' => 'test@example.com',
            'approval_status' => 'pending',
        ]);
    }
}

