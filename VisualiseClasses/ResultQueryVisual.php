<?php

// класс вывода свойств объекта результата запроса на страницу
class ResultQueryVisual
{
    public function __construct($obj)
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
}