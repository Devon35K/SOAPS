<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Leaderboard;
use App\Models\Achievement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_achievements_and_leaderboard_pages()
    {
        $this->get(route('user.achievements'))->assertRedirect(route('login'));
        $this->get(route('user.leaderboard'))->assertRedirect(route('login'));
    }

    public function test_authenticated_student_can_view_achievements_page()
    {
        $user = User::factory()->create(['approved' => true, 'role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('user.achievements'));
        
        $response->assertOk();
        $response->assertSee('Trophies');
    }

    public function test_authenticated_student_can_view_leaderboard_page_with_empty_standings()
    {
        $user = User::factory()->create(['approved' => true, 'role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('user.leaderboard'));
        
        $response->assertOk();
        $response->assertSee('Athlete Leaderboard Standings');
        $response->assertSee('No leaderboard standings recorded yet.');
    }

    public function test_leaderboard_renders_top_10_athletes_in_correct_order()
    {
        $currentUser = User::factory()->create([
            'full_name' => 'Current User Athlete',
            'sport' => 'Basketball',
            'approved' => true,
            'role' => 'user'
        ]);

        // Create 12 other users with points
        $users = User::factory()->count(12)->create(['approved' => true, 'role' => 'user']);

        // Assign points to users
        foreach ($users as $index => $u) {
            Leaderboard::create([
                'user_id' => $u->id,
                'total_points' => ($index + 1) * 100 // 100, 200, 300, ... 1200
            ]);
        }

        // Current user has 50 points (not in top 10)
        Leaderboard::create([
            'user_id' => $currentUser->id,
            'total_points' => 50
        ]);

        $this->actingAs($currentUser);

        $response = $this->get(route('user.leaderboard'));
        $response->assertOk();

        // Top 10 will contain the highest scoring athletes
        // User with index 11 (1200 points) is #1
        $highestUser = $users[11];
        $response->assertSee($highestUser->full_name);

        // It should render the current user at the bottom since they are #13 (out of top 10)
        $response->assertSee('Current User Athlete');
        $response->assertSee('Basketball');
        $response->assertSee('•••');
        $response->assertSee('#13');
    }

    public function test_leaderboard_highlights_current_user_when_they_are_in_top_10()
    {
        $currentUser = User::factory()->create([
            'full_name' => 'Top Ten Athlete',
            'sport' => 'Esports',
            'approved' => true,
            'role' => 'user'
        ]);

        // Create 5 other users
        $users = User::factory()->count(5)->create(['approved' => true, 'role' => 'user']);

        foreach ($users as $index => $u) {
            Leaderboard::create([
                'user_id' => $u->id,
                'total_points' => 100
            ]);
        }

        // Top Ten Athlete has 500 points (Rank 1)
        Leaderboard::create([
            'user_id' => $currentUser->id,
            'total_points' => 500
        ]);

        $this->actingAs($currentUser);

        $response = $this->get(route('user.leaderboard'));
        $response->assertOk();

        $response->assertSee('Top Ten Athlete');
        $response->assertSee('Esports');
        $response->assertSee('highlighted');
        $response->assertSee('badge-you');
        $response->assertDontSee('•••');
    }
}
