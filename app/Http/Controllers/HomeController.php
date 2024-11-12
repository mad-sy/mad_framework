<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController
{
    public function __invoke()
    {
        return view('home.twig', [
            'name' => config('app.name'),
            'users' => User::paginate(1),
        ]);
    }
}
