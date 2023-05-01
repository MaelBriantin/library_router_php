<?php

namespace Core;

class QueryBuilder
{
    /**
     * @param array $fillable
     * @return string
     */
    function select(array $fillable): string
    {
        foreach ($fillable as &$element) {
            $element = "$element AS "._toCamelCase($element);
        }
        return "SELECT ".implode(', ', $fillable);
    }

    /**
     * @param $table
     * @return string
     */
    function from($table): string
    {
        return " FROM $table";
    }

    function insertInto(array$insert, array$into, $table=null): string
    {
        $table = is_null($table) ? $this->table : $table;
        return "INSERT INTO $table ";
    }


    /**
     * @param $foreignKeys
     * @return string
     */
    function join($foreignKeys, $relations): string
    {
        $result = array_merge(
            $this->joinFKeys($foreignKeys),
            $this->joinRelations($relations)
        );
        return !empty($result) ? (', '.implode(', ', $result)) : '';
    }

    /**
     * @param $foreignKeys
     * @return string
     */
    function on($foreignKeys, $relations=null): string
    {
        $result = array_merge(
            $this->onFKeys($foreignKeys),
            $this->onRelations($relations)
        );
        return !empty($result) ? (implode(' ', $result)) : '';
    }

    /**
     * @param $table
     * @param $key
     * @return string
     */
    function groupBy($table, $key): string
    {
        if (!empty($key)) {
            return " GROUP BY $table.$key";
        } else {
            return "";
        }
    }

    /**
     * @param $column
     * @param $value
     * @return string
     */
    function where($column, $value): string
    {
        return " WHERE $this->table.$column = $value";
    }

    /**
     * @param $value
     * @return array|mixed
     */
    function returnFormat($value): mixed
    {
        return !$value ? [] : $value;
    }

    function joinFKeys(array$fKeys, $joinQuery = [], $alreadyJoined = [])
    {
        foreach ($fKeys as $fKey) {
            if (in_array($fKey, $alreadyJoined)) {
                continue;
            }
            $fInstance = new $fKey;
            $fTable = $fInstance->table;
            $fFillable = $fInstance->fillable;
            $fPrimaryKey = $fInstance->primaryKey;
            $joinQuery[] = "$fTable.$fPrimaryKey AS " . singularize(_toCamelCase($fTable)) . ucfirst($fPrimaryKey);
            foreach ($fFillable as $fill) {
                $joinQuery[] = "$fTable.$fill AS " . singularize(_toCamelCase($fTable)) . ucfirst(_toCamelCase($fill));
            }
            $alreadyJoined[] = $fKey;
            if (!empty($fInstance->foreignKeys)) {
                $joinQuery = $this->joinFKeys($fInstance->foreignKeys, $joinQuery, $alreadyJoined);
            }
        }
        return $joinQuery;
    }

    function onFKeys(array$fKeys, $table=null, $joinQuery = [], $alreadyJoined = []): array
    {
        if(!empty($fKeys)) {
            foreach ($fKeys as $key => $value) {
                if (in_array($key, $alreadyJoined)) {
                    continue;
                }
                $fInstance = new $value;
                $fTable = $fInstance->table;
                $table = is_null($table) ? $this->table : $table;
                $fPrimaryKey = $fInstance->primaryKey;
                $joinQuery[] = " LEFT JOIN $fTable ON $table.$key = $fTable.$fPrimaryKey";
                $alreadyJoined[] = $key;
                if (!empty($fInstance->foreignKeys)) {
                    $joinQuery = $this->onFKeys($fInstance->foreignKeys, $fTable, $joinQuery, $alreadyJoined);
                }
            }
        }
        return $joinQuery;
    }
    function joinRelations(array$relations, $result = []): array
    {
        if(!empty($relations)) {
            foreach ($relations as $key => $value) {
                $relationTable = $key;
                $relationInstance = new $value[1];
                $relationFillable = $relationInstance->fillable;

                foreach ($relationFillable as $fill){
                    $result[] = "GROUP_CONCAT($relationTable.$fill SEPARATOR ',') AS ".$relationTable.ucfirst(_toCamelCase($fill));
                }
            }
        }
        return $result;
    }
    function onRelations($relations, $result = []): array
    {
        if (!empty($relations)) {
            foreach ($relations as $key => $value) {
                $result[] = " LEFT JOIN $value[0] ON {$this->table}.{$this->primaryKey} = $value[0].$this->table"."_"."id";
                $result[] = " LEFT JOIN $key ON $value[0].{$key}_id = {$key}.id";
            }
        }
        return $result;
    }
}