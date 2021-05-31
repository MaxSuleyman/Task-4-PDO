<?php


// класс визуалиции навигации
class PaginationVisual
{
    public $pagination;

    public function __construct($arr)
    {
        /** Проверяем нужны ли стрелки назад */
        if ($arr[0] != 1) {
            $pervpage = '<a href="/index.php?page=-1"><<</a>
        <a href="/index.php?page=' . ($arr[0] - 1) . '"><</a> ';
        }

        /** Проверяем нужны ли стрелки вперед */
        if ($arr[0] != $arr[1]) {
            $nextpage = '  <a href="/index.php?page=' . ($arr[0] + 1) . '">></a>
        <a href="/index.php?page=' . $arr[1] . '">>></a> ';
        }
        /** Находим две ближайшие станицы с обоих краев, если они есть */
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