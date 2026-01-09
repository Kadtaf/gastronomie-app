<?php

namespace App\Classes\Core;
use PDO;
use PDOException;
//C'est un design pattern singleton. 
class Dbase extends PDO
{
    private static $instance;
    private const HOST = 'localhost';
    private const USER  = 'root';
    private const PWD = '';
    private const DATABASE = 'gastronomie_blog';
    
    /**
     * PDO::__construct — Crée une instance PDO qui représente une connexion à la base de donnée.
     *$dsn Le Data Source Name, ou DSN, qui contient les informations requises pour se connecter à la base de donnée.
     *PDO::setAttribute — Configure un attribut PDO du gestionnaire de base de données
     */

    private function __construct(){

        $dsn = 'mysql:dbname='.self::DATABASE . ';host=' . self::HOST;
        try{

            parent::__construct($dsn, self::USER, self::PWD);$this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4_general_ci');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }

    }
    public static function getInstance(): self {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}