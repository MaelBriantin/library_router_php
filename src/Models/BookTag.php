<?php

namespace Models;

use Core\Model;

class BookTag extends Model
{
    protected string $table = 'books_tags';
    protected string $primaryKey = 'id';
    protected array $fillable = ['books_id', 'tags_id'];
    protected array $foreignKeys = [
        'books_id' => Book::class,
        'tags_id' => Tag::class
    ];
    protected array $relations = [

    ];
}