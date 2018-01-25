<?php

use Illuminate\Database\Seeder;

class DummyDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $myuser = factory('App\User')->create([
            'name' => 'April Brown',
            'email' => 'xmenrahne@hotmail.com',
            'password' => bcrypt('test'),
        ]);

        $threads = factory('App\Thread', 5)->create(['user_id' => $myuser->id]);

        foreach($threads as $thread){
            $replies = factory('App\Reply')->create([
                'thread_id' => $thread->id
            ]);
            
            $replies = factory('App\Reply')->create([
                'thread_id' => $thread->id,
                'user_id' => $myuser->id
            ]);

            $replies = factory('App\Reply', 3)->create([
                'thread_id' => $thread->id
            ]);
            
            $replies = factory('App\Reply')->create([
                'thread_id' => $thread->id,
                'user_id' => $myuser->id
            ]);
        }

        $other_replies = factory('App\Reply', 10)->create();
    }
}
