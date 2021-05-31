<?php

#namespace src;


/** класс подключения к базе */
class Connect
{
    /** переменная подключения */
    public $connect;

    private $host = 'localhost:3306';
    private $login = 'root';
    private $password = 'toor';
    private $base = 'test';

    /** метод подключения */
    public function __construct()
    {
        try {
            $this->connect = new PDO (
                "mysql:host=$this->host;dbname=$this->base;charset=UTF8",
                $this->login,
                $this->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8")
            );
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $this->connect;
    }
}