<?php

require 'models/Task.php';
require 'models/TaskModel.php';
require_once 'config/Database.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

/**
 *
 */
class TaskController
{

    function __construct()
    {
        $this->taskConfig = new Database();
        $this->taskObj = new TaskModel($this->taskConfig);
    }

    public function taskAction()
    {
        $act = isset($_GET['act']) ? $_GET['act'] : null;
        switch ($act) {
            case 'insert':
                # code...
                $this->insert();
                break;
            case 'update':
                # code...
                $this->update();
                break;
            case 'delete':
                # code...
                $this->delete();
                break;
            case 'login':
                # code...
                $this->login();
                break;
            case 'logout':
                # code...
                $this->logout();
                break;

            default:
                # code...
                $this->tasks();
        }
    }

    // page redirection
    public function pageRedirect($url)
    {
        header('Location:' . $url);
    }

    // Validation
    public function checkValidation($task)
    {
        $noError = true;

        // User name
        if (empty($task->user_name)) {
            $task->user_name_msg = "User name is empty.";
            $noError = false;
        } else {
            $task->user_name_msg = "";
        }

        // Email
        if (empty($task->email)) {
            $task->email_msg = "Email is empty.";
            $noError = false;
        } elseif (!filter_var($task->email, FILTER_VALIDATE_EMAIL)) {
            $task->email_msg = "Invalid email.";
            $noError = false;
        } else {
            $task->email_msg = "";
        }

        // Task text
        if (empty($task->task_text)) {
            $task->task_text_msg = "Task text is empty.";
            $noError = false;
        } else {
            $task->task_text_msg = "";
        }

        return $noError;
    }

    public function insert()
    {
        try {
            $task = new Task();
            unset($_SESSION['inserted']);

            if (isset($_POST['add-btn'])) {

                $task->user_name = trim($_POST['user_name']);
                $task->email = trim($_POST['email']);
                $task->task_text = trim($_POST['task_text']);

                $chk = $this->checkValidation($task);
                if ($chk) {
                    //call insert
                    $task_id = $this->taskObj->insertTask($task);
                    if ($task_id > 0) {
                        $_SESSION['inserted'] = "Task successfully inserted";

                        $this->pageRedirect("insert.php");
                    } else {
                        $_SESSION['failure'] = "Task failed!!!";
                        $this->pageRedirect("insert.php");
                    }
                } else {
                    // session object
                    $_SESSION['task0'] = serialize($task);

                    $this->pageRedirect("insert.php");
                }

            }

        } catch (Exception $e) {

            $this->closeDB();

            throw new Exception("Error Processing Request", 1);

        }
    }

    public function update()
    {
        # code...
        try {
            if (isset($_POST['update-btn'])) {
                $task = unserialize($_SESSION['task0']);
                $task->id = trim($_POST['id']);
                $task->user_name = trim($_POST['user_name']);
                $task->email = trim($_POST['email']);
                $task->task_text = trim($_POST['task_text']);
                $task->status = $_POST['status'];

                // Validation
                $check = $this->checkValidation($task);

                if ($check) {
                    $res = $this->taskObj->updateTask($task);
                    if ($res) {
                        $_SESSION['success'] = "Task successfully updated";
                        $this->tasks();
                    } else {
                        $_SESSION['failure'] = "Task failed!!!";
                        $this->pageRedirect("update.php");
                    }
                } else {
                    $_SESSION['task0'] = serialize($task);

                    $this->pageRedirect("update.php");
                }

            } elseif (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $id = $_GET['id'];
                $row1 = $this->taskObj->get($id, null, null);

                $task = new Task();
                $task->id = $row1["id"];
                $task->user_name = $row1["user_name"];
                $task->email = $row1["email"];
                $task->task_text = $row1["task_text"];
                $task->status = $row1["status"];
                $_SESSION['task0'] = serialize($task);
                $this->pageRedirect('update.php');
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->closeDB();
            throw $e;
        }
    }

    // delete record
    public function delete()
    {
        try {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $res = $this->taskObj->deleteTask($id);
                if ($res) {
                    $_SESSION['deleted'] = "Task successfully deleted";
                    $this->pageRedirect('index.php');
                } else {
                    echo "Somthing is wrong..., try again.";
                }
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->closeDB();
            throw $e;
        }
    }

    public function tasks()
    {

        include 'header.php';

        $order = isset($_GET['order']) ? $_GET['order'] : 'user_name';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
        unset($_SESSION['inserted']);
        unset($_SESSION['error_login']);
        if (isset($_SESSION['success'])) {
            unset($_SESSION['success']);
            ?>
            <br>
            <div class="container">
                <div class="alert alert-success" role="alert">
                    Task successfully inserted
                </div>
            </div>
            <?php
        } else if (isset($_SESSION['failure'])) {
            ?>
            <br>
            <div class="container">
                <div class="alert alert-success" role="alert">
                    Error
                </div>
            </div>
            <?php
        } else if (isset($_SESSION['deleted'])) {
            unset($_SESSION['deleted']);
            ?>
            <br>
            <div class="container">
                <div class="alert alert-danger" role="alert">
                    Task successfully deleted
                </div>
            </div>
            <?php
        }

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else {
            $sort = 'ASC';
        }

        $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

        $tasks = $this->taskObj->get(0, $order, $sort);

        include 'tasks.php';
    }

    public function login()
    {
        try {
            if (isset($_POST['log-in'])) {

                if ($_REQUEST['username'] == 'admin' && $_REQUEST['password'] == '123') {

                    session_start();

                    $_SESSION['username'] = 'admin';

                    $this->pageRedirect('index.php');

                } else {
                    $_SESSION['error_login'] = 'Error login or password';
                    $this->pageRedirect('index.php');
                }

            }

        } catch (Exception $e) {

            $this->closeDB();

            throw new Exception("Error Processing Request", 1);

        }

        include 'tasks.php';
    }

    public function logout()
    {
        try {
            unset($_SESSION["username"]);
            unset($_SESSION["password"]);
            $this->tasks();
        }
        catch (Exception $exception) {
            throw new Exception("Error: ", $exception);
        }

    }

}

?>
