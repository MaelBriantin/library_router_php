<?php

namespace Models;

use Core\Model;

class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    protected array $fillable = ['username', 'mail'];
    protected array $foreignKeys = [];
}