<?php

// класс пагинации
class Pagination
{
    private $page;
    private $total;

    public function paginator(int $page, int $num, int $totalRowsFromTable)
    {
        $this->page = $page;

        /** максимальное кол-во записей на страницу */

        /** проверка кол-ва страниц, если равно 0, то начальной странице устанавливается значение 1 */
        if ($this->page == 0) {
            $this->page = 1;
        }

        /** общее число страниц */
        $this->total = (($totalRowsFromTable - 1) / $num) + 1;

        if(empty($this->page) or $this->page < 0) {
            $this->page = 1;
        }

        /** Определяем начало сообщений для текущей страницы */
        $this->page = settype($this->page, 'integer');

        // если запрошена не существующая страница, выведет на экран сообщение об ошибке
        if ($this->page > $this->total) {
            $arr = ["Такой страницы не существует"];
        } else {
            // масси содержащий номер страницы и общее кол-во страниц для вывода записей на экран
            $arr = [$this->page, $this->total];
        }
        #echo "page=>".$this->page . "\n";
        return $arr;
    }
}