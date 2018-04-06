<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $search = request('username');

        return  User::where('username', 'LIKE', "%$search%")
            ->take(5)
            ->pluck('username');
    }
}
