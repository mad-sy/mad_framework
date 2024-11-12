<?php

namespace App\Http\Controllers;

use App\Models\User;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
    public function __invoke(ServerRequestInterface $request, array $arguments)
    {
        ['user' => $userId] = $arguments;

        $user = User::findOrFail($userId);

        return view('user.twig', [
            'user' => $user
        ]);
    }
}
