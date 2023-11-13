<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Vote;

class VoteAverageTest extends TestCase
{
    use DatabaseTransactions;

    protected $article;

    protected function setUp(): void
    {
        parent::setUp();

        $this->article = Article::create([
            'title' => 'Test Article',
            'image' => 'https://picsum.photos/640/480?random=1',
            'content' => 'Test content',
            'slug' => 'test-article',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'publish_date' => now(),
        ]);

        Vote::create([
            'article_id' => $this->article->id,
            'user_id' => rand(1, 10),
            'vote' => 5,
        ]);
    }

    public function testGetUpdatedVoteAverage()
    {
        $updatedVoteAverage = $this->article->getUpdatedVoteAverage();
        $this->assertEquals(5, $updatedVoteAverage);
    }
}
