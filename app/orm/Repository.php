<?php

declare(strict_types=1);

namespace orm;



class Repository
{
    protected ?bool $error = null;
    protected \PDO $pdo;
//    protected static ?self $instance = null;

    protected array $operators = ['AND', 'OR'];
//    private ?object $query;
//    private bool $error = false;
//    private ?int $count;
//    public array|false $results;

    public function __construct()
    {
        $this->pdo = Connect::make();
    }

//    public static function getInstance(): self
//    {
//        if(self::$instance === null) {
//            self::$instance = new Repository();
//        }
//        return self::$instance;
//    }


    public function findByColumn(string $table, array $where, string $operator = null): object|false
    {
        $sql = "SELECT * FROM $table WHERE ";

        if (empty($operator) && count($where) > 1) {
            throw new \Exception('неправельный запрос');
        }

        if ($operator !== null && !(in_array($operator, $this->operators,false))) {
            throw new \Exception('Неправельный запрос');
        }

        array_map(
            static function($column) use (& $sql, $operator ) {
                $sql .= "{$column}=:{$column}";

                $sql .= empty($operator)?'':" {$operator} ";
            }, array_keys($where)
        );

        $sql = trim($sql, " {$operator} ");

        $statement = $this->query($sql, $where);

        if ($this->error) {
            throw new \Exception( 'Запрос не выполнен' );
        }

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function findById(string $table, array $id): object|false
    {
        $columnId = array_key_first($id);
        $valueId = $id[$columnId];
        $sql = "SELECT * FROM $table WHERE {$columnId}=:id";

        return $this->query($sql, ['id' => $valueId]);


    }

    protected function query(string $sql,array $params = []): false|\PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        $this->error = !$statement->execute($params);

        return $statement;
    }

    public function insert(string $table, array $fields = []): void
    {
        $columnsArr =  array_keys($fields);
        $columns = trim( implode(', ', $columnsArr), ', ');
        $values = ':' . implode(', :', $columnsArr);

        $sql = "INSERT INTO {$table} ( $columns ) VALUES ( {$values} )";

        $this->query($sql, $fields);

        if ($this->error) {
            throw new \Exception( 'Запрос не выполнен' );
        }
    }

    public function update(string $table, int $id, array $fields = []) :void
    {
        $set = '';

        array_map(
            static function($column) use (& $set ) {
                $set .= "{$column}=:{$column}, ";

            }, array_keys($fields)
        );

        $set = trim($set, ', ');

        $sql = "UPDATE {$table} SET {$set} WHERE user_id = {$id}";

        $this->query($sql, $fields);

        if ($this->error) {
            throw new \Exception( 'Запрос не выполнен' );
        }
    }
//    public function query(string $sql,array $params = []): object
//    {
////        todo remove error
////        todo add return type oll method
//        $this->error = false;
//        $this->query = $this->pdo->prepare($sql);
//
//        if(count($params)){
//            $i = 1;
//            foreach ($params as $param){
//                $this->query->bindValue($i, $param);
//                $i++;
//            }
//        }
//
//        if(!$this->query->execute()){
//            $this->error = true;
////            todo exception up method
//        } else {
//            $this->results = $this->query->fetchAll(\PDO::FETCH_OBJ);
//            $this->count = $this->query->rowCount();
//
//        }
//        return $this;
//    }
//
//    public function error(): bool
//    {
//        return $this->error;
//    }
//
//    public function results(): bool|array
//    {
//        return $this->results;
//    }
//
//    public function count(): ?int
//    {
//        return $this->count;
//    }
//
//    public function get(string $table,array $where = []) :object
//    {
//        return $this->action('SELECT *', $table, $where);
//
//    }
//
//    public function delete(string $table, array $where = []) :object
//    {
//        return $this->action('DELETE', $table, $where);
//    }
//
//    public function action(string $action,string $table,array $where = []) :object | bool
//    {
//        if(count($where) === 3){
//            $operators = ['>', '<', '=', '>=', '<=', ];
//
//            $field = $where[0];
//            $operator = $where[1];
//            $value = $where[2];
//
//            if(in_array($operator, $operators)){
//                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?;";
//
//                if(!$this->query($sql, [$value])->error()){
//                    return $this;
//                }
//            }
//
//        }
//        return false;
//    }
//
//    public function insert(string $table, array $fields = []) :bool
//    {
//        $values = '';
//        foreach ($fields as $field){
//            $values .= '?,';
//        }
//        $values = rtrim($values, ',');
//        $sql = "INSERT INTO {$table} (" . '`' . implode('`, `',array_keys($fields)) . '`' . ") VALUES ({$values})";
//
//        if(!$this->query($sql, $fields)->error()) {
//            return true;
//        }
//        return false;
//    }
//
//    public function update(string $table, int $id, array $fields = []) :bool
//    {
//        $set = '';
//        foreach ($fields as $key=>$field){
//            $set .= "{$key}  = ?,";
//        }
//        $set = rtrim($set, ',');
//        $sql = "UPDATE {$table} SET {$set} WHERE user_id = {$id}";
//        if(!$this->query($sql, $fields)->error()) {
//            return true;
//        }
//        return false;
//    }
//
//    public function first()
//    {
//        return $this->results()[0];
//    }
}
