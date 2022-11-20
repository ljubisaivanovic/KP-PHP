<?php

namespace App\Core;

class ORM
{
    /**
     * Select all records from db
     *
     * @return array
     */
    public function all()
    {
        $prepare = $this->connection->prepare("SELECT * FROM `$this->table`");
        $prepare->execute();

        $results = $prepare->fetchAll();
        $output = [];

        foreach ($results as $result) {
            $model = new static();

            foreach ($result as $key => $value) {
                $model->$key = $value;
            }

            $output[$result['id']] = $model;
        }

        return $output;
    }

    /**
     * Select one record from db
     *
     * @param $column
     * @param $value
     * @param $comparator
     * @return $this
     */
    public function getOne($column, $value, $comparator = '=')
    {
        $value = $value instanceof RawSQL ? $value->sql : "'$value'";

        $prepare = $this->connection->prepare("SELECT * FROM `$this->table` WHERE `$column` $comparator $value;");
        $prepare->execute();

        $result = $prepare->fetch();

        foreach ($result as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * Select many data from db
     *
     * @param $column
     * @param $value
     * @param $comparator
     * @return array
     */
    public function get($column, $value, $comparator = '=')
    {
        $value = $value instanceof RawSQL ? $value->sql : "'$value'";

        $prepare = $this->connection->prepare("SELECT * FROM `$this->table` WHERE `$column` $comparator $value;");
        $prepare->execute();

        $results = $prepare->fetchAll();
        $output = [];

        foreach ($results as $result) {
            $model = new static();

            foreach ($result as $key => $value) {
                $model->$key = $value;
            }

            $output[$result->id] = $model;
        }

        return $output;
    }

    /**
     * Insert method
     *
     * @return $this
     */
    public function insert()
    {
        if (!empty($this->fillable)) {
            $columns = [];
            $values = [];

            foreach ($this->fillable as $key) {
                array_push($columns, $key);
                array_push($values, $this->$key);
            }

            $columns = "`" . implode("`,`", $columns) . "`";

            $values = array_map(function ($value) {
                return $value instanceof RawSQL ? $value->sql : "'$value'";
            }, $values);
            $values = implode(',', $values);

            $prepare = $this->connection->prepare("INSERT INTO `$this->table` ($columns) VALUES ($values);");
            $prepare->execute();

            $this->id = $this->connection->lastInsertId();
        }

        return $this;
    }
}