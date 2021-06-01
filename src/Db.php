<?php

#namespace src;

class Db
{
    /** переменная подключения к БД */
    private $connect;

    /** номер записи с которой начинается вывод записей */
    private $start;

    /** кол-во выводимых записей на 1 страницу */
    private $num;



    /** метод подключения к базе */
    public function __construct()
    {
        $connect = new Connect();
        $this->connect = $connect->connect;
    }

    /** метод получения кол-ва записей в таблице */
    public function getCountTable()
    {
        /** запрос для подсчета кол-ва записей в базе */
        $query = "SELECT count(`id`) FROM news";

        try {
            /** переменная подготовки запроса */
            $prepare = $this->connect->prepare($query);
            /** выполнение запроса */
            $prepare->execute();

            /** массив строк по результатам запроса */
            $result = $prepare->fetch(PDO::FETCH_ASSOC);

            /** закрытие запроса */
            $prepare->closeCursor();

            /** возвращает кол-во записей в указанной таблице */
            $countRows = $result['count(`id`)'];
            return $countRows;
        } catch (PDOException $e) {
            die("Произошла ошибка при получении кол-ва записей в таблице => " . $e->getMessage());
        }
    }

    /** метод вывода n кол-ва записей из таблицы */
    public function getAll(int $page, int $limit)
    {
        /** запрос к базе */
        $query = "SELECT * FROM news LIMIT :start, :limit";

        try {
            /** переменная подготовки запроса */
            $prepare = $this->connect->prepare($query);

            // номер записи от которого начинается вывод записи на странице
            $start = $page * $limit - $limit;

            // привязка параметров к переменным
            $prepare->bindParam('start', $start, PDO::PARAM_INT);
            $prepare->bindParam('limit', $limit, PDO::PARAM_INT);

            /** выполнение запроса */
            $prepare->execute();

            /**  массив строк полученных из базы */
            $allRowsFromTable = $prepare->fetchAll(PDO::FETCH_CLASS);

            /** закрытие запроса */
            $prepare->closeCursor();

            /** возврат массива с результатом запроса */
            return $allRowsFromTable;
        } catch (PDOException $e) {
            die("Произошла ошибка при поиске записей в таблице => " . $e->getMessage());
        }
    }

    /** метод поиска записи в таблице */
    public function getOne($id)
    {
        $query = "SELECT * FROM news WHERE id = :id";

        try {
            /** подготовка запроса */
            $prepare = $this->connect->prepare($query);
            // привязка параметров к переменным
            $prepare->bindParam('id', $id, PDO::PARAM_INT);

            /** выполнение запроса */
            $prepare->execute();

            /** объект содержащий результат выполнения запроса */
            $rowFromTable = $prepare->fetchAll(PDO::FETCH_CLASS);

            /** закрытие запроса */
            $prepare->closeCursor();

            return $rowFromTable;
        } catch (PDOException $e) {
            die("Произошла ошибка при поиске записи в таблице => " . $e->getMessage());
        }
    }

    /**  метод удаления записи из таблицы */
    public function delete($id)
    {
        /** массив строк полученных из базы */
        $query = "DELETE FROM news WHERE id = :id";

        try {
            /** Подготовка запроса */
            $result = $this->connect->prepare($query);
            // привязка параметров к переменным
            $result->bindParam('id', $id, PDO::PARAM_INT);

            /** выполнение запроса */
            $result->execute();

            /** закрытие запроса */
            $result->closeCursor();
        } catch (PDOException $e) {
            die("Произошла ошибка при попытке удаления запииси => " . $e->getMessage());
        }
    }

    /** метод редактирования записи в таблице */
    public function edit($title, $text, $id)
    {
        /** запрос к базе */
        $query = "UPDATE news SET title = :title, text = :text WHERE id = :id";

        try {
            // Подготовка запроса
            $result = $this->connect->prepare($query);

            // привязка параметров запроса к переменной
            $result->bindParam('title', $title, PDO::PARAM_STR);
            $result->bindParam('text', $text, PDO::PARAM_STR);
            $result->bindParam('id', $id, PDO::PARAM_INT);

            /** выполнение запроса */
            $res = $result->execute();

            /** закрытие запроса */
            $result->closeCursor();
        } catch (PDOException $e) {
            die("Произошла ошибка при редактировании запииси => " . $e->getMessage());
        }
    }

    /**  метод добавления записи в таблицу */
    public function insert($title, $text)
    {
        /** запрос к базе */
        $query = "INSERT INTO news SET title = :title, text = :text";

        try {
            /** Подготовка запроса */
            $result = $this->connect->prepare($query);

            // привязка параметров запроса к переменной
            $result->bindParam('title', $title, PDO::PARAM_STR);
            $result->bindParam('text', $text, PDO::PARAM_STR);

            /** выполнение запроса */
            $result->execute();

            /** закрытие запроса */
            $result->closeCursor();
        } catch (PDOException $e) {
            die("Произошла ошибка при добавлении записи в таблицу =>" . $e->getMessage());
        }
    }
}