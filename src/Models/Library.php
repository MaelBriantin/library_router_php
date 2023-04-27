<?php

namespace Models;

use Core\Model;

class Library extends Model
{
    protected string $table = 'libraries';
    protected string $primaryKey = 'id';
    protected array $fillable = ['user_id', 'book_version_id', 'reading_state_id'];
    protected array $foreignKeys = [
        'user_id' => User::class,
        'book_version_id' => BookVersion::class,
        'reading_state_id' => ReadingState::class
    ];
    protected array $relations = [
//          'books_tags' => ['tags', Tag::class],
//        'tags' => ['books_tags', Tag::class],
//        'publishers' => ['book_version', BookVersion::class],
//        'editions' => ['book_version', BookVersion::class]
    ];
}