<?php

namespace Tests\Feature;

use App\Models\Developer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetListDeveloperTest extends TestCase
{
    public function getListDeveloperRoutes()
    {
        return route('developers.index');
    }

    /** @test */
    public function user_can_get_list_developer()
    {
        $developer = Developer::factory()->create();
        $response = $this->get($this->getListDeveloperRoutes());

        $response->assertStatus(200);
        $response->assertViewIs('developers.index');
        $response->assertSee($developer->get);
    }
}
