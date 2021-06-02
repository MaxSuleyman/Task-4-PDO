<?php

namespace src;

// класс подключения к базе
class Connect
{
    // переменная подключения
    public $connect;

    private $host = 'localhost:3306';
    private $login = 'root';
    private $password = 'toor';
    private $base = 'test';

    // метод подключения
    public function __construct()
    {
        try {
            $this->connect = new \PDO (
                "mysql:host=$this->host;dbname=$this->base;",
                $this->login,
                $this->password
            );
        } catch (PDOException $e) {
            die("Error!: " . $e->getMessage() . "<br/>");
        }
        return $this->connect;
    }
}