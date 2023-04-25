<?php

namespace Core;

abstract class Model extends QueryBuilder
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $foreignKeys = [];
    private ?\PDO $connection;
    protected array $where = [];
    protected array $select = ['*'];
    protected array $joins = [];
    public function __construct(array $attributes = []) {
        $this->connection = Connection::get();
        $this->fill($attributes);
    }
    public function fill(array $attributes) {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->$key = $value;
            }
        }
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function getFillable(): array
    {
        return $this->fillable;
    }

    public function getForeignKeys(): array
    {
        return $this->foreignKeys;
    }
    function findAll(): bool|array
    {
        $query =
            $this->select($this->fillable)
            .$this->join($this->foreignKeys)
            .$this->from($this->table)
            .$this->on($this->foreignKeys)
            .$this->grouBy($this->table, $this->primaryKey);

        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql->fetchAll();
    }

    function find($id)
    {
        $query =
            $this->select($this->fillable)
            .$this->join($this->foreignKeys)
            .$this->from($this->table)
            .$this->on($this->foreignKeys)
            .$this->where($this->primaryKey, $id)
            .$this->grouBy($this->table, $this->primaryKey);

        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql->fetch();
    }

    function delete($id)
    {
        //
    }

    function save($object)
    {
        //
    }
}