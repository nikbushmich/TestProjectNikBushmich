<?php
declare(strict_types=1);

namespace orm;

use PDO;
use PDOException;

class Registry
{
    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    private const DBNAME = 'onlyDigitalTest';
    private const USER = 'onlyDigitalTest';
    private const PASSWORD = 'onlyDigitalTest';
    private static Registry|null $instance = null;
    private PDO|null $pdo = null;

    public function __construct()
    {
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        if (is_null($this->pdo)) {
            try {
                $dsn = "pgsql:host=postgres;dbname=" . self::DBNAME . ";options='--client_encoding=UTF8'";

                $this->pdo = new PDO($dsn, self::USER, self::PASSWORD, self::OPTIONS);
            } catch (PDOException $exception) {
                die($exception->getMessage());
            }
        }
        return $this->pdo;
    }
}
