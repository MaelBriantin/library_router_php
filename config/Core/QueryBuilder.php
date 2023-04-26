<?php

namespace Core;

class QueryBuilder
{
    function select(array $fillable): string
    {
        foreach ($fillable as &$element) {
            $element = "$element AS "._toCamelCase($element);
        }
        return "SELECT ".implode(', ', $fillable);
    }

    function from($table)
    {
        return " FROM $table";
    }
    function join($foreignKeys): string
    {
        if(!count($foreignKeys) == 0)
        {
            $result = [];
            foreach ($foreignKeys as $key => $value) {
                $foreignInstance = new $value;
                $foreignTable = $foreignInstance->table;
                $foreignFillable = $foreignInstance->fillable;
                $foreignPrimaryKey = $foreignInstance->primaryKey;
                $result[] = "$foreignTable.$foreignPrimaryKey AS ".singularize(_toCamelCase($foreignTable)).ucfirst($foreignPrimaryKey);
                foreach ($foreignFillable as $fill){
                    $result[] = "$foreignTable.$fill AS ".singularize(_toCamelCase($foreignTable)).ucfirst(_toCamelCase($fill));
                }
                unset($foreignInstance);
            }
            //dd($result);
            return ', '.implode(', ', $result);
        } else {
            return '';
        }
    }

    function on($foreignKeys): string
    {
        if(!empty($foreignKeys)) {
            $result = [];
            foreach ($foreignKeys as $key => $value) {
                $foreignInstance = new $value;
                $foreignTable = $foreignInstance->table;
                $foreignFillable = $foreignInstance->fillable;
                $foreignPrimaryKey = $foreignInstance->primaryKey;
                $result[] = " LEFT JOIN $foreignTable ON $this->table.$key = $foreignTable.$foreignPrimaryKey";
            }
            //dd(implode(' ', $result).' ');
            return implode(' ', $result);
        } else {
            return '';
        }
    }

    function grouBy($table, $key)
    {
        if (!empty($key)) {
            return " GROUP BY $table.$key";
        } else {
            return "";
        }
    }

    function where($column, $value)
    {
        return " WHERE $this->table.$column = $value";
    }

    function returnFormat($value)
    {
        return !$value ? [] : $value;
    }
}