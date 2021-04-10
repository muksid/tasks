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
                $ch = ($task->status == 2) ? "checked" : "";
                ?>
                <tr>
                    <td><label>Статус</label></td>
                    <td>
                        <div class="form-check">
                            <input name="status" value="2" type="checkbox" class="form-check-input" <?php echo $ch; ?>>
                            <label class="form-check-label">Выполнено</label>
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
