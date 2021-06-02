<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Найти запись</title>
    <meta charset="UTF-8">
</head>

<body>
<center>
    <h1>Найти запись</h1>

    <div>
        <a href="../index.php" id="link">На главную</a>
        <a href="edit_news.php" id="link">Редактировать запись</a>
        <a href="add_news.php">Добавить запись</a>
    </div>

    <div id="space"></div>

    <div id="container">
        <div id="container_inner">
            <form action="find_news.php" method="POST">

                <p>ID записи</p>
                <input type="text" name="id"><br>

                <button name="find" id="add_button">Найти</button>

            </form>
        </div>
    </div>
    <?php
    // подключение классов
    require_once '../vendor/autoload.php';

    use src\Connect;
    use src\Db;
    use VisualiseClasses\Visualisation;

    // переменная содержащая объект подключения к БД
    $connect = new Connect();
    // объект класса для работы с таблицами в БД
    $db= new Db($connect);

    /** вызов метода добавления записи в базу по нажатию кнопки */
    if (isset($_POST['find'])) {
        $id = $_POST['id'];
        settype($id, 'integer');

        /** объект с результатом запроса */
        /** если в таблице нет записи с указанным ID то вернет пустой массив */
        $findObj = $db->getOne($id);

        /** проверка, является возвращенный массив с результатом запроса пустым */
        if (empty($findObj)) {
            /** если массив пустой выводит сообщение на экран и завершает работу скрипта */
            echo "Запись с ID = $id не найдена";
            return;
        } else {
            /** вывод данных из полученного объекта на экран */
            $visual = new Visualisation();
            $visual->queryVisual($findObj);
        }
    }
    ?>
</center>
</body>
</html>
