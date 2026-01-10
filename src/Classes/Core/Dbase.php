<?php

namespace App\Classes\Core;

use PDO;
use PDOException;

class Dbase extends PDO
{
    private static ?self $instance = null;

    private const HOST     = 'localhost';
    private const USER     = 'root';
    private const PASSWORD = '';
    private const DATABASE = 'gastronomie_blog';

    private function __construct()
    {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DATABASE . ';charset=utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci",
        ];

        try {
            parent::__construct($dsn, self::USER, self::PASSWORD, $options);
        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}