<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker){
    $title = $faker->sentence;
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'visits' => 0,
        'slug' => \Illuminate\Support\Str::slug($title),
        'locked' => false
    ];
});

$factory->define(App\Channel::class, function (Faker $faker){
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
});

$factory->define(App\Reply::class, function (Faker $faker){
    return [
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker){
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function() {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']
    ];
});
