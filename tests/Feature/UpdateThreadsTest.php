<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->signIn();
    }

    /** @test */
    public function unauthorized_users_man_not_update_threads()
    {
        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);

        $this->patch($thread->path())->assertStatus(403);
    }

    /** @test */
    public function a_thread_requires_a_title_and_body_to_update()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed'
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'Changed'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_can_be_updated_by_its_creator()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body'
        ]);

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('Changed', $thread->title);
            $this->assertEquals('Changed body', $thread->body);
        });
    }
}