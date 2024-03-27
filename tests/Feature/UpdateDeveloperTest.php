<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Developer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDeveloperTest extends TestCase
{
    public function getDeveloperUpdateRoute($id)
    {
        return route('developers.update', ['id' => $id]);
    }

    public function getDeveloperUpdateViewRoute($id)
    {
        return route('developers.edit', ['id' => $id]);
    }
     /** @test */
     public function authenticate_user_can_update_developer_if_data_is_valid()
     {
         $this->actingAs(User::factory()->create());
         $developer = Developer::factory()->create()->toArray();
         $response = $this->from($this->getDeveloperUpdateViewRoute($developer['id']))->put($this->getDeveloperUpdateRoute($developer['id']), $developer);
 
         $response->assertStatus(302);
         $this->assertDatabaseHas('developers', $developer);
         $response->assertRedirect(route('developers.index'));
     }

     /** @test */
     public function unauthenticate_user_can_not_update_developer()
     { 
         $developer = Developer::factory()->create()->toArray();
         $response = $this->from($this->getDeveloperUpdateViewRoute($developer['id']))->put($this->getDeveloperUpdateRoute($developer['id']), $developer);

         $response->assertRedirect('/login');
     }

     /** @test */
     public function unauthenticate_user_can_not_see_update_developer_form()
     { 
         $developer = Developer::factory()->create()->toArray();
         $response = $this->get($this->getDeveloperUpdateViewRoute($developer['id']));

         $response->assertRedirect('/login');
     }

      /** @test */
     public function authenticate_user_can_see_update_developer_form()
     { 
        $this->actingAs(User::factory()->create());
         $developer = Developer::factory()->create();
         $response = $this->get($this->getDeveloperUpdateViewRoute($developer->id));

         $response->assertViewHas('developer', $developer);
         $response->assertSee($developer->get);
     }

      /** @test */
      public function authenticate_user_can_not_update_developer_if_data_is_not_valid()
      {
          $this->actingAs(User::factory()->create());
          $developer = Developer::factory()->create(['name' => '', 'duty' => ''])->toArray();
          $response = $this->from($this->getDeveloperUpdateViewRoute($developer['id']))->put($this->getDeveloperUpdateRoute($developer['id']), $developer);
  
          $response->assertStatus(302);
          $response->assertRedirect($this->getDeveloperUpdateViewRoute($developer['id']));
          $response->assertSessionHasErrors(['name', 'duty']);
      }

      /** @test */
      public function authenticate_user_can_not_update_developer_if_name_is_not_valid()
      {
          $this->actingAs(User::factory()->create());
          $developer = Developer::factory()->create(['name' => ''])->toArray();
          $response = $this->from($this->getDeveloperUpdateViewRoute($developer['id']))->put($this->getDeveloperUpdateRoute($developer['id']), $developer);
  
          $response->assertStatus(302);
          $response->assertRedirect($this->getDeveloperUpdateViewRoute($developer['id']));
          $response->assertSessionHasErrors(['name']);
      }

      /** @test */
      public function authenticate_user_can_not_update_developer_if_duty_is_not_valid()
      {
          $this->actingAs(User::factory()->create());
          $developer = Developer::factory()->create(['duty' => ''])->toArray();
          $response = $this->from($this->getDeveloperUpdateViewRoute($developer['id']))->put($this->getDeveloperUpdateRoute($developer['id']), $developer);
  
          $response->assertStatus(302);
          $response->assertRedirect($this->getDeveloperUpdateViewRoute($developer['id']));
          $response->assertSessionHasErrors(['duty']);
      }

      /** @test */
      public function authenticate_user_can_not_update_developer_if_developer_is_not_exist()
      {
          $this->actingAs(User::factory()->create());
          $developer = -1;
          $response = $this->get($this->getDeveloperUpdateViewRoute($developer));
  
          $response->assertStatus(404);
      }
}
