<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowAllArticles(): void
    {
        $article = Article::factory()->create([]);

        $response = $this->get(route('articles.index'));

        $response
            ->assertStatus(200)
            // Looks for a string in response
            ->assertSee($article->title);

        $this->assertDatabaseHas(
            'articles',
            [
                'title' => $article->title,
                'content' => $article->content
            ]
        );
    }

    public function testShowSingleArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create(
            [
                'user_id' => $user->id
            ]
        );

        $this->followingRedirects();

        $response = $this->get(route(
            'articles.show',
            [
                'article' => $article
            ]
        ));

        $response
            ->assertStatus(200)
            ->assertSee($article->title)
            ->assertSee($article->content);

        $this->assertDatabaseHas(
            'articles',
            [
                'user_id' => $user->id,
                'title' => $article->title,
                'content' => $article->content
            ]
        );
    }

    public function testStoreNewArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->followingRedirects();

        $response = $this->post(
            route('articles.store'),
            [
                'title' => 'Example title',
                'content' => 'Example content'
            ]
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'articles',
            [
                'user_id' => $user->id,
                'title' => 'Example title',
                'content' => 'Example content'
            ]
        );
    }

    public function testCreateNewArticleAccessPage(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create(
            [
                'user_id' => $user->id
            ]
        );

        $response = $this->get(route(
            'articles.show',
            [
                'article' => $article
            ]
        ));

        $response
            ->assertStatus(200)
            ->assertSee($article->title)
            ->assertSee($article->content);
    }

    public function testDeleteArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create(
            [
                'user_id' => $user->id
            ]
        );

        $this->assertDatabaseHas(
            'articles',
            [
                'user_id' => $user->id,
                'title' => $article->title,
                'content' => $article->content
            ]
        );

        $this->followingRedirects();

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertStatus(200);

        $this->assertDatabaseMissing(
            'articles',
            [
                'user_id' => $user->id,
                'title' => $article->title,
                'content' => $article->content
            ]
        );
    }

    public function testEditArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create(
            [
                'user_id' => $user->id
            ]
        );

        $this->followingRedirects();

        $response = $this->get(route(
            'articles.edit',
            [
                'article' => $article
            ]
        ));

        $response
            ->assertStatus(200)
            ->assertSee($article->title)
            ->assertSee($article->content);
    }

    public function testUpdateArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create(
            [
                'user_id' => $user->id
            ]
        );

        $this->followingRedirects();

        $response = $this->patch(route(
            'articles.update',
            [
                'article' => $article,
            ]
        ), [
            'title' => 'Modified title',
            'content' => 'Modified content'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'articles',
            [
                'id' => $article->id,
                'user_id' => $user->id,
                'title' => 'Modified title',
                'content' => 'Modified content'
            ]
        );
    }
}
