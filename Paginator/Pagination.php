<?php

// класс пагинации
class Pagination
{
    public function paginator(int $page, int $num, int $totalRowsFromTable)
    {

        /** проверка кол-ва страниц, если равно 0, то начальной странице устанавливается значение 1 */
        if ($page == 0) {
            $page = 1;
        }
        /** общее число страниц */
        $total = ((($totalRowsFromTable-1)/$num)+1);
        // откругление до целого значения
        $total = round($total, 0, PHP_ROUND_HALF_UP);

        // проверка существования страницы и ее значения
        if(empty($page) or $page < 0) {
            $page = 1;
        }

        /** Определяем начало сообщений для текущей страницы */
        #echo "total=>".$total."<br>";
        #echo "page=>".$page."<br>";
        // если запрошена не существующая страница, выведет на экран сообщение об ошибке
        if ($page > $total) {
            $arr = ["Такой страницы не существует"];
        } else {
            // масси содержащий номер страницы и общее кол-во страниц для вывода записей на экран
            $arr = [$page, $total];
        }
        #echo "total=>".$total . "\n";
        #print_r($arr);
        return $arr;
    }
}