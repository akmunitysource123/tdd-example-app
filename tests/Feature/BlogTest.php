<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /** @test */
    public function a_user_can_create_a_blog_post_from_api()
    {
        # Arrange
        $user = User::find(1);
        $post = [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'user_id' => $user->id
        ];
        
        
        # Act
        $response = $this->actingAs($user)->post('/api/createBlog', $post);

        # Assert
        $this->assertDatabaseHas('posts', $post);
        $response->assertStatus(201); 
    }
    /** @test */
    public function a_user_can_create_a_blog_post_from_web()
    {
        # Arrange
        $user = User::find(1);
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
        $this->assertDatabaseHas('posts', $post);
        $response->assertStatus(201); 
    }
    /** @test */
    public function test_user_can_retrieve_single_blog_post()
    {
        // Arrange
        $post = Post::factory(1)->create();

        // Act
        $response = $this->get("/getBlogById/{$post[0]->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $post[0]->id,
            'title' => $post[0]->title,
            'body' => $post[0]->body,
        ]);
    }
}
