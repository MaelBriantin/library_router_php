<?php

namespace Core;

abstract class Model extends QueryBuilder
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $foreignKeys = [];
    protected array $relations= [];
    private ?\PDO $connection;
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

    function all(): bool|array
    {
        $query =
            $this->select($this->fillable)
            .$this->join($this->foreignKeys)
            .$this->from($this->table)
            .$this->on($this->foreignKeys)
            .$this->grouBy($this->table, $this->primaryKey);

        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $this->returnFormat($sql->fetchAll());
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
        return $this->returnFormat($sql->fetch());
    }

    function findAll($id)
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
        return $this->returnFormat($sql->fetchAll());
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