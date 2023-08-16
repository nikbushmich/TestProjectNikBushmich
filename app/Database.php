<?php
declare(strict_types=1);

class Database
{
    private static ?self $instance = null;
    private ?object $query;
    private bool $error = false;
    private ?int $count;
    private \PDO $pdo;
    public array|false $results;

    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host='.Config::get('mysql.host').';dbname='.Config::get('mysql.database'), Config::get('mysql.username'), Config::get('mysql.password'));
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if(self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query(string $sql,array $params = []): object
    {
//        todo remove error
//        todo add return type oll method
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if(count($params)){
            $i = 1;
            foreach ($params as $param){
                $this->query->bindValue($i, $param);
                $i++;
            }
        }

        if(!$this->query->execute()){
            $this->error = true;
//            todo exception up method
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();

        }
        return $this;
    }

    public function error(): bool
    {
        return $this->error;
    }

    public function results(): bool|array
    {
        return $this->results;
    }

    public function count(): ?int
    {
        return $this->count;
    }

    public function get(string $table,array $where = []) :object
    {
        return $this->action('SELECT *', $table, $where);

    }

    public function delete(string $table, array $where = []) :object
    {
        return $this->action('DELETE', $table, $where);
    }

    public function action(string $action,string $table,array $where = []) :object | bool
    {
        if(count($where) === 3){
            $operators = ['>', '<', '=', '>=', '<=', ];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?;";

                if(!$this->query($sql, [$value])->error()){
                    return $this;
                }
            }

        }
        return false;
    }

    public function insert(string $table, array $fields = []) :bool
    {
        $values = '';
        foreach ($fields as $field){
            $values .= '?,';
        }
        $values = rtrim($values, ',');
        $sql = "INSERT INTO {$table} (" . '`' . implode('`, `',array_keys($fields)) . '`' . ") VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    public function update(string $table, int $id, array $fields = []) :bool
    {
        $set = '';
        foreach ($fields as $key=>$field){
            $set .= "{$key}  = ?,";
        }
        $set = rtrim($set, ',');
        $sql = "UPDATE {$table} SET {$set} WHERE user_id = {$id}";
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    public function first()
    {
        return $this->results()[0];
    }

}