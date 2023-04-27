<?php

namespace Models;

use Core\Model;

class Edition extends Model
{
    protected string $table = 'editions';
    protected string $primaryKey = 'id';
    protected array $fillable = ['name', 'format'];
    protected array $foreignKeys = [];
    protected array $relations = [];
}