<?php

namespace Models;

use Core\Model;

class Book extends Model
{
    protected array $orderBy = ['DESC' => 'published_year'];
    protected int $limit = 10;
    protected string $table = 'books';
    protected string $primaryKey = 'id';
    protected array $fillable = ['author_id', 'genre_id', 'title', 'excerpt', 'published_year'];
    protected array $foreignKeys = [
        'author_id' => Author::class,
        'genre_id' => Genre::class
    ];
    protected array $relations = [
        'tags' => ['books_tags', Tag::class]
    ];
}