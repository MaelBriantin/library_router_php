<?php

namespace Models;

use Core\Model;

class ReadingState extends Model
{
    protected string $table = 'reading_state';
    protected string $primaryKey = 'id';
    protected array $fillable = ['state'];
    protected array $foreignKeys = [];
    protected array $relations = [];
}