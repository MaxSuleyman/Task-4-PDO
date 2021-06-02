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
                <a href="find_news.php" id="link">Найти запись</a>
            </div>

            <div id="space"></div>

            <div id="container">
                <div id="container_inner">
                    <form action="add_news.php" method="POST">

                        <p>Название заголовка</p>
                        <input type="text" name="title"><br>

                        <p>Текст новости</p>
                        <textarea name="text" id="" cols="30" rows="10"></textarea><br>

                        <button name="add" id="add_button">Добавить</button>

                    </form>
                </div>
            </div>
            <?php
            // подключение классов
            require_once '../vendor/autoload.php';

            use src\Connect;
            use src\Db;

            $connect = new Connect();
            $db= new Db($connect);

            # вызов метода добавления записи в базу по нажатию кнопки
            if (isset($_POST['add'])) {
                $title = $_POST['title'];
                $text = $_POST['text'];
                $db->insert($title, $text);
            }
            ?>
        </center>
    </body>
</html>
