<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Developer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDeveloperTest extends TestCase
{
    public function getDeveloperDeleteRoute($id)
    {
        return route('developers.destroy', ['id' => $id]);
    }

     /** @test */
     public function authenticate_user_can_delete_developer_if_developer_is_exist()
     {
         $this->actingAs(User::factory()->create());
         $developer = Developer::factory()->create()->toArray();
         $response = $this->delete($this->getDeveloperDeleteRoute($developer['id']));
 
         $response->assertStatus(302);
         $this->assertDatabaseMissing('developers', $developer);
         $response->assertRedirect(route('developers.index'));
     }

     /** @test */
     public function unauthenticate_user_can_not_delete_developer()
     {
        $developer = Developer::factory()->create();
         $response = $this->delete($this->getDeveloperDeleteRoute($developer->id));
 
         $response->assertRedirect('/login');
     }

     /** @test */
     public function authenticate_user_can_not_delete_developer_if_developer_is_not_exist()
     {
         $this->actingAs(User::factory()->create());
         $developer = -1;
         $response = $this->delete($this->getDeveloperDeleteRoute($developer));
 
        $response->assertStatus(404);

     }
}
