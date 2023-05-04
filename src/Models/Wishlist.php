<?php

namespace Models;

class Wishlist extends \Core\Model
{
    protected string $table = 'wishlists';
    protected string $primaryKey = 'id';
    protected array $fillable = ['user_id', 'book_version_id'];
    protected array $foreignKeys = [
        'user_id' => User::class,
        'book_version_id' => BookVersion::class,
    ];
    protected array $relations = [];
}