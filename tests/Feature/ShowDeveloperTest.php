<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Developer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowDeveloperTest extends TestCase
{
    public function getShowDeveloperRoute($id)
    {
        return route('developers.show', ['id' => $id]);
    }

    /** @test */
    public function user_can_get_detail_developer()
    {
        $developer = Developer::factory()->create();
        $response = $this->get($this->getShowDeveloperRoute($developer->id));

        $response->assertStatus(200);
        $response->assertViewHas('developer', $developer);
        $response->assertSee($developer->get);
    }

    /** @test */
    public function user_can_not_get_detail_developer_if_developer_is_not_exist()
    {
        $developer = -1;
        $response = $this->get($this->getShowDeveloperRoute($developer));

        $response->assertStatus(404);
    }
}
