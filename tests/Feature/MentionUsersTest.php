<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User', ['username' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create('App\User', ['username' => 'JaneDoe']);

        $this->signIn($jane);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => '@JaneDoe you are cute'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['username' => 'johndoe']);
        create('App\User', ['username' => 'johndoe2']);
        create('App\User', ['username' => 'janedoe']);

        $results = $this->json('GET', '/api/users', ['username' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
