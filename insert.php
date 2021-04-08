<?php
require 'models/Task.php';

session_start();
$task = isset($_SESSION['task0']) ? unserialize($_SESSION['task0']) : new Task();

unset($_SESSION['task0']);
require_once 'header.php';

if(isset($_SESSION['inserted']))
{
    ?>
    <br>
    <div class="container">
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['inserted']; ?> <a href="index.php" class="alert-link">Task list</a>.
        </div>
    </div>
    <?php
}
else if(isset($_SESSION['failure']))
{
    ?>
    <br>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['failure']; ?>
        </div>
    </div>
    <?php
}
?>

<div class="clearfix"></div><br />

<div class="container">

    <form action="index.php?act=insert" method="post">

        <table class='table table-bordered'>

            <tr>
                <td>
                    <label>Имени пользователя</label>
                </td>
                <td>
                    <div class="form-group <?php echo (!empty($task->user_name_msg)) ? 'has-error' : ''; ?>">
                        <input type='text' name='user_name' class='form-control' value="<?php echo $task->user_name; ?>">
                        <span class="text-danger"><?php echo $task->user_name_msg;?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <td><label>Email</label></td>
                <td>
                    <div class="form-group <?php echo (!empty($task->email_msg)) ? 'has-error' : ''; ?>">
                        <input type='text' name='email' class='form-control' value="<?php echo $task->email; ?>">
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

            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-outline-primary" name="add-btn">
                        <span class="bi bi-plus-circle"></span>  Создать
                    </button>
                    <a href="index.php" class="btn btn-large btn-outline-secondary"> &nbsp; Отменить</a>
                </td>
            </tr>

        </table>
    </form>

</div>
