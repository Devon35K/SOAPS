<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
    }

    public function test_reset_password_otp_can_be_requested(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->postJson(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertJson([
            'status' => 'success',
        ]);

        Mail::assertSent(OTPMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertNotEmpty(Cache::get('password_reset_otp:' . $user->email));
    }

    public function test_reset_password_otp_can_be_verified(): void
    {
        $user = User::factory()->create();

        Cache::put('password_reset_otp:' . $user->email, '123456', 900);

        $response = $this->postJson(route('password.verify-otp'), [
            'email' => $user->email,
            'otp' => '123456',
        ]);

        $response->assertJson([
            'status' => 'success',
            'message' => 'OTP verified successfully!',
        ]);

        $this->assertTrue(Cache::get('password_reset_verified:' . $user->email));
    }

    public function test_password_can_be_reset_with_valid_otp(): void
    {
        $user = User::factory()->create();

        Cache::put('password_reset_otp:' . $user->email, '123456', 900);
        Cache::put('password_reset_verified:' . $user->email, true, 900);

        $response = $this->postJson(route('password.update'), [
            'email' => $user->email,
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertJson([
            'status' => 'success',
            'message' => 'Password reset successfully!',
        ]);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_password_cannot_be_reset_with_invalid_otp(): void
    {
        $user = User::factory()->create();

        Cache::put('password_reset_otp:' . $user->email, '123456', 900);

        $response = $this->postJson(route('password.update'), [
            'email' => $user->email,
            'otp' => '654321', // wrong OTP
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertJson([
            'status' => 'error',
            'message' => 'Invalid or expired verification. Please start again.',
        ]);
    }
}

