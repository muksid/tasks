<div class="clearfix"></div><br />

<div class="container">
    <?php if ($_SESSION['username'] != 'admin') { ?>
        <a href="insert.php" class="btn btn-large btn-outline-primary"><i class="bi bi-plus-circle-fill"></i> Создать задачу</a>
    <?php } ?>
</div>

<div class="clearfix"></div><br />

<div class="container">
    <table class='table'>
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>
                    <a class="column_sort" href='?order=user_name&sort=<?php echo $sort; ?>'>Имени пользователя<span class="bi bi-sort-alpha-down"></span></a>
                </th>
                <th>
                    <a class="column_sort" href='?order=email&sort=<?php echo $sort; ?>'>Email<span class="bi bi-sort-alpha-down"></span></a>
                </th>
                <th>Текста задачи</th>
                <th>
                    <a class="column_sort" href='?order=status&sort=<?php echo $sort; ?>'>Статус<span class="bi bi-sort-alpha-down"></span></a>
                </th>
                <th colspan="2" align="center">Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php

        require_once 'models/TaskModel.php';

        $order ='user_name';

        $query = "SELECT * FROM tasks order by ".$order." ".$sort." ";

        $records_per_page=3;

        $task = new TaskModel();


        $newQuery = $task->paging($query,$records_per_page);

        $task->dataview($newQuery);
        ?>
        <tr>
            <td colspan="7" align="center">
                <nav>
                    <?php $task->paginglink($query,$records_per_page); ?>
                </nav>
            </td>
        </tr>
        </tbody>

    </table>


</div>
