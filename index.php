<?php
session_unset();
require_once 'controllers/TaskController.php';
$taskController = new TaskController();
$taskController->taskAction();
?>
