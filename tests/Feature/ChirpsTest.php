<?php 

namespace Tests\Feature;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;


class ChirpsTest extends TestCase 
{
    use RefreshDatabase, WithFaker;

    public function test_chirps_page_is_displayed(): void 
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/chirps');
        
        $response->assertOk();
    }

    public function test_chirps_can_be_posted(): void 
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/chirps', [
            "message" => "Hello World"
        ]);           

        $response
            ->assertRedirect('/chirps');
        
        $this -> assertDatabaseHas('chirps', [
            'user_id' => $user->id,
            'message' => 'Hello World'
        ]);
    }

    public function test_chirps_can_be_updated(): void
    {
        $user = User::factory()->create();
        $chirp = Chirp::factory()->create();

        $response = $this
        ->actingAs($user)
        ->post('/chirps', [
            "message" => $chirp->message
        ])     
        ->put('/chirps', [
            "message" => "Hello World"
        ]);

        $response
            ->assertRedirect('/chirps');
        
        $this -> assertSame('Hello World', $chirp->message);
    }
} 