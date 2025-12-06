<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    private const API_TOKEN = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30';
    public function test_posts_index_dont_token(): void
    {
        $response = $this->get(route('api.posts.index'));
        $response->assertStatus(401);
    }

    public function test_posts_index_check_page_status(): void
    {
        $response = $this->withHeaders([
            'Authorization' => self::API_TOKEN,
        ])->get(route('api.posts.index'));

        $response->assertStatus(200);
    }

    public function test_posts_index(): void
    {
        $postsCount = Post::query()->count();
        $response = $this->withHeaders([
            'Authorization' => self::API_TOKEN,
        ])->get(route('api.posts.index'));
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('current_page', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('first_page_url', $data);
        $this->assertArrayHasKey('from', $data);
        $this->assertArrayHasKey('last_page', $data);
        $this->assertArrayHasKey('last_page_url', $data);
        $this->assertArrayHasKey('links', $data);
        $this->assertArrayHasKey('next_page_url', $data);
        $this->assertArrayHasKey('per_page', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('to', $data);
        $this->assertEquals($data['to'], 10);
        $this->assertEquals($data['total'], $postsCount);
    }

    public function test_posts_store(): void
    {
        $response = $this->withHeaders([
            'Authorization' => self::API_TOKEN,
        ])->post(route('api.posts.store'), [
            'content' => 'test',
            'user_id' => User::query()->first()->id,
        ]);
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(201);
        $this->assertArrayHasKey('id', $data);
        $post = Post::query()->find($data['id']);
        $this->assertEquals($post->id, $data['id']);
    }
}
