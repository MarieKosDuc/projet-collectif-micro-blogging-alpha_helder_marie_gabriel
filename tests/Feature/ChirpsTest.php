<?php 

namespace Tests\Feature;

use App\Models\Chirps;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;


class ChirpsTest extends TestCase 
{
    use RefreshDatabase;

    public function test_chirps_page_is_displayed(): void 
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/chirps');
        
        $response->assertOk();
    }
} 