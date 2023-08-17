<?php

declare(strict_types=1);

namespace orm;

use PDO;
use PDOException;

class Connect
{
    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    private const DBNAME = 'onlyDigitalTest';
    private const USER = 'onlyDigitalTest';
    private const PASSWORD = 'onlyDigitalTest';


    public static function make(): PDO
    {
        try {
            $dsn = "pgsql:host=postgres;dbname=". self::DBNAME .";options='--client_encoding=UTF8'";

            return new PDO($dsn,self::USER,self::PASSWORD, self::OPTIONS);
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
