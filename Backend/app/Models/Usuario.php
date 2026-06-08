<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = ['username', 'password'];
    protected $hidden = ['password'];
}
