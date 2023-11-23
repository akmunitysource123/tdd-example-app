<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_blog_post_from_api()
    {
        # Arrange
        $users = User::factory(1)->create();
        $user = $users[0];
        $post = [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
        ]; 
        
        # Act
        $response = $this->actingAs($user)->post('/api/createBlog', $post);

        # Assert
        $response->assertStatus(201); 
        $this->assertDatabaseHas('posts', $post);
        
    }

    /** @test */
    public function a_user_can_create_a_blog_post()
    {
        # Arrange
        $users = User::factory(1)->create();
        $user = $users[0];
        $post = [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
        ];
        
        # Act
        $response = $this->actingAs($user)
                        ->withHeaders([
                            'X-CSRF-TOKEN' => csrf_token(),
                        ])
                        ->withSession(['_token' => 'akm'])
                        ->post('/createBlog', $post);

        # Assert
        $response->assertStatus(201); 
        $this->assertDatabaseHas('posts', $post);
    }
    
    /** @test */
    public function test_user_can_retrieve_single_blog_post()
    {
        // Arrange
        $users = User::factory(1)->create();
        $user = $users[0];
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        
        // Act
        $response = $this->actingAs($user)->get("/getBlogById/{$post[0]->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $post[0]->id,
            'title' => $post[0]->title,
            'body' => $post[0]->body,
        ]);
    }

    /**@test */
    public function test_user_can_update_blog_post()
    {
        // Arrange
        $users = User::factory(1)->create();
        $user = $users[0];
        $post = Post::factory(1)->create(['user_id' => $user->id]);
        $newData = [
            'title' => 'New title',
            'body' => 'New body',
        ];

        // Act
        $response = $this->actingAs($user)->put("/updateBlog/{$post[0]->id}", $newData);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', array_merge(['id' => $post[0]->id], $newData));
    }

    /**@test */
    public function test_user_can_delete_blog_post()
    {
        // Arrange
        $users = User::factory(1)->create();
        $user = $users[0];
        $post = Post::factory(1)->create(['user_id' => $user->id]);

        // Act
        $response = $this->actingAs($user)->delete("/deleteBlog/{$post[0]->id}");

        // Assert
        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post[0]->id]);
    }
}
