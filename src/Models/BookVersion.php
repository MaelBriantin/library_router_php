<?php

namespace Models;

use Core\Model;

class BookVersion extends Model
{
    protected string $table = 'book_version';
    protected string $primaryKey = 'id';
    protected array $fillable = ['book_id', 'edition_id', 'publisher_id', 'published_at'];
    protected array $foreignKeys = [
        'book_id' => Book::class,
        'edition_id' => Edition::class,
        'publisher_id' => Publisher::class
    ];
    protected array $relations= [];
}