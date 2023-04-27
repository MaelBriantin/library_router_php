<?php

namespace Models;

use Core\Model;

class Tag extends Model
{
    protected string $table = 'tags';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name'];
    protected array $foreignKeys = [];
    protected array $relations = [
        'books_tags' => ['books', Book::class]
    ];
}