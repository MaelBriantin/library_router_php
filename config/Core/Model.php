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

    /**
     * @return bool|array
     */
    function all(): bool|array
    {
        $sql = $this->get();
        return $this->returnFormat($sql->fetchAll());
    }

    /**
     * @param $id
     * @return array|mixed
     */
    function find($id, $column=null): mixed
    {
        $sql = $this->get($id, $column);
        return $this->returnFormat($sql->fetch());
    }

    /**
     * @param $id
     * @return array|mixed
     */
    function findAll($id, $column=null): mixed
    {
        $sql = $this->get($id, $column);
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

    public function get($id=null, $column=null): \PDOStatement|false
    {
        $id = !is_null($id) ? $id : null;
        $column = !is_null($column) ? $column : $this->primaryKey;

        $query =
            $this->select($this->fillable)
            . $this->join($this->foreignKeys, $this->relations)
            . $this->from($this->table)
            . $this->on($this->foreignKeys, $this->relations)
            . (!is_null($id) ?
                $this->where($column, $id) : '')
            . $this->groupBy($this->table, $this->primaryKey);

        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql;
    }
}