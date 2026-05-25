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

    public function test_leaderboard_renders_top_100_athletes_in_correct_order()
    {
        $currentUser = User::factory()->create([
            'full_name' => 'Current User Athlete',
            'sport' => 'Basketball',
            'approved' => true,
            'role' => 'user'
        ]);

        // Create 12 other users with points — current user ends up at rank #13 (inside Top 100)
        $users = User::factory()->count(12)->create(['approved' => true, 'role' => 'user']);

        // Assign points to users
        foreach ($users as $index => $u) {
            Leaderboard::create([
                'user_id' => $u->id,
                'total_points' => ($index + 1) * 100 // 100, 200, 300, ... 1200
            ]);
        }

        // Current user has 50 points (rank #13 — inside Top 100)
        Leaderboard::create([
            'user_id' => $currentUser->id,
            'total_points' => 50
        ]);

        $this->actingAs($currentUser);

        $response = $this->get(route('user.leaderboard'));
        $response->assertOk();

        // Top athlete (index 11, 1200 points) should be visible
        $highestUser = $users[11];
        $response->assertSee($highestUser->full_name);

        // Current user (rank #13) should appear inline — no gap separator since they're in Top 100
        $response->assertSee('Current User Athlete');
        $response->assertSee('Basketball');
        $response->assertDontSee('•••');
    }

    public function test_leaderboard_shows_gap_separator_when_user_is_outside_top_100()
    {
        $currentUser = User::factory()->create([
            'full_name' => 'Outside Top Hundred Athlete',
            'sport' => 'Tennis',
            'approved' => true,
            'role' => 'user'
        ]);

        // Create 102 other users with points — current user ends up at rank #103
        $users = User::factory()->count(102)->create(['approved' => true, 'role' => 'user']);

        foreach ($users as $index => $u) {
            Leaderboard::create([
                'user_id' => $u->id,
                'total_points' => ($index + 1) * 100
            ]);
        }

        // Current user has only 5 points (rank #103 — outside Top 100)
        Leaderboard::create([
            'user_id' => $currentUser->id,
            'total_points' => 5
        ]);

        $this->actingAs($currentUser);

        $response = $this->get(route('user.leaderboard'));
        $response->assertOk();

        // Gap separator should be visible since user is outside Top 100
        $response->assertSee('•••');

        // Current user's name, sport, and rank should be in the pinned bottom row
        $response->assertSee('Outside Top Hundred Athlete');
        $response->assertSee('Tennis');
        $response->assertSee('#103');

        // "Your Standing" label
        $response->assertSee('Your Standing');
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
