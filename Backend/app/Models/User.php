<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class User extends EloquentModel {
    protected $table    = 'users';
    protected $fillable = ['username', 'password', 'is_admin'];
    protected $hidden   = ['password'];

    public static array $searchable = ['username'];
}
