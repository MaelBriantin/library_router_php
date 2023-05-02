<?php

namespace Models;

use Core\Model;

class Author extends Model
{
    protected string $table = 'authors';
    protected string $primaryKey = 'id';
    protected array $fillable = ['firstname', 'lastname'];
    protected array $foreignKeys = [];
    protected array $relations = [];
}