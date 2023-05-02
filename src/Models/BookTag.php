<?php

namespace Models;

use Core\Model;

class BookTag extends Model
{
    protected string $table = 'books_tags';
    protected string $primaryKey = 'id';
    protected array $fillable = ['book_id', 'tag_id'];
    protected array $foreignKeys = [
        'book_id' => Book::class,
        'tag_id' => Tag::class
    ];
    protected array $relations = [

    ];
}