<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style/style.css">
        <title>Главная</title>
        <meta charset="UTF-8">
    </head>

    <body>
        <center>
            <h1>Главная</h1>

            <div>
                <a href="pages/add_news.php" id="link">Добавить запись</a>
                <a href="pages/edit_news.php" id="link">Редактировать запись</a>
                <a href="pages/find_news.php">Найти запись</a>
            </div>

            <div id="space"></div>

            <?php
            /**  пространство имен класса для работы с БД */
            use Model\Db;

            /** пространство имен класса подключения к БД */
            use src\Connect;

            /** пространство имен класса визуализации */
            use View\Visualisation;

            /** пространство имен класса пагинатора */
            use Paginator\Pagination;

            /** подключение классов */
            require_once 'vendor/autoload.php';

            /** объект подключения к БД */
            $connect = new Connect();

            /** объект класса DB для работы с базой */
            $db = new Db($connect);

            /** объект класса визуализации */
            $visual = new Visualisation();

            /** получение id для функции удаления записи */
            /** запуск метода удаления записи при нажатии на кнопку */
            if (isset($_GET['id']) and !empty($_GET['id'])) {
                $id = $_GET['id'];
                /** установка для id типа данных */
                settype($id, 'integer');
                $db->delete($id);
            }

            /** получение номера страницы */
            if (isset($_GET['page']) and !empty($_GET['page'])) {
                $page = $_GET['page'];
                settype($page, 'integer');
                if ($page == 0) {
                    $page = 1;
                }
            }




            /** кол-во записей которое выводится на 1 сттраницу */
            $limit = 5;

            /** получение кол-ва записей */
            $totalRowsFromTable = $db->getCountTable();

            /** объект n-ого кол-ва записей из таблицы */
            $obj = $db->getAll($page, $limit);

            /** метод вывода значений объекта на экран */
            $visual->queryVisual($obj);

            /** вызов объекта класса Pagination возвращает переменные $page, $num */
            $pagination = new Pagination();
            $arr = $pagination->paginator($page, $limit, $totalRowsFromTable);

            echo $visual->paginationVisual($arr);
            ?>

            <div id="space"></div>
        </center>
    </body>
</html>