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
            /** получение id для функции удаления записи */
            $id = $_GET['id'];

            /** установка для id типа */
            settype($id, 'integer');

            /** подключение классов */
            require_once 'src/Connect.php';
            require_once 'src/Db.php';
            require_once 'VisualiseClasses/PaginationVisual.php';
            require_once 'VisualiseClasses/ResultQueryVisual.php';
            #use src\Connect;
            #use src\Db;

            /** объект класса DB для работы с базой */
            $db = new Db();

            /** запуск метода удаления записи при нажатии на кнопку */
            if (isset($_GET['id'])) {
                $db->delete($_GET['id']);
            }

            /** получение номера страницы */
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            }else {
                $page = 1;
            }

            /** вывод пагинации на главной странице */
            $arrPagination = $db->pagination($page, 5);

            /** объект значений из базы */
            $obj = $db->getAll();

            // метод вывода значений объекта на экран
            new ResultQueryVisual($obj);

            /** вывод в конце страницы меню навигации */
            $pagination = new PaginationVisual($arrPagination);
            echo $pagination->pagination;
            ?>

            <div id="space"></div>
        </center>
    </body>
</html>