<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_any_user_can_see_all_published_articles(): void
    {
        Article::factory(8)->create();
        Article::factory(5)->trashed()->create();

        $this->getJson('/api/v1/news/articles')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'author',
                        'content',
                        'created_at',
                    ],
                ],
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_guest_user_can_not_see_any_articles_in_admin_area(): void
    {
        Article::factory(5)->trashed()->create();

        $this->getJson('/api/v1/admin/articles')
            ->assertStatus(401);
    }

    /**
     * A basic feature test example.
     */
    public function test_admin_user_can_access_article(): void
    {
        $this->seed();

        Sanctum::actingAs(User::where('display_name', 'Owner User')->first(), ['*']);

        $article = Article::factory()->trashed()->create();

        $this->getJson("/api/v1/admin/article/edit/{$article->id}")
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'author',
                    'content',
                    'created_at',
                ],
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_admin_user_can_see_all_articles_in_admin_area(): void
    {
        $this->seed();

        Sanctum::actingAs(User::where('display_name', 'Owner User')->first(), ['*']);

        Article::factory(5)->trashed()->create();

        $this->getJson('/api/v1/admin/articles')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'author',
                        'content',
                        'created_at',
                    ],
                ],
            ]);
    }
}
