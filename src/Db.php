<?php

namespace src;

use PDO;

// класс для работы с таблицами в БД
class Db
{
    // переменная подключения к БД
    public $connect;



    // метод подключения к базе
    // $dbh - объект подключения к БД
    public function __construct(object $dbh)
    {
        $this->connect = $dbh->connect;
    }

    // метод получения кол-ва записей в таблице
    public function getCountTable()
    {
        // запрос для подсчета кол-ва записей в базе
        $query = "SELECT count(`id`) FROM news";

        try {
            // переменная подготовки запроса
            $prepare = $this->connect->prepare($query);
            // выполнение запроса
            $prepare->execute();

            // массив строк по результатам запроса
            $result = $prepare->fetch(PDO::FETCH_ASSOC);

            // закрытие запроса
            $prepare->closeCursor();

            // возвращает кол-во записей в указанной таблице
            $countRows = $result['count(`id`)'];
            return $countRows;
        } catch (PDOException $e) {
            die("Произошла ошибка при получении кол-ва записей в таблице => " . $e->getMessage());
        }
    }

    // метод вывода n кол-ва записей из таблицы
    // $page - номер страницы на которой происходит вывод записей
    // $limit - кол-во выводимых на одной странице записей
    public function getAll(int $page, int $limit)
    {
        // запрос к базе
        $query = "SELECT * FROM news LIMIT :start, :limit";

        try {
            // переменная подготовки запроса
            $prepare = $this->connect->prepare($query);

            // номер записи от которого начинается вывод записей на странице
            $start = $page * $limit - $limit;

            // привязка параметров к переменным
            $prepare->bindParam('start', $start, PDO::PARAM_INT);
            $prepare->bindParam('limit', $limit, PDO::PARAM_INT);

            // выполнение запроса
            $prepare->execute();

            //  массив строк полученных из базы
            $allRowsFromTable = $prepare->fetchAll(PDO::FETCH_CLASS);

            // закрытие запроса
            $prepare->closeCursor();

            // возврат массива с результатом запроса
            return $allRowsFromTable;
        } catch (PDOException $e) {
            die("Произошла ошибка при поиске записей в таблице => " . $e->getMessage());
        }
    }

    // метод поиска записи в таблице
    // $id - ID записи по которому производится поиск в таблице
    public function getOne(int $id)
    {
        $query = "SELECT * FROM news WHERE id = :id";

        try {
            // подготовка запроса
            $prepare = $this->connect->prepare($query);
            // привязка параметров к переменным
            $prepare->bindParam('id', $id, PDO::PARAM_INT);

            // выполнение запроса
            $prepare->execute();

            // объект содержащий результат выполнения запроса
            $rowFromTable = $prepare->fetchAll(PDO::FETCH_CLASS);

            // закрытие запроса
            $prepare->closeCursor();

            return $rowFromTable;
        } catch (PDOException $e) {
            die("Произошла ошибка при поиске записи в таблице => " . $e->getMessage());
        }
    }

    //  метод удаления записи из таблицы
    // $id - ID записи по которому происходит удаления записи
    public function delete(int $id)
    {
        // массив строк полученных из базы
        $query = "DELETE FROM news WHERE id = :id";

        try {
            // Подготовка запроса
            $result = $this->connect->prepare($query);
            // привязка параметров к переменным
            $result->bindParam('id', $id, PDO::PARAM_INT);

            // выполнение запроса
            $result->execute();

            // закрытие запроса
            $result->closeCursor();
        } catch (PDOException $e) {
            die("Произошла ошибка при попытке удаления запииси => " . $e->getMessage());
        }
    }

    // метод редактирования записи в таблице
    // $title - заголовок записи для редактирования
    // $text - текст записи для редактирования
    // $id - Id записи по которому происходит поиск и редактировнаие записи
    public function edit(string $title, string $text, int $id)
    {
        // запрос к базе
        $query = "UPDATE news SET title = :title, text = :text WHERE id = :id";

        try {
            // Подготовка запроса
            $result = $this->connect->prepare($query);

            // привязка параметров запроса к переменной
            $result->bindParam('title', $title, PDO::PARAM_STR);
            $result->bindParam('text', $text, PDO::PARAM_STR);
            $result->bindParam('id', $id, PDO::PARAM_INT);

            // выполнение запроса
            $res = $result->execute();

            // закрытие запроса
            $result->closeCursor();
        } catch (PDOException $e) {
            die("Произошла ошибка при редактировании запииси => " . $e->getMessage());
        }
    }

    //  метод добавления записи в таблицу
    // $title - заголовок записи для добавления в таблицу
    // $text - текст записи для добавления в таблицу
    // ID устанавливается автоматически в БД
    public function insert(string $title, string $text)
    {
        // запрос к базе
        $query = "INSERT INTO news SET title = :title, text = :text";

        try {
            // Подготовка запроса
            $result = $this->connect->prepare($query);

            // привязка параметров запроса к переменной
            $result->bindParam('title', $title, PDO::PARAM_STR);
            $result->bindParam('text', $text, PDO::PARAM_STR);

            // выполнение запроса
            $result->execute();

            // закрытие запроса
            $result->closeCursor();
        } catch (PDOException $e) {
            die("Произошла ошибка при добавлении записи в таблицу =>" . $e->getMessage());
        }
    }
}