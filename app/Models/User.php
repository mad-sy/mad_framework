<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    protected $guarded = ['id'];
}
