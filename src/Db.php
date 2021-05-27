<?php


class Db
{
    /** переменная подключения к БД */
    private $connect;


    /** номер записи с которой начинается вывод записей */
    private $start;
    /** кол-во выводимых записей на 1 страницу */
    private $num;

    /** переменная массива всех полученных записей из таблицы */
    private $allRowsFromTable;

    /** метод подключения к базе */
    public function __construct()
    {
        $connect = new Connect();
        $this->connect = $connect->connect;
    }

    /** метод получения кол-ва записей в таблице */
    private function getCountTable()
    {
        $query = "SELECT count(`id`) FROM news";     # запрос для подсчета кол-ва записей в базе

        # переменная подготовки запроса
        $prepare = $this->connect->prepare($query);
        # выполнение запроса
        $prepare->execute();

        # массив строк по результатам запроса
        $result = $prepare->fetch(PDO::FETCH_ASSOC);

        # возвращает кол-во записей в указанной таблице
        return $result['count(`id`)'];
    }

    /** метод вывода пагинации */
    public function pagination($page)
    {
        $this->num = 10;  # максимальное кол-во записей на страницу
        if ($page==0) $page=1;

        # вызов метода возвращающего кол-во записей из таблицы
        $allCountTable = $this->getCountTable();

        # общее число страниц
        $total = intval(($allCountTable - 1) / $this->num) + 1;
        # Определяем начало сообщений для текущей страницы
        $page = intval($page);
        if(empty($page) or $page < 0) {
            $page = 1;
        }
        if($page > $total) {
            $page = $total;
        }
        # вычисление стртовой страницы
        $this->start = $page * $this->num - $this->num;

        # Проверяем нужны ли стрелки назад
        if ($page != 1) {
            $pervpage = '<a href="/index.php?page=-1"><<</a>
        <a href="/index.php?page=' . ($page - 1) . '"><</a> ';
        }

        # Проверяем нужны ли стрелки вперед
        if ($page != $total) {
            $nextpage = '  <a href="/index.php?page=' . ($page + 1) . '">></a>
        <a href="/index.php?page=' . $total . '">>></a> ';
        }
        # Находим две ближайшие станицы с обоих краев, если они есть
        if($page - 2 > 0) {
            $page2left = ' <a href="/index.php?page=' . ($page - 2) . '">' . ($page - 2) . '</a>  ';
        }

        if($page - 1 > 0) {
            $page1left = '<a href="/index.php?page=' . ($page - 1) . '">' . ($page - 1) . '</a>  ';
        }

        if($page + 2 <= $total) {
            $page2right = '  <a href="/index.php?page=' . ($page + 2) . '">' . ($page + 2) . '</a>';
        }

        if($page + 1 <= $total) {
            $page1right = '  <a href="/index.php?page=' . ($page + 1) . '">' . ($page + 1) . '</a>';
        }

        if ($total>1) {
            $pagination = '<p><div align="center" class="navigation">'
                . $pervpage . $page2left . $page1left . '<span>' . $page . '</span>' . $page1right .
                $page2right . $nextpage . '</div></p>';
        }

        # вызов меода вывода записей
        #$this->selectAllRows();

        return $pagination;
    }

    /** метод вывода записей из таблицы */
    public function selectAllRows()
    {
        # запрос к базе
        $query = "SELECT * FROM news LIMIT $this->start, $this->num";

        # переменная подготовки запроса
        $prepare = $this->connect->prepare($query);

        # выполнение запроса
        $prepare->execute();

        # массив строк полученных из базы
        $this->allRowsFromTable = $prepare->fetchAll(PDO::FETCH_ASSOC);

        return $this->allRowsFromTable;
    }

    /** метод поиска записи в таблице */
    public function selectOneRow($id)
    {
        $query = "SELECT * FROM news WHERE id = ?";

        /** подготовка запроса */
        $prepare = $this->connect->prepare($query);

        /** выполнение запроса */
        $prepare->execute(array($id));

        /** массив содержащая результат выполнения запроса */
        $rowFromTable = $prepare->fetchAll(PDO::FETCH_ASSOC);

        return $rowFromTable;
    }

    /** метод вывовод записей на главной странице */
    public function printAllNews($array)
    {
        foreach ($array as $key => $value) {
            ?>
            <div id="container">
                <div id="container_inner">
                    <div id="title">
                        <?php echo $value['title']; ?>
                        <a href="../index.php?id=<?php echo $value['id']?>" name="delete" id="delete_button">Удалить</a>
                        <a name="remove" id="delete_button">ID = <?php echo $value['id']?></a>
                    </div><br>

                    <div id="content">
                        <?php echo $value['text'];?>
                    </div>
                </div>
            </div>

            <div id="space"></div>
            <?php
        }
    }

    /**  метод удаления записи из таблицы */
    public function delete($id)
    {
        # запрос к базе
        $query = "DELETE FROM news WHERE id = :id";

        # Подготовка запроса
        $result = $this->connect->prepare($query);

        # выполнение запроса
        $result->execute(array('id' => $id));
    }

    /** метод редактирования записи в таблице */
    public function edit($title, $text, $id)
    {
        # запрос к базе
        $query = "UPDATE news SET title = :title, text = :text WHERE id = :id";

        $result = $this->connect->prepare($query);    # Подготовка запроса

        $res = $result->execute(array('title' => $title, 'text' => $text, 'id' => $id));     # выполнение запроса

        if (!$res) {
            $massage =  "Ошибка при редактировании записи" . $result->error;
        } else {
            $massage = "Запись отредактирована!";
        }
        return $massage;
    }

    /**  метод добавления записи в таблицу */
    public function insert($title, $text)
    {
        # запрос к базе
        $query = "INSERT INTO news SET title = :title, text = :text";

        $result = $this->connect->prepare($query);    # Подготовка запроса

        $result->execute(array('title' => $title, 'text' => $text));     # выполнение запроса
    }
}