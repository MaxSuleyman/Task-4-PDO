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
            /** подключение классов */
            require_once 'src/Connect.php';
            require_once 'src/Db.php';
            require_once 'VisualiseClasses/Visualisation.php';

            /** объект класса DB для работы с базой */
            $db = new Db();

            // объект класса визуализации
            $visual = new Visualisation();

            /** получение id для функции удаления записи */
            $id = $_GET['id'];

            /** установка для id типа данных*/
            settype($id, 'integer');

            /** запуск метода удаления записи при нажатии на кнопку */
            if (isset($id)) {
                $db->delete($id);
            }

            /** получение номера страницы */
            $page = $_GET['page'];

            settype($page, 'integer');

            if (isset($page)){
            }else {
                $page = 1;
            }

            /** масси содержащий результат выполнения метода пагинации */
            $arrPagination = $db->pagination($page, 5);

            /** объект n-ого кол-ва записей из таблицы */
            $obj = $db->getAll();

            // метод вывода значений объекта на экран
            $visual->queryVisual($obj);

            /** вывод в конце страницы меню навигации */
            echo $visual->paginationVisual($arrPagination);
            ?>

            <div id="space"></div>
        </center>
    </body>
</html>