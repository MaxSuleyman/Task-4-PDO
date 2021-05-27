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
            </div>

            <div id="space"></div>

            <?php
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else $page = 1;     # получение номера страницы
            
            $id = $_GET['id'];  # получение id для функции удаления записи
            settype($id, 'integer'); # установка для id типа

            # подключение классов
            require_once 'src/Connect.php';
            require_once 'src/Db.php';

            # объект класса DB для работы с базой
            $db = new Db();

            # запуск метода удаления записи при нажатии на кнопку
            if (isset($_GET['id'])) {
                $db->delete($_GET['id']);
            }
            # вывод пагинации на главной странице
            #echo "<pre>";
            $pagination = $db->pagination($page);
            $db->selectAllRows();

            $db->printAllNews();

            echo $pagination;
            ?>

            <div id="space"></div>
        </center>
    </body>
</html>