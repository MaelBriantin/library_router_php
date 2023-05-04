<?php

namespace Core;

abstract class Model extends QueryBuilder
{
    protected array $orderBy;
    protected int $limit;
    protected int $offset;
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

    /**
     * @param array $where [column, operator, value]
     * @param array|null $andWhere [column, operator, value]
     * @return void
     */
    function delete(array $where, array $andWhere=null): void
    {
        $query =
            "DELETE "
            . $this->from($this->table)
            . $this->where($where[0], $where[1], $where[2]);
        $query .= !is_null($andWhere) ?
             $this->andWhere($andWhere[0], $andWhere[1], $andWhere[2])
            : '';
        $sql = $this->connection->prepare($query);
        $sql->execute();
    }

    function save($data)
    {
        if (isset($data['id'])) {
            $this->set($data);
        } else {
            $this->insert($data);
        }
    }

    function insert($object)
    {
        $columns = implode(", ", array_keys($object));
        $values = implode(", ", array_fill(0, count($object), '?'));
        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $sql = $this->connection->prepare($query);
        $sql->execute(array_values($object));
    }

    function set($object)
    {
        $objectId = $object['id'];
        $data = exclude(['id'], $object);
        $query = "
        UPDATE $this->table SET ";
        $queryArray = [];
        foreach ($data as $key => $value) {
            $queryArray[] = " $key = ? ";
        }
        $query .= implode(',', $queryArray);
        $query .= " WHERE id = $objectId";
        $sql = $this->connection->prepare($query);
        $sql->execute(array_values($data));
    }

    function get($id=null, $column=null): \PDOStatement|false
    {
        $id = !is_null($id) ? $id : null;
        $column = !is_null($column) ? $column : $this->primaryKey;

        $query =
            $this->select(array_merge([$this->primaryKey], $this->fillable))
            . $this->join($this->foreignKeys, $this->relations)
            . $this->from($this->table)
            . $this->on($this->foreignKeys, $this->relations)
            . (!is_null($id) ?
                $this->where($column, '=', $id) : '')
            . $this->groupBy($this->table, $this->primaryKey);
        //dd($query);
        $query .= isset($this->orderBy) ? $this->orderBy($this->orderBy) : '';
        $query .= isset($this->limit) ? $this->limit($this->limit) : '';
        //dd($query);
        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql;
    }

    function unset($id): bool|\PDOStatement
    {
        $query =
            "DELETE "
            . $this->from($this->table)
            . $this->where($this->primaryKey, '=', $id);
        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql;
    }

    function validate($array)
    {
        $invalidKeys = array_diff($this->fillable, array_keys($array));
        //dd($invalidKeys);
        if (empty($invalidKeys)) {
            return array_intersect_key($array, array_flip($this->fillable));
        } else {
            abort(400, 'Woops...');
        }
    }

    function selectAverage(string $what, array $where, array $andWhere=null)
    {
        $query =
            "SELECT AVG($what) "
            .$this->from($this->table)
            .$this->where($where[0], $where[1], $where[2]);
        $query .= !is_null($andWhere) ? $this->andWhere($andWhere[0], $andWhere[1], $andWhere[2]) : '';
        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql->fetchColumn();
    }

    function selectCount(string $count, array $where, array $andWhere=null)
    {
        $query =
            "SELECT COUNT($count) "
            .$this->from($this->table)
            .$this->where($where[0], $where[1], $where[2]);
        $query .= !is_null($andWhere) ? $this->andWhere($andWhere[0], $andWhere[1], $andWhere[2]) : '';
        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql->fetchColumn();
    }

    public function customQuery($query)
    {
        //dd($query);
        $sql = $this->connection->prepare($query);
        $sql->execute();
        return $sql;
    }
}