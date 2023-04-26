<?php

namespace Models;

use Core\Model;

class Book extends Model
{
    protected string $table = 'books';
    protected string $primaryKey = 'id';
    protected array $fillable = ['author_id', 'genre_id', 'title', 'excerpt', 'published_year'];
    protected array $foreignKeys = [
        //foreign key => associated model
        'author_id' => Author::class,
        'genre_id' => Genre::class
    ];
    protected array $relations = [
        //relation table => by table
        'tags' => 'books_tags'
    ];
}