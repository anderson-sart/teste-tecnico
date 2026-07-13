<?php

class User extends Model {
    protected $table = 'users';
    protected $softDelete = false;
    protected $fillable = ['username', 'password', 'is_admin'];
    protected $searchable = ['username'];
}
