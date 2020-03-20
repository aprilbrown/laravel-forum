<?php
namespace Tests\Feature;

use App\Trending;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingThreadsTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
     public function it_increments_a_thread_score_each_time_it_is_read()
     {
         $this->markTestSkipped();
         $this->trending = new Trending;

         $this->trending->reset();
         $this->assertEmpty($this->trending->get());

         $thread = create('App\Thread');

         $this->call('GET', $thread->path());

         $this->assertCount(1, $trending = $this->trending->get());

         $this->assertEquals($thread->title, $trending[0]->title);
     }
}
