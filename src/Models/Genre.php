<?php

namespace Models;

use Core\Model;

class Genre extends Model
{
    protected string $table = 'genres';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name'];
    protected array $foreignKeys = [
        'author_id' => Author::class,
        'genres_id' => Genre::class
    ];
}