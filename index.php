<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style/style.css">
        <title>Новости</title>
        <meta charset="UTF-8">
    </head>

    <body>
        <center>
            <h1>Новости</h1>

            <div>
                <a href="pages/add_news.php" id="link">Добавить запись</a>
                <a href="pages/edit_news.php" id="link">Редактировать запись</a>
                <a href="pages/find_news.php">Найти запись</a>
            </div>

            <div id="space"></div>

            <?php
            /** получение номера страницы */
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else $page = 1;

            /** получение id для функции удаления записи */
            $id = $_GET['id'];

            /** установка для id типа */
            settype($id, 'integer');

            /** подключение классов */
            require_once 'src/Connect.php';
            require_once 'src/Db.php';
            #use src\Connect;
            #use src\Db;

            /** объект класса DB для работы с базой */
            $db = new Db();

            /** запуск метода удаления записи при нажатии на кнопку */
            if (isset($_GET['id'])) {
                $db->delete($_GET['id']);
            }

            /** вывод пагинации на главной странице */
            $pagination = $db->pagination($page);

            /** массив значений из базы */
            $arr = $db->selectAllRows();

            /** вывод записей на главной странице */
            $db->printAllNews($arr);

            /** вывод в конце страницы меню навигации */
            echo $pagination;
            ?>

            <div id="space"></div>
        </center>
    </body>
</html>