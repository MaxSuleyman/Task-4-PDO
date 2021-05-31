<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/style.css">
    <title>Добавить запись</title>
    <meta charset="UTF-8">
</head>

<body>
<center>
    <h1>Добавить запись</h1>

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
    /** подключение классов */
    require_once '../src/Connect.php';
    require_once '../src/Db.php';

    $db= new Db();

    /** вызов метода добавления записи в базу по нажатию кнопки */
    if (isset($_POST['find'])) {
        $id = $_POST['id'];
        settype($id, 'integer');

        /** массив с результатом запроса */
        /** если в таблице нет записи с указанным ID то вернет пустой массив */
        $findArray = $db->selectOneRow($id);

        /** проверка, является возвращенный массив с результатом запроса пустым */
        if (empty($findArray)) {
            /** если массив пустой выводит сообщение на экран и завершает работу скрипта */
            echo "Запись с ID = $id не найдена";
            return;
        } else {
            /** вывод данных из полученного массива на экран */
            $db->printAllNews($findArray);
        }

    }
    ?>
</center>
</body>
</html>
