<?php

namespace Models;

use Core\Model;

class Publisher extends Model
{
    protected string $table = 'publishers';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name'];
    protected array $foreignKeys = [];
    protected array $relations = [];
}