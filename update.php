<?php
require 'models/Task.php';
session_start();
$task = isset($_SESSION['task0']) ? unserialize($_SESSION['task0']) : new Task();

$dis = '';
if ($_SESSION['username'] == 'admin') {
    $dis = 'readonly';
}

require_once 'header.php';
?>
<div class="container">

    <form action="index.php?act=update" method="post">

        <table class='table table-bordered'>


            <tr>
                <td>
                    <label>Имени пользователя</label>
                </td>
                <td>
                    <div class="form-group <?php echo (!empty($task->user_name_msg)) ? 'has-error' : ''; ?>">
                        <input type='text' name='user_name' class='form-control' value="<?php echo $task->user_name; ?>" <?php echo $dis; ?>>
                        <span class="text-danger"><?php echo $task->user_name_msg;?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <td><label>Email</label></td>
                <td>
                    <div class="form-group <?php echo (!empty($task->email_msg)) ? 'has-error' : ''; ?>">
                        <input type='text' name='email' class='form-control' value="<?php echo $task->email; ?>" <?php echo $dis; ?>>
                        <span class="text-danger"><?php echo $task->email_msg;?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <td><label>Текста задачи</label></td>
                <td>
                    <div class="form-group <?php echo (!empty($task->task_text_msg)) ? 'has-error' : ''; ?>">
                        <textarea name='task_text' class='form-control'><?php echo $task->task_text; ?></textarea>
                        <span class="text-danger"><?php echo $task->task_text_msg;?></span>
                    </div>
                </td>
            </tr>

            <?php if ($_SESSION['username'] == 'admin') {
                $r0 = '';
                $r1 = 'checked';
                if ($task->status == 0){
                    $r0 = 'checked';
                    $r1 = '';
                }
                ?>
                <tr>
                    <td><label>Статус</label></td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="0" name="status" <?php echo $r0; ?>>
                            <label class="form-check-label" for="inlineRadio1">Новый</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="1" name="status" <?php echo $r1; ?>>
                            <label class="form-check-label" for="inlineRadio2">Выполнено</label>
                        </div>
                    </td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $task->id; ?>"/>
                    <button type="submit" class="btn btn-primary" name="update-btn">
                        <i class="bi bi-pencil"></i>  Изменить
                    </button>
                    <a href="index.php" class="btn btn-large btn-outline-secondary"><i class="glyphicon glyphicon-backward"></i> &nbsp; Отменить</a>
                </td>
            </tr>

        </table>
    </form>

</div>
