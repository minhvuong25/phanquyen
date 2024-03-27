<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Developer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewDeveloperTest extends TestCase
{
    public function getCreateDeveloperRoute()
    {
        return route('developers.store');
    }

    public function getCreateDeveloperViewRoute()
    {
        return route('developers.create');
    }
    /** @test */
    public function authenticate_user_can_create_new_developer_if_data_is_valid()
    {
        $this->actingAs(User::factory()->create());
        $developer = Developer::factory()->make()->toArray();
        $response = $this->from($this->getCreateDeveloperViewRoute())->post($this->getCreateDeveloperRoute(), $developer);

        $response->assertStatus(302);
        $this->assertDatabaseHas('developers', $developer);
        $response->assertRedirect(route('developers.index'));
    }

    /** @test */
    public function unauthenticate_user_can_not_create_new_developer()
    {
        $developer = Developer::factory()->make()->toArray();
        $response = $this->from($this->getCreateDeveloperViewRoute())->post($this->getCreateDeveloperRoute(), $developer);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

     /** @test */
     public function unauthenticate_user_can_not_see_create_new_developer_form()
     {
         $developer = Developer::factory()->make()->toArray();
         $response = $this->get($this->getCreateDeveloperViewRoute());
 
         $response->assertStatus(302);
         $response->assertRedirect('/login');
     }

     /** @test */
    public function authenticate_user_can_not_create_new_developer_if_data_is_not_valid()
    {
        $this->actingAs(User::factory()->create());
        $developer = Developer::factory()->make(['name' => '', 'duty' => ''])->toArray();
        $response = $this->from($this->getCreateDeveloperViewRoute())->post($this->getCreateDeveloperRoute(), $developer);

        $response->assertStatus(302);
        $response->assertRedirect($this->getCreateDeveloperViewRoute());
        $response->assertSessionHasErrors(['name', 'duty']);
    }

    /** @test */
    public function authenticate_user_can_not_create_new_developer_if_name_is_not_valid()
    {
        $this->actingAs(User::factory()->create());
        $developer = Developer::factory()->make(['name' => ''])->toArray();
        $response = $this->from($this->getCreateDeveloperViewRoute())->post($this->getCreateDeveloperRoute(), $developer);

        $response->assertStatus(302);
        $response->assertRedirect($this->getCreateDeveloperViewRoute());
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function authenticate_user_can_not_create_new_developer_if_duty_is_not_valid()
    {
        $this->actingAs(User::factory()->create());
        $developer = Developer::factory()->make(['duty' => ''])->toArray();
        $response = $this->from($this->getCreateDeveloperViewRoute())->post($this->getCreateDeveloperRoute(), $developer);

        $response->assertStatus(302);
        $response->assertRedirect($this->getCreateDeveloperViewRoute());
        $response->assertSessionHasErrors(['duty']);
    }

     /** @test */
     public function authenticate_user_can_see_create_new_developer_form()
     {
        $this->actingAs(User::factory()->create());
         $response = $this->get($this->getCreateDeveloperViewRoute());
 
         $response->assertStatus(200);
         $response->assertViewIs('developers.create');
     }
}
