<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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

        $threads = factory('App\Thread', 3)->create(['user_id' => $myuser->id]);

        foreach($threads as $thread){

            DB::table('activities')->insert([
                'user_id' => $thread->user_id,
                'subject_id' => $thread->id,
                'subject_type' => 'App\Thread',
                'type' => 'created_thread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $reply = factory('App\Reply')->create([
                'thread_id' => $thread->id
            ]);
            
            DB::table('activities')->insert([
                'user_id' => $reply->user_id,
                'subject_id' => $reply->id,
                'subject_type' => 'App\Reply',
                'type' => 'created_reply',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            $reply = factory('App\Reply')->create([
                'thread_id' => $thread->id,
                'user_id' => $myuser->id
            ]);

            DB::table('activities')->insert([
                'user_id' => $reply->user_id,
                'subject_id' => $reply->id,
                'subject_type' => 'App\Reply',
                'type' => 'created_reply',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $reply = factory('App\Reply')->create([
                'thread_id' => $thread->id
            ]);

            DB::table('activities')->insert([
                'user_id' => $reply->user_id,
                'subject_id' => $reply->id,
                'subject_type' => 'App\Reply',
                'type' => 'created_reply',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            $reply = factory('App\Reply')->create([
                'thread_id' => $thread->id,
                'user_id' => $myuser->id
            ]);

            DB::table('activities')->insert([
                'user_id' => $reply->user_id,
                'subject_id' => $reply->id,
                'subject_type' => 'App\Reply',
                'type' => 'created_reply',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $other_threads = factory('App\Thread', 5)->create();

        foreach($other_threads as $thread){
            DB::table('activities')->insert([
                'user_id' => $thread->user_id,
                'subject_id' => $thread->id,
                'subject_type' => 'App\Thread',
                'type' => 'created_thread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $reply = factory('App\Reply')->create([
                'thread_id' => $thread->id
            ]);
            DB::table('activities')->insert([
                'user_id' => $reply->user_id,
                'subject_id' => $reply->id,
                'subject_type' => 'App\Reply',
                'type' => 'created_reply',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
