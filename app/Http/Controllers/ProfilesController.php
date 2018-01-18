<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        //3:51 Timestamp for Video
        return view('profiles.show',[
            'profileUser' => $user,
            'threads' => $user->threads()->paginate(30)
        ]);
    }
}
