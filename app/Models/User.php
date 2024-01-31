<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    protected $connection = 'mongodb';
    protected $collection = 'users';


    protected $fillable = [
        'fname','lname', 'email', 'password','phone','user_role', 'status'
    ];
}
