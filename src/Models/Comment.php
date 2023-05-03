<?php

namespace Models;

use Core\Model;

class Comment extends Model
{
    protected string $table = 'comments';
    protected string $primaryKey = 'id';
    protected array $fillable = ['user_id', 'book_id', 'comment', 'review'];
    protected array $foreignKeys = [
        'user_id' => User::class,
        'book_id' => Book::class
    ];
    protected array $relations = [];
}