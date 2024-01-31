<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'fname','lname', 'email', 'password','phone','user_role', 'status'
    ];
}
