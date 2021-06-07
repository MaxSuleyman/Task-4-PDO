<?php

namespace View;

// класс визулизации
class Visualisation
{
    public $pagination;

    // метод вывода результата поиска в таблице на экран
    // $obj - объект данных передаваемый из методов: getAll, getOne
    public function queryVisual(array $obj)
    {
        foreach ($obj as $key => $value) {
            ?>
            <div id="container">
                <div id="container_inner">
                    <div id="title">
                        <?php echo $obj[$key]->title; ?>
                        <a href="../index.php?id=<?php echo $obj[$key]->id?>" name="delete" id="delete_button">Удалить</a>
                        <a name="remove" id="delete_button">ID = <?php echo $obj[$key]->id?></a>
                    </div><br>

                    <div id="content">
                        <?php echo $obj[$key]->text;?>
                    </div>
                </div>
            </div>

            <div id="space"></div>
            <?php
        }
    }

    // метод вывода меню навигации
    // $arr - масси содержащий номер страницы и общее кол-во страниц
    // полученное из метода pagination
    public function paginationVisual(array $arr)
    {
        if (gettype($arr[0]) == 'string') {
            return $arr[0];
        }

        // Проверяем нужны ли стрелки назад */
        if ($arr[0] != 1) {
            $pervpage = '<a href="/index.php?page=1"><<</a>
        <a href="/index.php?page=' . ($arr[0] - 1) . '"><</a> ';
        }

        // Проверяем нужны ли стрелки вперед */
        if ($arr[0] != $arr[1]) {
            $nextpage = '  <a href="/index.php?page=' . ($arr[0] + 1) . '">></a>
        <a href="/index.php?page=' . $arr[1] . '">>></a> ';
        }

        // Находим две ближайшие станицы с обоих краев, если они есть */
        if($arr[0] - 2 > 0) {
            $page2left = ' <a href="/index.php?page=' . ($arr[0] - 2) . '">' . ($arr[0] - 2) . '</a>  ';
        }

        if($arr[0] - 1 > 0) {
            $page1left = '<a href="/index.php?page=' . ($arr[0] - 1) . '">' . ($arr[0] - 1) . '</a>  ';
        }

        if($arr[0] + 2 <= $arr[1]) {
            $page2right = '  <a href="/index.php?page=' . ($arr[0] + 2) . '">' . ($arr[0] + 2) . '</a>';
        }

        if($arr[0] + 1 <= $arr[1]) {
            $page1right = '  <a href="/index.php?page=' . ($arr[0] + 1) . '">' . ($arr[0] + 1) . '</a>';
        }

        if ($arr[1] > 1) {
            $this->pagination = '<p><div align="center" class="navigation">'
                . $pervpage . $page2left . $page1left . '<span>' . $arr[0] . '</span>' . $page1right .
                $page2right . $nextpage . '</div></p>';
        }

        return $this->pagination;
    }
}